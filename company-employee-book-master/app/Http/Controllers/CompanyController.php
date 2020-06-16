<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Rules\ValidatorCompanyName;
use App\Rules\ValidatorDate;
use App\Rules\ValidatorEmail;
use App\Rules\ValidatorVatNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule;
use App\Company_Employee;
use App\Employee;
use App\Converter;
use App\DataSplitOnPage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies_selected_page = $request->get('companiesPage');

        $companiesSplitPages = new DataSplitOnPage('companies', $results_per_page = 2, $companies_selected_page, $match = null);
        $companies_pages = $companiesSplitPages->get();
        $companiesSelectedPageInterval = $companiesSplitPages->getSelectedPageInterval();

        $company = new Company();
        $companies = $company->getList($words = null, $companiesSelectedPageInterval['from'], $companiesSelectedPageInterval['to']);
        $companies = Converter::convertObjToArr($companies);

        return view('company.index',array('companies' => $companies))->with('companies_pages', $companies_pages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = new Employee();
        $employees = $employee->getNames();
        $employees = Converter::convertObjToArr($employees);

        return view('company.create',array('employees' => $employees));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = new Company();
        $requestDataArray = $company->normalize($request->all());
        $validator = $company->validate($requestDataArray);

        if ($validator->fails()) {
            //Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withErrors($validator->errors())->withInput($requestDataArray);
        }
        else{
            $company_employee = new Company_Employee();
            $last_inserted_id = $company->add($requestDataArray);
            if(!empty($request->input('employees'))){
                foreach ($request->input('employees') as $employee_id) {
                    $data_array_employees_to_insert[] = ['updated_at' => now(), 'company_id' => $last_inserted_id, 'employee_id' => $employee_id];
                }
                $company_employee->addEmployees($data_array_employees_to_insert);
            }
        }
        return redirect()->action('CompanyController@index')->with('success', 'Record is created successfully!');
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
            return redirect()->action('CompanyController@index');
        }
         $company = new Company();
         $companyData = $company->getRecord($id);
         $employeesOfCompany = $company->getListEmployeesOfCompany($id);

         return response()->json(['company' => $companyData, 'employees' => $employeesOfCompany]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = new Company();

        $companyRecord = $company->getRecord($id);
        $companyRecord = Converter::convertObjToArr($companyRecord);

        $employees_of_company = $company->getListEmployeesOfCompany($id);
        $employees_of_company = Converter::convertObjToArr($employees_of_company);
        $employees_of_company_ids_array = array_column($employees_of_company, 'id');

        if($employees_of_company_ids_array[0] == null) $employees_of_company_ids_array[0] = '';

        $employees_not_of_company = $company->getListEmployeesNotOfCompany($employees_of_company_ids_array);
        $employees_not_of_company = Converter::convertObjToArr($employees_not_of_company);

        return view('company.edit',array('company' => $companyRecord, 'employees_not_of_company' => $employees_not_of_company, 'employees_of_company' => $employees_of_company));
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

        $is_exist_company_id = $company_employee->getCompanyId($id);
        $employees_to_remove = $request->input('employees_to_remove');
        $employees_to_add = $request->input('employees_to_add');

        if($is_exist_company_id && !empty($employees_to_remove)){
            $company_employee->removeEmloyees($employees_to_remove, $id);
        }
        elseif(!empty($employees_to_add)){
            foreach($employees_to_add as $employee_id){
                $data_array_employees_to_insert[] = ['updated_at' => now(), 'company_id' => $id, 'employee_id' => $employee_id];
            }
            $company_employee->addEmployees($data_array_employees_to_insert);
        }
        elseif(count($request->all())>3){
            $company = new Company();
            $requestDataArray = $company->normalize($request->all());
            $validator = $company->validate($requestDataArray, $id);
            if ($validator->fails()) {
                //Session::flash('error', $validator->messages()->first());
                return redirect()->back()->withErrors($validator->errors())->withInput($requestDataArray);
            }
            $company->edit($requestDataArray, $id);
        }

        return redirect()->action('CompanyController@edit',$id)->with('success', 'Record is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = new Company();
        $company->delete($id);
        return redirect()->action('CompanyController@index')->with('success', 'Record is deleted successfully!');
    }
}
