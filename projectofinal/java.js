/**
 * Created by susana on 15/03/2017.
 */

/***********CONTROLLER MAIN PAGE*/
var musInApp = angular.module('musInApp', []);

musInApp.controller('musController', function($scope){
    $scope.concert = "Concert XXX";
    $scope.description = "description";
    $scope.price = "20euros";
});

musInApp.controller('music', function($scope){
    $scope.music = "Besnine - Feel Alive";
    $scope.description = "description";

});

musInApp.controller('video', function($scope){
    $scope.video = "video.wav";
    $scope.description = "video description";
})

musInApp.controller('profile', function($scope){
    $scope.name = 'Maria Cena';
    $scope.place = 'San Fran';
    $scope.mail = 'maria.cena@gmail.com';
    $scope.web = 'lala.com';
    $scope.birthday = '11.June.1995';
});



/**********************SIDE BAR / MENU */
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").marginLeft = "0";
    document.body.style.backgroundColor = "white";
}

/***************** DATE PICKER CALENDAR NOT WORKING*********************/
$(document).ready(function() {
    $("#departing").datepicker();
    $("#returning").datepicker();
    $("button").click(function() {
        var selected = $("#dropdown option:selected").text();
        var departing = $("#departing").val();
        var returning = $("#returning").val();
        if (departing === "" || returning === "") {
            alert("Please select departing and returning dates.");
        }
    })
});

/* INSERT EVENT */
$(document).ready(function() {
    $("input[name$='pay']").click(function() {
        var test = $(this).val();

        $("div.desc").hide();
        $("#Pay" + test).show();
    });
});

/*PROFILE*/
musInApp.controller('event', function($scope){
    $scope.eventName = "name";
    $scope.description = "descrição";
    $scope.tickets = "bilhetes disponíveis";

});
/* PROFILE END*/

/* LOGIN REGISTER FORGOT PASSWORD */
(function($) {
    "use strict";

    // Options for Message
    //----------------------------------------------
    var options = {
        'btn-loading': '<i class="fa fa-spinner fa-pulse"></i>',
        'btn-success': '<i class="fa fa-check"></i>',
        'btn-error': '<i class="fa fa-remove"></i>',
        'msg-success': 'All Good! Redirecting...',
        'msg-error': 'Wrong login credentials!',
        'useAJAX': true,
    };

    // Login Form
    //----------------------------------------------
    // Validation
    $("#login-form").validate({
        rules: {
            lg_username: "required",
            lg_password: "required",
        },
        errorClass: "form-invalid"
    });

    // Form Submission
    $("#login-form").submit(function() {
        remove_loading($(this));

        if(options['useAJAX'] == true)
        {
            // Dummy AJAX request (Replace this with your AJAX code)
            // If you don't want to use AJAX, remove this
            dummy_submit_form($(this));

            // Cancel the normal submission.
            // If you don't want to use AJAX, remove this
            return false;
        }
    });

    // Register Form
    //----------------------------------------------
    // Validation
    $("#register-form").validate({
        rules: {
            reg_username: "required",
            reg_password: {
                required: true,
                minlength: 5
            },
            reg_password_confirm: {
                required: true,
                minlength: 5,
                equalTo: "#register-form [name=reg_password]"
            },
            reg_email: {
                required: true,
                email: true
            },
            reg_agree: "required",
        },
        errorClass: "form-invalid",
        errorPlacement: function( label, element ) {
            if( element.attr( "type" ) === "checkbox" || element.attr( "type" ) === "radio" ) {
                element.parent().append( label ); // this would append the label after all your checkboxes/labels (so the error-label will be the last element in <div class="controls"> )
            }
            else {
                label.insertAfter( element ); // standard behaviour
            }
        }
    });

    // Form Submission
    $("#register-form").submit(function() {
        remove_loading($(this));

        if(options['useAJAX'] == true)
        {
            // Dummy AJAX request (Replace this with your AJAX code)
            // If you don't want to use AJAX, remove this
            dummy_submit_form($(this));

            // Cancel the normal submission.
            // If you don't want to use AJAX, remove this
            return false;
        }
    });

    // Forgot Password Form
    //----------------------------------------------
    // Validation
    $("#forgot-password-form").validate({
        rules: {
            fp_email: "required",
        },
        errorClass: "form-invalid"
    });

    // Form Submission
    $("#forgot-password-form").submit(function() {
        remove_loading($(this));

        if(options['useAJAX'] == true)
        {
            // Dummy AJAX request (Replace this with your AJAX code)
            // If you don't want to use AJAX, remove this
            dummy_submit_form($(this));

            // Cancel the normal submission.
            // If you don't want to use AJAX, remove this
            return false;
        }
    });

    // Loading
    //----------------------------------------------
    function remove_loading($form)
    {
        $form.find('[type=submit]').removeClass('error success');
        $form.find('.login-form-main-message').removeClass('show error success').html('');
    }

    function form_loading($form)
    {
        $form.find('[type=submit]').addClass('clicked').html(options['btn-loading']);
    }

    function form_success($form)
    {
        $form.find('[type=submit]').addClass('success').html(options['btn-success']);
        $form.find('.login-form-main-message').addClass('show success').html(options['msg-success']);
    }

    function form_failed($form)
    {
        $form.find('[type=submit]').addClass('error').html(options['btn-error']);
        $form.find('.login-form-main-message').addClass('show error').html(options['msg-error']);
    }

    // Dummy Submit Form (Remove this)
    //----------------------------------------------
    // This is just a dummy form submission. You should use your AJAX function or remove this function if you are not using AJAX.
    function dummy_submit_form($form)
    {
        if($form.valid())
        {
            form_loading($form);

            setTimeout(function() {
                form_success($form);
            }, 2000);
        }
    }

})(jQuery);

/* LOGIN REGISTER FORGOT PASSWORD END*/