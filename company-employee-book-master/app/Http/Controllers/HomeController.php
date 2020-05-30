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
        $match = $request->input('search');

        $companies_selected_page = $request->get('companiesPage');
        $employees_selected_page = $request->get('employeesPage');

        $companiesSplitPages = new DataSplitOnPage('companies', $results_per_page = 5, $companies_selected_page, $match);
        $companies_pages = $companiesSplitPages->get();
        $companiesSelectedPage = $companiesSplitPages->getSelectedPageInterval();

        $employeesSplitPages = new DataSplitOnPage('employees', $results_per_page = 2, $employees_selected_page, $match);
        $employees_pages = $employeesSplitPages->get();
        $employeesSelectedPage = $employeesSplitPages->getSelectedPageInterval();

        $company = new Company();
        $companies = $company->getList($match, $companiesSelectedPage['from'], $companiesSelectedPage['to']);
        $companies = Converter::convertObjToArr($companies);

        $employee = new Employee();
        $employees = $employee->getList($match, $employeesSelectedPage['from'], $employeesSelectedPage['to']);
        $employees = Converter::convertObjToArr($employees);

        return view('home', array('$match' => $match, 'companies' => $companies, 'employees' => $employees))->with('companies_pages', $companies_pages)->with('employees_pages', $employees_pages);
    }

}
