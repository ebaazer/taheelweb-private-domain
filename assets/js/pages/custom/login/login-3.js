/* 	
 * 	@author 	: taheelweb
 * 	Date created    : 01/03/2021        
 *      JS Login
 * 	
 * 	http://taheelweb.com
 *      The system for managing institutions for people with special needs
 */

"use strict";

// Class Definition
var KTLogin = function () {
    var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

    var _handleFormSignin = function () {
        var form = KTUtil.getById('kt_login_singin_form');
        var formSubmitUrl = KTUtil.attr(form, 'action');
        var formSubmitButton = KTUtil.getById('kt_login_singin_form_submit_button');

        if (!form) {
            return;
        }

        FormValidation
                .formValidation(
                        form,
                        {
                            fields: {
                                email: {
                                    validators: {
                                        notEmpty: {
                                            message: is_required
                                        }
                                    }
                                },
                                password: {
                                    validators: {
                                        notEmpty: {
                                            message: is_required
                                        }
                                    }
                                }
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger(),
                                submitButton: new FormValidation.plugins.SubmitButton(),
                                //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                                bootstrap: new FormValidation.plugins.Bootstrap({
                                    //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
                                    //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
                                })
                            }
                        }
                )
                .on('core.form.valid', function () {
                    // Show loading state on button
                    KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

                    // Simulate Ajax request
                    setTimeout(function () {
                        KTUtil.btnRelease(formSubmitButton);
                    }, 2000);

                    // Form Validation & Ajax Submission: https://formvalidation.io/guide/examples/using-ajax-to-submit-the-form

                    FormValidation.utils.fetch(baseurl + 'login/ajax_login', {
                        //url: baseurl + 'login/ajax_login',
                        method: 'POST',
                        dataType: 'json',
                        params: {
                            email: form.querySelector('[name="email"]').value,
                            password: form.querySelector('[name="password"]').value,
                        },
                    }).then(function (response) { // Return valid JSON
                        // Release button
                        KTUtil.btnRelease(formSubmitButton);

                        var login_status = response.login_status;

                        if (login_status === 'success') {
                            KTUtil.scrollTop();
                            var redirect_url = baseurl;
                            if (response.redirect_url && response.redirect_url.length)
                            {
                                redirect_url = response.redirect_url;
                            }
                            window.location.href = redirect_url;

                        } else if (login_status == 'suspended')
                        {
                            //var get_msg = msg_error_login_suspended;
                            //btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                            //showErrorMsg(form, 'danger', get_msg);

                            Swal.fire({
                                text: your_account_has_been_suspended,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-danger"
                                }
                            }).then(function () {
                                KTUtil.scrollTop();
                            });


                        } else if (login_status == 'invalid')
                        {
                            var get_msg = msg_error_login;
                            var get_msg2 = get_msg_ok;
                            //var get_msg_ok = msg_error_ok;
                            //btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                            //showErrorMsg(form, 'danger', get_msg);


                            Swal.fire({
                                text: get_msg,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: get_msg2,
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-danger"
                                }
                            }).then(function () {
                                KTUtil.scrollTop();
                            });


                        } else if (login_status == 'disabled')
                        {
                            //var get_msg = msg_error_disabled;
                            //btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                            //showErrorMsg(form, 'danger', get_msg);


                            Swal.fire({
                                text: "Sorry, something went wrong, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-danger"
                                }
                            }).then(function () {
                                KTUtil.scrollTop();
                            });


                        } else {
                            Swal.fire({
                                text: "Sorry, something went wrong, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-danger"
                                }
                            }).then(function () {
                                KTUtil.scrollTop();
                            });
                        }
                    });

                })
                .on('core.form.invalid', function () {

                });
    };

    var _handleFormForgot = function () {
        var form = KTUtil.getById('kt_login_forgot_form');
        var formSubmitUrl = KTUtil.attr(form, 'action');
        var formSubmitButton = KTUtil.getById('kt_login_forgot_form_submit_button');

        if (!form) {
            return;
        }

        FormValidation
                .formValidation(
                        form,
                        {
                            fields: {
                                email: {
                                    validators: {
                                        notEmpty: {
                                            message: 'Email is required'
                                        },
                                        emailAddress: {
                                            message: 'The value is not a valid email address'
                                        }
                                    }
                                }
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger(),
                                submitButton: new FormValidation.plugins.SubmitButton(),
                                //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                                bootstrap: new FormValidation.plugins.Bootstrap({
                                    //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
                                    //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
                                })
                            }
                        }
                )
                .on('core.form.valid', function () {
                    // Show loading state on button
                    KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

                    // Simulate Ajax request
                    setTimeout(function () {
                        KTUtil.btnRelease(formSubmitButton);
                    }, 2000);
                })
                .on('core.form.invalid', function () {
                    Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-danger"
                        }
                    }).then(function () {
                        KTUtil.scrollTop();
                    });
                });
    };

    var _handleFormSignup = function () {
        // Base elements
        var wizardEl = KTUtil.getById('kt_login');
        var form = KTUtil.getById('kt_login_signup_form');
        var formSubmitButton = KTUtil.getById('kt_login_signup_form_submit_button');
        var wizardObj;
        var validations = [];

        if (!form) {
            return;
        }

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        // Step 1
        validations.push(FormValidation.formValidation(
                form,
                {
                    fields: {
                        name_reg: {
                            validators: {
                                notEmpty: {
                                    message: is_required
                                }
                            }
                        }
                        ,
                        location_reg: {
                            validators: {
                                notEmpty: {
                                    message: is_required
                                }
                            }
                        },
                        Country_key_reg: {
                            validators: {
                                notEmpty: {
                                    message: is_required
                                }
                            }
                        },
                        phone: {
                            validators: {
                                notEmpty: {
                                    message: is_required
                                },
                                remote: {
                                    data: {
                                        type: 'name',
                                    },
                                    message: unavailable,
                                    method: 'POST',
                                    url: baseurl + 'register/check_phone_reg',
                                }


                            }
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        // Bootstrap Framework Integration
                        bootstrap: new FormValidation.plugins.Bootstrap({
                            //eleInvalidClass: '',
                            eleValidClass: '',
                        })
                    }
                }
        ));

        // Step 2
        validations.push(FormValidation.formValidation(
                form,
                {
                    fields: {
                        email: {
                            validators: {
                                notEmpty: {
                                    message: is_required
                                },
                                emailAddress: {
                                    message: 'The value is not a valid email address'
                                },
                                remote: {
                                    data: {
                                        type: 'name',
                                    },
                                    message: unavailable,
                                    method: 'POST',
                                    url: baseurl + 'register/check_email_reg',
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: is_required
                                }
                            }
                        },
                        account_type: {
                            validators: {
                                notEmpty: {
                                    message: is_required
                                }
                            }
                        },
                        url_reg: {
                            validators: {
                                notEmpty: {
                                    message: is_required
                                },
                                remote: {
                                    data: {
                                        type: 'name',
                                    },
                                    message: unavailable,
                                    method: 'POST',
                                    url: baseurl + 'register/check_url_reg',
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        // Bootstrap Framework Integration
                        bootstrap: new FormValidation.plugins.Bootstrap({
                            //eleInvalidClass: '',
                            eleValidClass: '',
                        })
                    }
                }
        ));

        // Step 3
        validations.push(FormValidation.formValidation(
                form,
                {
                    fields: {
                        delivery: {
                            validators: {
                                notEmpty: {
                                    message: 'Delivery type is required'
                                }
                            }
                        },
                        packaging: {
                            validators: {
                                notEmpty: {
                                    message: 'Packaging type is required'
                                }
                            }
                        },
                        preferreddelivery: {
                            validators: {
                                notEmpty: {
                                    message: 'Preferred delivery window is required'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        // Bootstrap Framework Integration
                        bootstrap: new FormValidation.plugins.Bootstrap({
                            //eleInvalidClass: '',
                            eleValidClass: '',
                        })
                    }
                }
        ));

        // Step 4
        validations.push(FormValidation.formValidation(
                form,
                {
                    fields: {
                        ccname: {
                            validators: {
                                notEmpty: {
                                    message: 'Credit card name is required'
                                }
                            }
                        },
                        ccnumber: {
                            validators: {
                                notEmpty: {
                                    message: 'Credit card number is required'
                                },
                                creditCard: {
                                    message: 'The credit card number is not valid'
                                }
                            }
                        },
                        ccmonth: {
                            validators: {
                                notEmpty: {
                                    message: 'Credit card month is required'
                                }
                            }
                        },
                        ccyear: {
                            validators: {
                                notEmpty: {
                                    message: 'Credit card year is required'
                                }
                            }
                        },
                        cccvv: {
                            validators: {
                                notEmpty: {
                                    message: 'Credit card CVV is required'
                                },
                                digits: {
                                    message: 'The CVV value is not valid. Only numbers is allowed'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        // Bootstrap Framework Integration
                        bootstrap: new FormValidation.plugins.Bootstrap({
                            //eleInvalidClass: '',
                            eleValidClass: '',
                        })
                    }
                }
        ));

        // Initialize form wizard
        wizardObj = new KTWizard(wizardEl, {
            startStep: 1, // initial active step number
            clickableSteps: false  // allow step clicking
        });

        // Validation before going to next page
        wizardObj.on('change', function (wizard) {
            if (wizard.getStep() > wizard.getNewStep()) {
                return; // Skip if stepped back
            }

            // Validate form before change wizard step
            var validator = validations[wizard.getStep() - 1]; // get validator for currnt step

            if (validator) {
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        wizard.goTo(wizard.getNewStep());

                        KTUtil.scrollTop();
                    } else {

                        /*
                         Swal.fire({
                         text: "Sorry, looks like there are some errors detected, please try again.",
                         icon: "error",
                         buttonsStyling: false,
                         confirmButtonText: "Ok, got it!",
                         customClass: {
                         confirmButton: "btn font-weight-bold btn-light"
                         }
                         }).then(function () {
                         KTUtil.scrollTop();
                         });
                         */
                    }
                });
            }

            return false;  // Do not change wizard step, further action will be handled by he validator
        });

        // Change event
        wizardObj.on('changed', function (wizard) {
            KTUtil.scrollTop();
        });

        // Submit event
        wizardObj.on('submit', function (wizard) {

            // Show loading state on button
            KTUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

            // Simulate Ajax request
            setTimeout(function () {
                KTUtil.btnRelease(formSubmitButton);
            }, 2000);

            Swal.fire({
                text: "All is good! Please confirm the form submission.",
                icon: "info",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, submit!",
                cancelButtonText: "No, cancel",
                customClass: {
                    confirmButton: "btn font-weight-bold btn-danger",
                    cancelButton: "btn font-weight-bold btn-default"
                }
            }).then(function (result) {
                if (result.value) {
                    //form.submit();
                    //console.log(form.querySelector('[name="fname"]').value);
                    //console.log('submit');
                    let timerInterval;
                    Swal.fire({
                        title: creating_your_account,
                        html: please_wait + " <b></b> " + seconds,
                        timer: 20000, //15000
                        timerProgressBar: true,
                        onOpen: () => {
                            swal.showLoading();
                            const timer = Swal.getPopup().querySelector("b");
                            $.ajax({
                                type: 'post',
                                url: baseurl + 'register/ajax_register',
                                dataType: 'json',
                                data: {
                                    name_reg: form.querySelector('[name="name_reg"]').value,
                                    location_reg: form.querySelector('[name="location_reg"]').value,
                                    Country_key_reg: form.querySelector('[name="Country_key_reg"]').value,
                                    phone_reg: form.querySelector('[name="phone"]').value,
                                    email_reg: form.querySelector('[name="email"]').value,
                                    password_reg: form.querySelector('[name="password"]').value,
                                    account_type_reg: form.querySelector('[name="account_type"]').value,
                                    url_reg: form.querySelector('[name="url_reg"]').value
                                },
                                success: function (response) {
                                    //console.log('after ajax');
                                    //console.log(response);
                                    var response = response;
                                    var register_status = response.success;

                                    if (register_status == true) {
                                        //console.log('after register_status');
                                    } else {
                                        //console.log('sssss');
                                        Swal.fire({
                                            text: "error error error",
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn font-weight-bold btn-light-danger"
                                            }
                                        }).then(function () {
                                            KTUtil.scrollTop();
                                        });
                                    }

                                    if (register_status == true) {
                                        //console.log(response.register_status);
                                        //var redirect_url = response.register_url;
                                        //window.location.href = redirect_url;
                                        //window.open('https://'+form.querySelector('[name="url_reg"]').value+'.taheelweb.com', "_self");
                                    }
                                }
                            });
                            timerInterval = setInterval(() => {
                                timer.textContent = Math.ceil(swal.getTimerLeft() / 1000);
                            }, 100);
                        },
                        willClose: () => {
                            //clearInterval(timerInterval);
                            window.open('https://'+form.querySelector('[name="url_reg"]').value+'.taheelweb.com', "_self");
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            //console.log("I was closed by the timer");
                        }
                    });
                }
            });
        });
    };

    // Public Functions
    return {
        init: function () {
            _handleFormSignin();
            _handleFormForgot();
            _handleFormSignup();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function () {
    KTLogin.init();
});
