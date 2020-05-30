<!DOCTYPE html>
<html lang="en">
<head>
    <title>
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!--DatePicker-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!--jQuery Validate-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <link rel="stylesheet" href="<?= asset('css/mc.css'); ?>" >
    <script src="<?= asset('js/mc.js'); ?>" ></script>

    <script>
        $(document).ready(function() {

            <?php
           /* BackEnd Errors*/
            if(!empty($errors->keys())){
                print('
                   $("input:not(:disabled)").addClass("is-valid");
                   $("select").addClass("is-valid");
                ');
            }
            foreach ($errors->keys() as $error_field){
                print('
                $("[name='.$error_field.']").removeClass("is-valid");
                $("[name='.$error_field.']").addClass("is-invalid");
                ');
            }
              /* BackEndErrors*/

             /* Selected Page*/
             $companies_selected_page = Request::get('companiesPage');
             $employees_selected_page = Request::get('employeesPage');
             if(!empty($companies_selected_page)){
              print('
                $("a[name^=companies_page_").removeClass();
                $("a[name=companies_page_'.$companies_selected_page.']").addClass("mc-selected-page");
                ');
             }

             if(!empty($employees_selected_page)){
              print('
                $("a[name^=employees_page_]").removeClass();
                $("a[name=employees_page_'.$employees_selected_page.']").addClass("mc-selected-page");
                ');
             }
             /* Selected Page*/
            ?>

        });
    </script>
</head>
<body>

<div class="container">
    <nav class="navbar navbar-expand-xl navbar-light mc-bg-lightblue mc-nav-menu">
        <a class="navbar-brand" href="<?= action('HomeController@index'); ?>">Companies-Employees-Book</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbar" style="">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= action('HomeController@index'); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= action('CompanyController@index'); ?>">Companies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= action('EmployeeController@index'); ?>">Employees</a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link" href="<?/*= action('CompanyController@index'); */?>">Action Edit Company</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?/*= route('company.edit',30); */?>">Route Edit Company</a>
                </li>-->
            </ul>
                <form id="search" method="get" class="form-inline my-2 my-md-0 mc-hidden-form">
                    <input disabled name="_token" type="hidden" value="<?= csrf_token(); ?>">
                    <input type="hidden" name="companiesPage" class="form-control mr-sm-2" placeholder="" aria-label="" value="<?= Request::get('companiesPage') ?: 1; ?>">
                    <input type="hidden" name="employeesPage" class="form-control mr-sm-2" placeholder="" aria-label="" value="<?= Request::get('employeesPage') ?: 1; ?>">
                    <input type="search" name="search" class="form-control mr-sm-2" placeholder="Search" aria-label="Search" value="<?= Request::get('search'); ?>">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                </form>
        </div>
    </nav>
</div>

<div class="container">
<div id="success" class="mc-success">
    <h5>
        <?= session('success'); ?>
    </h5>
</div>
</div>



