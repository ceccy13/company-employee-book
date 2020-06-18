<?php
include(app_path().'/../resources/views/includes/header.php');
?>

<input type="hidden" id="title" name="pageName" value="employees" />

<div class="container">
    <div>&nbsp;</div>
    <h2>Employees</h2>
    <div>&nbsp;</div>
    <a type="button" class="btn btn-primary mc-btn-size" href="<?= action('EmployeeController@create'); ?>" >Add</a>
    <div>&nbsp;</div>
</div>

<div class="container">
    <table class="table mc-table-striped table-hover">
        <col width="10%">
        <col width="40%">
        <col width="40%">
        <col width="10%">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Employee</th>
            <th scope="col">Number Of Companies</th>
            <th scope="col" colspan="3">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
		$row = 0;
		$page = Request::get('employeesPage');
		if(empty($page) || $page == 0) $page = 1;
        foreach($employees as $key => $employee){
			$row++;
            echo'
                <tr>
                    <td scope="row">'.($row + $page * $results_per_page - $results_per_page).'</td>
                    <td>'.$employee['names'].'</td>
                    <td>'.$employee['companies_count'].'</td>
                        <!-- Trigger the modal with a button -->
                    <td>
                        <input name="show_id" type="hidden" value="'.$employee['id'].'"/>
                        <button name="btn_ajax_show" class="btn btn-primary mc-btn-size" data-toggle="modal" data-target="#employeeModal">Show</button>
                    </td>
                    <td>
                        <a type="button" class="btn btn-primary mc-btn-size" href="'.action('EmployeeController@edit', $employee['id']).'">Edit</a>
                    </td>
                    <td>
                        <form method="post" action="'.action('EmployeeController@destroy',$employee['id']).'" >
                            <input name="_token" type="hidden" value="'.csrf_token().'">
                            <input name="_method" type="hidden" value="delete">
                            <button name="btn_delete" class="btn btn-danger mc-btn-size" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>';
        }
        ?>

        </tbody>
    </table>

    <div class="mc-pages">
        <?php
        foreach($employees_pages as $page => $records) {
            //$parameters1['companiesPage'] = Request::get('employeesPage');;
            $parameters1['employeesPage'] = $page;
            echo '
                    <span><a name="employees_page_'.$page.'" href="'.action('EmployeeController@index', $parameters1).'">'.$records['start'].'-'.$records['end'].'</a></span>
                    <span>&#124;</span>';
        }
        ?>
    </div>

    <?php
    include(app_path().'/../resources/views/employee/show.php');
    ?>

</div>

<?php
include(app_path().'/../resources/views/includes/footer.php');
?>