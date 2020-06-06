<?php
include(app_path().'/../resources/views/includes/header.php');
?>

<input type="hidden" id="title" name="pageName" value="create_employee" />

<div class="container">
    <div>&nbsp;</div>
</div>

<div class="container">
    <fieldset class="border mc-fieldset">
        <legend> Add A New Employee</legend>
        <form id="form-create-employee" method="post" action="<?= action('EmployeeController@store'); ?>">

            <input name="_token" type="hidden" value="<?= csrf_token(); ?>">
            <input name="_method" type="hidden" value="post">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="form-control mc-input-size" id="name" placeholder="Name" value="<?= old('name');?>">
                        <div class="invalid-feedback">
                            <?= $errors->first('name'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="surname">Surname</label>
                        <input name="surname" type="text" class="form-control mc-input-size" id="surname" placeholder="Surname" value="<?= old('surname');?>">
                        <div class="invalid-feedback">
                            <?= $errors->first('surname'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" type="email" class="form-control mc-input-size" id="email" placeholder="Email" value="<?= old('email');?>">
                        <div class="invalid-feedback">
                            <?= $errors->first('email'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="age">Age</label>
                        <?= old('age');?>
                        <select name="age" class="custom-select" size="1">
                            <option value="">Choose</option>
                            <?php
                                $age = 18;
                                while($age < 71){
                                    $selected = '';
                                    if(old('age') == $age) $selected = 'selected';
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
                                if(old('gender') == $gender) $selected = 'selected';
                                echo '<option value="'.$gender.'" '.$selected.'>'.$gender.'</option>';
                                $age++;
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
                                if(old('working_experience') === $working_experience) $selected = 'selected';
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

                <div class="form-group col-md-6">
                    <div class="form-group">
                        &nbsp;
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="companies">Companies List</label>
                        <select name="companies[]" multiple class="form-control mc-textarea-size" id="companies">
                            <?php
                            foreach($companies as $company){
                                echo '<option value="'.$company['id'].'">'.$company['name'].'</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid Company.
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