<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company_Employee
{
    public function normalize($request)
    {

    }

    public function validate($request, $id = null)
    {

    }

    public function getList()
    {

    }

    public function getCompanyId($id)
    {
        return DB::table('companies_employees')->where('company_id',$id)->first();
    }

    public function addCompanies($companies_to_add)
    {
        return DB::table('companies_employees')->insert($companies_to_add);
    }

    public function removeCompanies($companies_to_remove, $id)
    {
        return DB::table('companies_employees')
            ->where('employee_id', $id)
            ->whereIn('company_id', $companies_to_remove)
            ->delete();
    }

    public function getEmployeeId($id)
    {
        return DB::table('companies_employees')->where('employee_id',$id)->first();
    }

    public function addEmployees($employees_to_add)
    {
        return DB::table('companies_employees')->insert($employees_to_add);
    }

    public function removeEmloyees($employees_to_remove, $id)
    {
        return DB::table('companies_employees')
            ->where('company_id', $id)
            ->whereIn('employee_id', $employees_to_remove)
            ->delete();
    }

    public function add($request)
    {

    }

    public function edit($request, $id)
    {

    }

    public function delete($id)
    {

    }

}
