<?php
include(app_path().'/../resources/views/includes/header.php');
?>

<input type="hidden" id="title" name="pageName" value="home" />

<div class="container">
    <div class="mc-div-search">
        <label id="label_search_1">Result for</label>
        <label id="label_search_2">&quot;<?= Request::get('search'); ?>&quot;</label>

    </div>
    <div>&nbsp;</div>
    <h2>Companies</h2>
    <div>&nbsp;</div>
    <table class="table mc-table-striped">
        <col width="5%">
        <col width="45%">
        <col width="40%">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Company</th>
            <th scope="col">Number Of Employees</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($companies as $company_row => $company){
            echo'
            <tr>
            <td scope="row">'.($company_row + 1).'</td>
            <td>'.$company['name'].'</td>
            <td>'.$company['employees_count'].'</td>
            </tr>';
        }
        ?>
        </tbody>
    </table>

    <div class="mc-pages">
        <?php
        foreach($companies_pages as $page => $records) {
            $parameters1['search'] = Request::get('search');
            $parameters1['companiesPage'] = $page;
            $parameters1['employeesPage'] = Request::get('employeesPage');
            echo '
                    <span><a name="companies_page_'.$page.'" href="'.action('HomeController@index', $parameters1).'">'.$records['start'].'-'.$records['end'].'</a></span>
                    <span>&#124;</span>';
        }
        ?>
    </div>

    <div>&nbsp;</div>
    <h2>Employees</h2>
    <div>&nbsp;</div>
    <table class="table mc-table-striped">
        <col width="5%">
        <col width="45%">
        <col width="40%">
        <thead>
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Employee</th>
            <th scope="col">Number Of Companies He/She Is Working In</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($employees as $employee_row => $employee){
            echo'
                    <tr>
                        <td scope="row">'.($employee_row + 1).'</td>
                        <td>'.$employee['names'].'</td>
                        <td>'.$employee['companies_count'].'</td>
                    </tr>';
        }
        ?>
        </tbody>
    </table>

    <div class="mc-pages">
        <?php
        foreach($employees_pages as $page => $records) {
            $parameters2['search'] = Request::get('search');
            $parameters2['companiesPage'] = Request::get('companiesPage');
            $parameters2['employeesPage'] = $page;
            echo '
                    <span><a name="employees_page_'.$page.'" href="'.action('HomeController@index', $parameters2).'">'.$records['start'].'-'.$records['end'].'</a></span>
                    <span>&#124;</span>';
        }
        ?>
    </div>

</div>

<?php
include(app_path().'/../resources/views/includes/footer.php');
?>