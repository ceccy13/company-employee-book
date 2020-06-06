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


class Company
{
    public function normalize($request){
        foreach($request as $field => $value){
            if( $field == '_token' || $field == '_method' || $field == 'vat_number' ||
                $field == 'email' || $field =='date_created' || $field == 'employees' ) continue;
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
        $unique = Rule::unique('companies')->ignore($id);
        return Validator::make($request, [
            'name' => ['bail', 'required', 'min:3', 'max:50', $unique, new ValidatorCompanyName()],
            'vat_number' => ['bail', 'required', new ValidatorVatNumber()],
            'email' => ['bail', 'required', 'max:50', $unique, new ValidatorEmail(), 'email'],
            'country' => 'bail|required|string|min:3|max:50',
            'state' => 'bail|required|string|min:3|max:50',
            'city' => 'bail|required|string|min:3|max:50',
            'description' => 'bail|required|string|min:3|max:100',
            'address' => 'bail|required|string|min:3|max:100',
            'date_created' => ['bail', 'required', new ValidatorDate()],
        ]);
    }

    public function getList($match = null, $pageFrom = null, $pageTo = null){
        if($pageFrom != null) $pageFrom = $pageFrom -1;

        return DB::table('companies')
            ->leftJoin('companies_employees', 'companies.id', '=', 'companies_employees.company_id')
            ->select('companies.id', 'companies.name', DB::raw('count(companies_employees.employee_id) as employees_count'))
            ->groupBy('companies.name')
            ->where('name', 'like', '%'.$match.'%')
            ->orderBy('companies.created_at', 'desc')
            ->get()
            ->skip($pageFrom)
            ->take($pageTo);
    }

    public function getListEmployeesOfCompany($company_id){
        return DB::table('companies')
            ->leftJoin('companies_employees', 'companies.id', '=', 'companies_employees.company_id')
            ->leftJoin('employees', 'companies_employees.employee_id', '=', 'employees.id')
            ->select('companies.id','employees.id', DB::raw('CONCAT(employees.name, " ",employees.surname) as names'))
            ->where('companies.id', '=', $company_id)
            ->orderBy('companies.created_at', 'desc')
            ->get();
    }

    public function getListEmployeesNotOfCompany($employees_of_company_ids_array){
        return DB::table('employees')
            ->select('id', 'name')
            ->whereNotIn('id', $employees_of_company_ids_array)
            ->get();
    }

    public function getNames(){
        return DB::table('companies')
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getRecord($id){
        return DB::table('companies')
            ->select('*')
            ->where('id',$id)
            ->get();
    }

    public function add($request){
        return DB::table('companies')->insertGetId([
            'created_at' => now(),
            'name' => $request['name'],
            'vat_number' => $request['vat_number'],
            'email' => $request['email'],
            'country' => $request['country'],
            'state' => $request['state'],
            'city' => $request['city'],
            'description' => $request['description'],
            'address' => $request['address'],
            'date_created' => $request['date_created']
        ]);
    }

    public function edit($request, $id){
        return DB::table('companies')
            ->where('id', $id)
            ->update([
                'updated_at' => now(),
                'name' => $request['name'],
                'vat_number' => $request['vat_number'],
                'email' => $request['email'],
                'country' => $request['country'],
                'state' => $request['state'],
                'city' => $request['city'],
                'description' => $request['description'],
                'address' => $request['address'],
                'date_created' => $request['date_created']
            ]);
    }

    public function delete($id){
        DB::table('companies')->where('id',$id)->delete();
        DB::table('companies_employees')->where('company_id',$id)->delete();
    }

}
