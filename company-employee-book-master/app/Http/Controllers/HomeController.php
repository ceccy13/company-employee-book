<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\Converter;
use App\PageSplitter;

class HomeController extends Controller
{
    public function index(Request $request)
    {
		try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database! <br><br> Check settings and if DB is imported successfully! ");
        }
		
        $match = $request->input('search');

        $companies_page_selected = $request->get('companiesPage');
        $employees_page_selected = $request->get('employeesPage');

        $records_total = Company::getListCount($match);
        $companiesPageSplitter = new PageSplitter($records_total, $companies_records_per_page = 2, $companies_page_selected, $match);

		$companies_pages = $companiesPageSplitter->getPages();
        $companiesPageFrom = $companiesPageSplitter->getPageFrom();
        $companiesPageTo = $companiesPageSplitter->getPageTo();
        $companies_records_per_page = $companiesPageSplitter->getNumberRecordsPerPage();

        $records_total = Employee::getListCount($match);
        $employeesPageSplitter = new PageSplitter($records_total, $employees_records_per_page = 2, $employees_page_selected, $match);

		$employees_pages = $employeesPageSplitter->getPages();
        $employeesPageFrom = $employeesPageSplitter->getPageFrom();
        $employeesPageTo = $employeesPageSplitter->getPageTo();
        $employees_records_per_page = $employeesPageSplitter->getNumberRecordsPerPage();

        $companies = Company::getList($match, $companiesPageFrom, $companiesPageTo);
        $companies = Converter::convertObjToArr($companies);

        $employees = Employee::getList($match, $employeesPageFrom, $employeesPageTo);
        $employees = Converter::convertObjToArr($employees);

        return view('home', array('$match' => $match, 'companies' => $companies, 'employees' => $employees))
				->with('companies_pages', $companies_pages)->with('companies_records_per_page', $companies_records_per_page)
				->with('employees_pages', $employees_pages)->with('employees_records_per_page', $employees_records_per_page);
    }

}
