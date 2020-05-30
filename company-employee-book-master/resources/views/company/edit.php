<?php
include(app_path().'/../resources/views/includes/header.php');
?>

<input type="hidden" id="title" name="pageName" value="edit_company" />

<div class="container">
    <div>&nbsp;</div>
</div>

<div class="container">
    <fieldset class="border mc-fieldset">
        <legend> Edit A Copmpany</legend>

            <div class="form-row">

                    <div class="form-group col-md-5">
                        <div class="form-group">
                            <form id="form_employees_to_remove" method="post" action="<?= action('CompanyController@update',$company[0]['id']) ?>">
                                <input name="_token" type="hidden" value="<?= csrf_token(); ?>">
                                <input name="_method" type="hidden" value="put">

                                <label for="employees_to_remove">&quot;<?= $company[0]['name'];?>&quot; Employees List</label>
                                <select name="employees_to_remove[]" multiple class="form-control mc-textarea-size">
                                    <?php
                                    foreach($employees_of_company as $employee){
                                        echo '<option value="'.$employee['id'].'">'.$employee['name'].'</option>';
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
                            <form id="form_employees_to_add" method="post" action="<?= action('CompanyController@update',$company[0]['id']) ?>">
                                <input name="_token" type="hidden" value="<?= csrf_token(); ?>">
                                <input name="_method" type="hidden" value="put">

                                <label for="employees_to_add">Available Employees List</label>
                                <select name="employees_to_add[]" multiple class="form-control mc-textarea-size" id="">
                                    <?php
                                    foreach($employees_not_of_company as $employee){
                                        echo '<option value="'.$employee['id'].'">'.$employee['name'].'</option>';
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

        <form id="form-edit-company" method="post" action="<?= action('CompanyController@update',$company[0]['id']) ?>">

            <input name="_token" type="hidden" value="<?= csrf_token(); ?>">
            <input name="_method" type="hidden" value="put">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input name="name" type="text" class="form-control mc-input-size" id="" placeholder="Company Name" value="<?= old('name', $company[0]['name']); ?>">
                        <div class="invalid-feedback">
                            Please provide a valid Company Name.
                            <?= $errors->first('name'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="vat_number">VAT Number</label>
                        <input name="vat_number" type="text" class="form-control mc-input-size" id="" placeholder="VAT Number" value="<?= old('vat_number', $company[0]['vat_number']); ?>">
                        <div class="invalid-feedback">
                            Please provide a valid VAT Number.
                            <?= $errors->first('vat_number'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input name="email" type="email" class="form-control mc-input-size" id="" placeholder="Email" value="<?= old('email', $company[0]['email']); ?>">
                        <div class="invalid-feedback">
                            Please provide a valid Email.
                            <?= $errors->first('email'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input name="country" type="text" class="form-control mc-input-size" id="" placeholder="Country" value="<?= old('country', $company[0]['country']); ?>">
                        <div class="invalid-feedback">
                            Please provide a valid Country.
                            <?= $errors->first('country'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="state">State</label>
                        <input name="state" type="text" class="form-control mc-input-size" id="" placeholder="State" value="<?= old('state', $company[0]['state']); ?>">
                        <div class="invalid-feedback">
                            Please provide a valid State.
                            <?= $errors->first('state'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input name="city" type="text" class="form-control mc-input-size" id="" placeholder="City" value="<?= old('city', $company[0]['city']); ?>">
                        <div class="invalid-feedback">
                            Please provide a valid City.
                            <?= $errors->first('city'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control mc-textarea-size" id="description" rows="3" placeholder="Description"><?= old('description', $company[0]['description']); ?></textarea>
                        <div class="invalid-feedback">
                            Please provide a valid Description.
                            <?= $errors->first('description'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-1">
                    <div class="form-group">
                        <label for="textarea_description_countdown">Left:</label>
                        <input disabled name="textarea_description_countdown" type="text" class="form-control mc-input-size mc-textarea-countdown" id="description_countdown" value="100">
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" class="form-control mc-textarea-size" id="address" rows="3" placeholder="Address" value=""><?= old('address', $company[0]['address']); ?></textarea>
                        <div class="invalid-feedback">
                            Please provide a valid Address.
                            <?= $errors->first('address'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-1">
                    <div class="form-group">
                        <label for="textarea_address_countdown">Left:</label>
                        <input disabled name="textarea_address_countdown" type="text" class="form-control mc-input-size mc-textarea-countdown" id="address_countdown" value="100">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="date_created">Date_Created</label>
                        <input id="datepicker" name="date_created" type="text" class="form-control mc-input-size" id="" placeholder="dd/mm/yyyy" value="<?= old('date_created', $company[0]['date_created']); ?>">
                        <div class="invalid-feedback">
                            Please provide a valid Date Format dd/mm/yyyy.
                            <?= $errors->first('date_created'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-success mc-btn-size">Save</button>
                </div>
            </div>
        </form>
    </fieldset>
</div>

<div>&nbsp;</div>

<?php
include(app_path().'/../resources/views/includes/footer.php');
?>