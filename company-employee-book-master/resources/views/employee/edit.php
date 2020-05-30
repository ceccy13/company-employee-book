<?php
include(app_path().'/../resources/views/includes/header.php');
?>

<input type="hidden" id="title" name="pageName" value="edit_employee" />

<div class="container">
    <div>&nbsp;</div>
</div>

<div class="container">
    <fieldset class="border mc-fieldset">
        <legend> Edit A Employee</legend>

        <div class="form-row">

            <div class="form-group col-md-5">
                <div class="form-group">
                    <form id="form_companies_to_remove" method="post" action="<?= action('EmployeeController@update', $employee[0]['id']) ?>">
                        <input name="_token" type="hidden" value="<?= csrf_token(); ?>">
                        <input name="_method" type="hidden" value="put">
                        <label for="companies_to_remove">&quot;<?= $employee[0]['name']; ?>&quot; Company List</label>
                        <select name="companies_to_remove[]" multiple class="form-control mc-textarea-size">
                            <?php
                            foreach($companies_of_employee as $company){
                                echo '<option value="'.$company['id'].'">'.$company['name'].'</option>';
                            }
                            ?>
                        </select>
                    </form>
                    <div class="invalid-feedback">
                        Please provide a valid Employee.
                    </div>
                </div>
            </div>
            <div class="form-group col-md-1 mc-div-content-bottom">
                <div class="form-group">
                    <button id="btn_remove" type="button" class="btn btn-danger">Del&gt;&gt;</button>
                </div>
            </div>

            <div class="form-group col-md-1 mc-div-content-bottom">
                <div class="form-group">
                    <button id="btn_add" type="button" class="btn btn-success">&lt;&lt;Add</button>
                </div>
            </div>
            <div class="form-group col-md-5">
                <div class="form-group">
                    <form id="form_companies_to_add" method="post" action="<?= action('EmployeeController@update', $employee[0]['id']) ?>">
                        <input name="_token" type="hidden" value="<?= csrf_token(); ?>">
                        <input name="_method" type="hidden" value="put">

                        <label for="companies_to_add">Available Companies List</label>
                        <select name="companies_to_add[]" multiple class="form-control mc-textarea-size" id="">
                            <?php
                            foreach($companies_not_of_employee as $company){
                                echo '<option value="'.$company['id'].'">'.$company['name'].'</option>';
                            }
                            ?>
                        </select>
                    </form>
                    <div class="invalid-feedback">
                        Please provide a valid Employee.
                    </div>
                </div>
            </div>

        </div>

        <form id="form-edit-employee" method="post" action="<?= action('EmployeeController@update', $employee[0]['id']); ?>">

            <input name="_token" type="hidden" value="<?= csrf_token(); ?>">
            <input name="_method" type="hidden" value="put">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="form-control mc-input-size" id="name" placeholder="Name" value="<?= old('name', $employee[0]['name']); ?>">
                        <div class="invalid-feedback">
                            <?= $errors->first('name'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="surname">Surname</label>
                        <input name="surname" type="text" class="form-control mc-input-size" id="surname" placeholder="Surname" value="<?= old('surname', $employee[0]['surname']); ?>">
                        <div class="invalid-feedback">
                            <?= $errors->first('surname'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" type="email" class="form-control mc-input-size" id="email" placeholder="Email" value="<?= old('email', $employee[0]['email']); ?>">
                        <div class="invalid-feedback">
                            <?= $errors->first('email'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="age">Age</label>
                        <select name="age" class="custom-select" size="1">
                            <option value="">Choose</option>
                            <?php
                            $age = 18;
                            while($age < 71){
                                $selected = '';
                                if(old('age', $employee[0]['age']) == $age) $selected = 'selected';
                                echo '<option value="'.$age.'" '.$selected.'>'.$age.' years old</option>';
                                $age++;
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $errors->first('age'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" class="custom-select" size="1">
                            <option value="">Choose</option>
                            <?php
                            $gender_array['male'] = 'male';
                            $gender_array['female'] = 'female';
                            foreach($gender_array as $gender){
                                $selected = '';
                                if(old('gender', $employee[0]['gender']) == $gender) $selected = 'selected';
                                echo '<option value="'.$gender.'" '.$selected.'>'.$gender.'</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $errors->first('gender'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="working_experience">Working Experience</label>
                        <select name="working_experience" class="custom-select" size="1">
                            <option value="">Choose</option>
                            <?php
                            $working_experience = 0;
                            while($working_experience < 53){
                                $selected = '';
                                if(old('working_experience', $employee[0]['working_experience']) == $working_experience) $selected = 'selected';
                                echo '<option value="'.$working_experience.'" '.$selected.'>'.$working_experience.' years</option>';
                                $working_experience++;
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $errors->first('working_experience'); ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <button id="btn-create" type="submit" class="btn btn-success mc-btn-size" >Save</button>
                </div>
            </div>
        </form>
    </fieldset>
</div>

<div>&nbsp;</div>

<?php
include(app_path().'/../resources/views/includes/footer.php');
?>