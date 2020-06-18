<?php
include(app_path().'/../resources/views/includes/header.php');
?>

<input type="hidden" id="title" name="pageName" value="create_company" />


<div class="container">
    <div>&nbsp;</div>
</div>

<div class="container">
    <fieldset class="border mc-fieldset">
        <legend> Add A New Copmpany</legend>
        <form id="form-create-company" method="post" action="<?= action('CompanyController@store'); ?>">

            <input name="_token" type="hidden" value="<?= csrf_token(); ?>">
            <input name="_method" type="hidden" value="post">

            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="company_name">Name</label>
                        <input name="name" type="text" class="form-control mc-input-size" id="name" placeholder="Name" value="<?= old('name');?>">
                        <div class="invalid-feedback">
                            <?= $errors->first('name'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="vat_number">VAT Number</label>
                        <input name="vat_number" type="text" class="form-control mc-input-size" id="vat_number" placeholder="VAT Number" value="<?= old('vat_number');?>">
                        <div class="invalid-feedback">
                            <?= $errors->first('vat_number'); ?>
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
                        <label for="country">Country</label>
                        <input name="country" type="text" class="form-control mc-input-size" id="country" placeholder="Country" value="<?= old('country');?>">
                        <div class="invalid-feedback">
                            <?= $errors->first('country'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="state">State</label>
                        <input name="state" type="text" class="form-control mc-input-size" id="state" placeholder="State" value="<?= old('state');?>">
                        <div class="invalid-feedback">
                            <?= $errors->first('state'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input name="city" type="text" class="form-control mc-input-size" id="city" placeholder="City" value="<?= old('city');?>">
                        <div class="invalid-feedback">
                            <?= $errors->first('city'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-5">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control mc-textarea-size" id="description" rows="3" placeholder="Description"><?= old('description');?></textarea>
                        <div class="invalid-feedback">
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
                        <textarea name="address" class="form-control mc-textarea-size" id="address" rows="3" placeholder="Address"><?= old('address');?></textarea>
                        <div class="invalid-feedback">
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
                        <input id="datepicker" name="date_created" type="text" class="form-control mc-input-size" placeholder="yyyy-mm-dd" value="<?= old('date_created'); ?>">
                        <div class="invalid-feedback">
                            <?= $errors->first('date_created'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <label for="employees">Employees List</label>
                        <select name="employees[]" multiple class="form-control mc-textarea-size" id="employees">
                            <?php
                            foreach($employees as $employee){
								$selected = '';
								old('employees') == null ? $arr_old_records = [] : $arr_old_records = old('employees');
								if(in_array($employee['id'], $arr_old_records)){
									$selected = 'selected';
								}
                                echo '<option value="'.$employee['id'].'" '.$selected.'>'.$employee['names'].'</option>';
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid Employee.
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
