<?php
include(app_path().'/../resources/views/includes/header.php');
?>

<input type="hidden" id="title" name="pageName" value="companies" />

<div class="container">
    <div>&nbsp;</div>
    <h2>Companies</h2>
    <div>&nbsp;</div>
    <a type="button" class="btn btn-primary mc-btn-size" href="<?= action('CompanyController@create'); ?>" >Add</a>
    <div>&nbsp;</div>
</div>

<div class="container">
    <table class="table mc-table-striped">
    <col width="10%">
    <col width="40%">
    <col width="40%">
    <col width="10%">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Company</th>
        <th scope="col">Number Of Employees</th>
        <th scope="col" colspan="3">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
        foreach($companies as $row => $company){
            echo'
                <tr>
                    <td scope="row">'.($row + 1).'</td>
                    <td>'.$company['name'].'</td>
                    <td>'.$company['employees_count'].'</td>
                        <!-- Trigger the modal with a button -->
                    <td>
                        <input name="show_id" type="hidden" value="'.$company['id'].'"/>
                        <button name="btn_ajax_show" class="btn btn-primary mc-btn-size" data-toggle="modal" data-target="#companyModal">Show</button>
                    </td>
                    <td>
                        <a type="button" class="btn btn-primary mc-btn-size" href="'.action('CompanyController@edit',$company['id']).'">Edit</a>
                    </td>
                    <td>
                        <form method="post" action="'.action('CompanyController@destroy',$company['id']).'" >
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
            foreach($companies_pages as $page => $records) {
                $parameters1['companiesPage'] = $page;
                $parameters1['employeesPage'] = Request::get('employeesPage');
                echo '
                    <span><a name="companies_page_'.$page.'" href="'.action('CompanyController@index', $parameters1).'">'.$records['start'].'-'.$records['end'].'</a></span>
                    <span>&#124;</span>';
            }
        ?>
    </div>

    <?php
    include(app_path().'/../resources/views/company/show.php');
    ?>

</div>

<?php
include(app_path().'/../resources/views/includes/footer.php');
?>

