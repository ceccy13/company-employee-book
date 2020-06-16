<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use App\Rules\ValidatorCompanyName;
use App\Rules\ValidatorDate;
use App\Rules\ValidatorEmail;
use App\Rules\ValidatorVatNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;
use App\Company;
use App\Company_Employee;
use App\Converter;
use App\DataSplitOnPage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees_selected_page = $request->get('employeesPage');

        $employeesSplitPages = new DataSplitOnPage('employees', $results_per_page = 2, $employees_selected_page, $match = null);
        $employees_pages = $employeesSplitPages->get();
        $employeesSelectedPageInterval = $employeesSplitPages->getSelectedPageInterval();

        $employee = new Employee();
        $employees = $employee->getList($words = null, $employeesSelectedPageInterval['from'], $employeesSelectedPageInterval['to']);
        $employees = Converter::convertObjToArr($employees);

        return view('employee.index',array('employees' => $employees))->with('employees_pages', $employees_pages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = new Company();
        $companies = $company->getNames();
        $companies = Converter::convertObjToArr($companies);

        return view('employee.create',array('companies' => $companies));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = new Employee();
        $requestDataArray = $employee->normalize($request->all());
        $validator = $employee->validate($requestDataArray);

        if ($validator->fails()) {
            //Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withErrors($validator->errors())->withInput($requestDataArray);
        }
        else{
            $company_employee = new Company_Employee();
            $last_inserted_id = $employee->add($requestDataArray);
            if(!empty($request->input('companies'))){
                foreach ($request->input('companies') as $company_id) {
                    $data_array_companies_to_insert[] = ['updated_at' => now(), 'employee_id' => $last_inserted_id, 'company_id' => $company_id];
                }
                $company_employee->addEmployees($data_array_companies_to_insert);
            }
        }
        return redirect()->action('EmployeeController@index')->with('success', 'Record is created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request)
    {
        if(!$request->ajax()) {
            return redirect()->action('EmployeeController@index');
        }
        $employee = new Employee();
        $employeeData = $employee->getRecord($id);
        $companiesOfEmployee = $employee->getListCompaniesOfEmployee($id);

        return response()->json(['employee' => $employeeData, 'companies' => $companiesOfEmployee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = new Employee();

        $employeeRecord = $employee->getRecord($id);
        $employeeRecord = Converter::convertObjToArr($employeeRecord);

        $companies_of_employee = $employee->getListCompaniesOfEmployee($id);
        $companies_of_employee = Converter::convertObjToArr($companies_of_employee);
        $companies_of_employee_ids_array = array_column($companies_of_employee, 'id');

        if($companies_of_employee_ids_array[0] == null) $companies_of_employee_ids_array[0] = '';

        $companies_not_of_employee = $employee->getListCompaniesNotOfEmployee($companies_of_employee_ids_array);
        $companies_not_of_employee = Converter::convertObjToArr($companies_not_of_employee);

        return view('employee.edit',array('employee' => $employeeRecord, 'companies_not_of_employee' => $companies_not_of_employee, 'companies_of_employee' => $companies_of_employee));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company_employee = new Company_Employee();

        $is_exist_employee_id = $company_employee->getEmployeeId($id);
        $companies_to_remove = $request->input('companies_to_remove');
        $companies_to_add = $request->input('companies_to_add');

        if($is_exist_employee_id && !empty($companies_to_remove)){
            $company_employee->removeCompanies($companies_to_remove, $id);
        }
        elseif(!empty($companies_to_add)){

            foreach($companies_to_add as $company_id){
                $data_array_companies_to_insert[] = ['updated_at' => now(), 'employee_id' => $id, 'company_id' => $company_id];
            }
            $company_employee->addCompanies($data_array_companies_to_insert);
        }
        elseif(count($request->all())>3){
            $employee = new Employee();
            $requestDataArray = $employee->normalize($request->all());
            $validator = $employee->validate($requestDataArray, $id);
            if ($validator->fails()) {
                //Session::flash('error', $validator->messages()->first());
                return redirect()->back()->withErrors($validator->errors())->withInput($requestDataArray);
            }
            $employee->edit($requestDataArray, $id);
        }

        return redirect()->action('EmployeeController@edit',$id)->with('success', 'Record is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = new Employee();
        $employee->delete($id);
        return redirect()->action('EmployeeController@index')->with('success', 'Record is deleted successfully!');
    }
}
