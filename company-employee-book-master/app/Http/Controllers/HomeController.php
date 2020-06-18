<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\Converter;
use App\DataSplitOnPage;

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

        $companies_selected_page = $request->get('companiesPage');
        $employees_selected_page = $request->get('employeesPage');

        $companiesSplitPages = new DataSplitOnPage('companies', $results_per_page = 2, $companies_selected_page, $match);
		$companies_results_per_page = $companiesSplitPages->getResultPerPage();
        $companiesSelectedPage = $companiesSplitPages->getSelectedPageInterval();		
		$companies_pages = $companiesSplitPages->get();

        $employeesSplitPages = new DataSplitOnPage('employees', $results_per_page = 2, $employees_selected_page, $match);
		$employees_results_per_page = $employeesSplitPages->getResultPerPage();
        $employeesSelectedPage = $employeesSplitPages->getSelectedPageInterval();	
		$employees_pages = $employeesSplitPages->get();

        $company = new Company();
        $companies = $company->getList($match, $companiesSelectedPage['from'], $companiesSelectedPage['to']);
        $companies = Converter::convertObjToArr($companies);

        $employee = new Employee();
        $employees = $employee->getList($match, $employeesSelectedPage['from'], $employeesSelectedPage['to']);
        $employees = Converter::convertObjToArr($employees);
//echo '<pre>';
//echo print_r($employees_pages, true);
//echo '<pre>';

        return view('home', array('$match' => $match, 'companies' => $companies, 'employees' => $employees))
				->with('companies_pages', $companies_pages)->with('companies_results_per_page', $companies_results_per_page)
				->with('employees_pages', $employees_pages)->with('employees_results_per_page', $employees_results_per_page);
    }

}
