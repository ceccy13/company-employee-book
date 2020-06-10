<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\ValidatorCompanyName;
use App\Rules\ValidatorVatNumber;
use App\Rules\ValidatorEmail;
use App\Rules\ValidatorDate;

class Employee
{
    public function normalize($request){
        foreach($request as $field => $value){
            if( $field != 'name' && $field != 'surname') continue;
            $value = trim($value);
            //Премахваме празните полета,където са повече от едно между думите в низа, ако има такива
            $value = preg_replace('#[\s]+#', ' ', $value);
            //Преобразува всяка дума да започва с главна буква, останалите са малки (за кирилица и латиница)
            $value = mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
            //Преобразува само първата буква от низа на главна (за кирилица и латиница)
            $value = mb_strtoupper(mb_substr($value, 0, 1)).mb_substr($value, 1);

            $request[$field] = $value;
        }

        return $request;
    }

    public function validate($request, $id = null){
        $unique = Rule::unique('employees')->ignore($id);
        return Validator::make($request, [
            'name' => 'bail|required|string|min:2|max:50',
            'surname' => 'bail|required|string|min:2|max:50',
            'email' => ['bail', 'required', 'max:50', $unique, new ValidatorEmail(), 'email'],
            'age' => 'bail|required|numeric|min:18|max:70',
            'gender' => 'bail|required|string|in:male,female',
            'working_experience' => 'bail|required|numeric|min:0|max:52',
        ]);
    }

    public function getList($match = null, $pageFrom = null, $pageTo = null){
        if($pageFrom != null) $pageFrom = $pageFrom -1;

        return DB::table('employees')
            ->leftJoin('companies_employees', 'employees.id', '=', 'companies_employees.employee_id')
            ->select('employees.id', DB::raw('CONCAT(employees.name, " ",employees.surname) as names'), DB::raw('count(companies_employees.company_id) as companies_count'))
            ->groupBy('employees.name')
            ->where('name', 'like', '%'.$match.'%')
            ->orderBy('employees.created_at', 'desc')
            ->get()
            ->skip($pageFrom)
            ->take($pageTo);
    }

    public function getListCompaniesOfEmployee($employee_id){
        return DB::table('employees')
            ->leftJoin('companies_employees', 'employees.id', '=', 'companies_employees.employee_id')
            ->leftJoin('companies', 'companies_employees.company_id', '=', 'companies.id')
            ->select('employees.id','companies.id', 'companies.name')
            ->where('employees.id', '=', $employee_id)
            ->orderBy('employees.created_at', 'desc')
            ->get();
    }

    public function getListCompaniesNotOfEmployee($companies_of_employee_ids_array){
        return DB::table('companies')
            ->select('id', 'name')
            ->whereNotIn('id', $companies_of_employee_ids_array)
            ->get();
    }

    public function getNames(){
        return DB::table('employees')
                ->select('id', DB::raw('CONCAT(employees.name, " ",employees.surname) as names'))
                ->orderBy('name', 'asc')
                ->get();
    }

    public function getRecord($id){
        return DB::table('employees')
            ->select('*')
            ->where('id',$id)
            ->get();
    }

    public function add($request){
        return DB::table('employees')->insertGetId([
            'created_at' => now(),
            'name' => $request['name'],
            'surname' => $request['surname'],
            'email' => $request['email'],
            'age' => $request['age'],
            'gender' => $request['gender'],
            'working_experience' => $request['working_experience']
        ]);
    }

    public function edit($request, $id){
        return DB::table('employees')
            ->where('id', $id)
            ->update([
                'updated_at' => now(),
                'name' => $request['name'],
                'surname' => $request['surname'],
                'email' => $request['email'],
                'age' => $request['age'],
                'gender' => $request['gender'],
                'working_experience' => $request['working_experience']
            ]);
    }

    public function delete($id){
        DB::table('employees')->where('id',$id)->delete();
        DB::table('companies_employees')->where('employee_id',$id)->delete();
    }
}
