function limitText(limitField, limitCount, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    } else {
        limitCount.value = limitNum - limitField.value.length;
    }
}

function getObjData(obj){
    var objArr = {};
    var row = 1;
    $.each( obj, function( key, val ) {
        obj = val;
        $.each(obj, function (i) {
            $.each(obj[i], function (key, val) {
                if (key.indexOf('id') != -1 || val == null) return true;
                objArr['#' + (row++) + ' ' + key] = val;
            });
        });
    });
    return objArr;
}

function createTableRowWithTwoCells(cell1, cell2){
    var tr = $('<tr><td style="font-weight:bold">'+ cell1 +'</td><td>'+ cell2 +'</td></tr>');
    tr.appendTo($("#tbl tbody"));
}

<!--DatePicker-->
$( function() {
    //$( "#datepicker" ).datepicker();
    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
} );
<!--DatePicker-->

<!--Document On Ready-->
$(document).ready(function() {
    /*Header Include*/
    var title = $("#title").val().trim();
    switch(title) {
        case 'home':
            $('li:contains("Home")').addClass('active');
            $('title').text('Home');
            $('#search').show();
            break;
        case 'companies':
            $('li:contains("Companies")').addClass('active');
            $('title').text('Companies');
            break;
        case 'employees':
            $('li:contains("Employees")').addClass('active');
            $('title').text('Employees');
            break;
        case 'create_company':
            $('title').text('Create_Company');
            break;
        case 'edit_company':
            $('title').text('Edit_Company');
            break;
        case 'create_employee':
            $('title').text('Create_Employee');
            break;
        case 'edit_employee':
            $('title').text('Edit_Employee');
            break;
        default:
        // code block
    }
    /*Header Include*/

    /*Page Home*/
    if($("#label_search_2").text().length > 2){
        $('#label_search_1').show();
        $('#label_search_2').show();
    }
    else{
        $('#label_search_1').hide();
        $('#label_search_2').hide();
    };
    /*Page Home*/

    /*Page Show With Ajax*/
    $('button[name="btn_ajax_show"]').click(function(){
        var id = $(this).parent().find('input').val();
        var page = null;
        var protocol = window.location.protocol;
        var host = window.location.host;
        var currentLocationPathName = window.location.pathname;
        $.ajax({
            //url: "http://localhost/company-employee-book/public/" + route + "/" + id,
            url: protocol + "//" + host + currentLocationPathName + "/" + id,
            type: 'get',
            dataType: 'text',
            success: function( _response ){
                // Handle your response..
                var obj = $.parseJSON( _response );
                objArr = getObjData(obj);
                $.each( objArr, function( key, val ) {
                    createTableRowWithTwoCells(key, val);
                });
            },
          /*  error: function( _response ){
                alert( _response );
                // Handle error
            }*/
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.responseText);
                alert(xhr.status);
                alert(ajaxOptions);
                alert(thrownError);
            }
        });
    });

    $('#btn_x').on('click', function(){
            $('#tbl tbody').empty();
        }
    );

    $('#btn_close').on('click', function(){
            $('#tbl tbody').empty();
        }
    );
    /*Page Show With Ajax*/

    /*Selected Page*/
    $('div span a').removeClass('mc-selected-page');
    $('div').find('span:nth-child(1)').find('a').addClass('mc-selected-page');

    $('div span a').on('click', function(){
            $('div span a').removeClass('mc-selected-page');
            $(this).addClass('mc-selected-page');
        }
    );
    /*Selected Page*/

    /*Page Create and Edit*/
    $('div span:last-child').text('');

    $('[multiple] option').mousedown(function(e) {
        e.preventDefault();
        $(this).toggleClass('selected');

        $(this).prop('selected', !$(this).prop('selected'));
        return false;
    });

    $('#btn_add').click(function(){
        if($('select[name="employees_to_add[]"] option:selected').val()) $('#form_employees_to_add').submit();
        if($('select[name="companies_to_add[]"] option:selected').val()) $('#form_companies_to_add').submit();
    });
    $('#btn_remove').click(function(){
        if($('select[name="employees_to_remove[]"] option:selected').val()) $('#form_employees_to_remove').submit();
        if($('select[name="companies_to_remove[]"] option:selected').val()) $('#form_companies_to_remove').submit();
    });
    /*Page Create and Edit*/

    /*Page Edit*/
     $('button[name="btn_delete"]').on('click', function(){
        return confirm('Do You Want To Remove This Record?');
     }
     );
    /*Page Edit*/

    /*Validate Form Company*/
    function isValidDate(date){
        return !isNaN(Date.parse(date));
    }

    $.validator.addMethod("regex", function(value, element, regexpr) {
        return regexpr.test(value);
    }, 'error1');

    $.validator.addMethod("check_vat_number", function(value, element, check) {
        regexpr1 = /([A-Z0-9]{2}[B]{1}[0-9]{4}[^\w\sА-я/\\b]{1}[A-Z0-9]{1}[0-2]{1})/;
        regexpr2 = /^[A-Z0-9]{3}[0-9]{5}[A-Z0-9]{1}[0-2]{1}$/;
        return regexpr1.test(value) || regexpr2.test(value) &&
            value.slice(1, -8) != value.slice(8, -1) &&
            value.slice(0, -9) != value.slice(8, -1);
    }, 'error2');

    $.validator.addMethod("check_date", function(value, element, check) {
        if(check) return isValidDate(value);
    }, 'error3');

    $("#form-create-company, #form-edit-company").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 50,
                regex: /^[а-яА-Яa-zA-Z\d\s_-]+$/ //string without special symbols
            },
            vat_number: {
                required: true,
                check_vat_number: true
            },
            email: {
                required: true,
                maxlength: 50,
                email: true
            },
            country:{
                required: true,
                minlength: 3,
                maxlength: 50
            },
            state:{
                required: true,
                minlength: 3,
                maxlength: 50
            },
            city:{
                required: true,
                minlength: 3,
                maxlength: 50
            },
            description:{
                required: true,
                minlength: 3,
                maxlength: 100
                ,      },
            address:{
                required: true,
                minlength: 3,
                maxlength: 100
            },
            date_created:{
                required: true,
                regex: /^(?:(\d{4})\-(\d{2})\-(\d{2}))$/,
                check_date: true
            }
        },
        messages: {
            name: {
                required: "The field is required",
                minlength: "The field must be at least 3 characters",
                maxlength: "The field may not be greater than 50 characters",
                regex: "Please provide a valid Name without special symbols"
            },
            vat_number: {
                required: "The field is required",
                check_vat_number: "Please provide a valid Vat_Number"
            },
            email: {
                required: "The field is required",
                maxlength: "The field may not be greater than 50 characters",
                email: "Please provide a valid Email"
            },
            country:{
                required: "The field is required",
                minlength: "The field must be at least 3 characters",
                maxlength: "The field may not be greater than 50 characters"

            },
            state:{
                required: "The field is required",
                minlength: "The field must be at least 3 characters",
                maxlength: "The field may not be greater than 50 characters"

            },
            city:{
                required: "The field is required",
                minlength: "The field must be at least 3 characters",
                maxlength: "The field may not be greater than 50 characters"

            },
            description:{
                required: "The field is required",
                minlength: "The field must be at least 3 characters",
                maxlength: "The field may not be greater than 100 characters"

            },
            address:{
                required: "The field is required",
                minlength: "The field must be at least 3 characters",
                maxlength: "The field may not be greater than 100 characters"

            },
            date_created:{
                required: "The field is required",
                regex: "Please provide a valid Date Format yyyy-mm-dd",
                check_date: "Please provide a valid Date"

            },
        },
        errorPlacement: function (error, element) {
            $(element).removeClass("is-valid");
            $(element).addClass("is-invalid");
            $(element).next('div').html($(error).html());
        },
        success: function(error, element) {
            $(element).removeClass("is-invalid");
            $(element).addClass("is-valid");
        },
        submitHandler: function (form) {
            form.submit();

        }
    });
    /*Validate Form Company*/

    /*Validate Form Employee*/
    $("#form-create-employee, #form-edit-employee").validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
            surname: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
            email: {
                required: true,
                maxlength: 50,
                email: true
            },
            age:{
                required: true,
                number: true,
                min: 18,
                max: 70
            },
            gender:{
                required: true,
                regex: /^male$|^female$/ //string with value equal to male or female
            },
            working_experience:{
                required: true,
                number: true,
                min: 0,
                max: 52
            }
        },
        messages: {
            name: {
                required: "The field is required",
                minlength: "The field must be at least 2 characters",
                maxlength: "The field may not be greater than 50 characters"
            },
            surname: {
                required: "The field is required",
                minlength: "The field must be at least 2 characters",
                maxlength: "The field may not be greater than 50 characters"
            },
            email: {
                required: "The field is required",
                maxlength: "The field may not be greater than 50 characters",
                email: "Please provide a valid Email"
            },
            age:{
                required: "The field is required",
                number: "The field must be a number",
                min: "The field must be at least 18",
                max: "The field may not be greater than 70"
            },
            gender:{
                required: "The field is required",
                regex: "The selected field is invalid"
            },
            working_experience:{
                required: "The field is required",
                number: "The field must be a number",
                min: "The field must be at least 0",
                max: "The field may not be greater than 52"
            },
        },
        errorPlacement: function (error, element) {
            $(element).removeClass("is-valid");
            $(element).addClass("is-invalid");
            $(element).next('div').html($(error).html());
        },
        success: function(error, element) {
            $(element).removeClass("is-invalid");
            $(element).addClass("is-valid");
        },
        submitHandler: function (form) {
            form.submit();

        }
    });
    /*Validate Form Employee*/

});
<!--Document On Ready-->

<!--Document On Load-->
$(window).load(function() {
    /*Index and Edit*/
    $("#success").fadeOut(5000).hide(0);
    /*Index and Edit*/

    /*Page Create and Edit*/
    limitText($('#description')[0], $('#description_countdown')[0], 100);
    $('#description').on('click keydown keyup', function() { limitText($('#description')[0], $('#description_countdown')[0], 100); });

    limitText($('#address')[0], $('#address_countdown')[0], 100);
    $('#address').on('click keydown keyup', function() { limitText($('#address')[0], $('#address_countdown')[0], 100); });
    /*Page Create and Edit*/

});
<!--Document On Load-->



