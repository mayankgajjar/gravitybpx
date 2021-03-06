var FormWizard = function () {


    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }

            function format(state) {
				alert(state);
                if (!state.id) return state.text; // optgroup
                return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
            }
          							
			var form = $('#submit_form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);
						           
            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
					"fname": {
	                required: true,
	                lettersonly: true	               
	            },
	            "mname": {	                
	                lettersonly: true	               
	            },
				"lname": {
	                required: true,
	                lettersonly: true	               
	            },	
	            "gender": {
	                required: true	               
	            },           
	            "dob": {
	                required: true	              	              
	            },
	            "email": {
	                required: true	                
	            },
	            "height": {
	                required: false	                             
	            },
	            "weight": {
	                required: false	                            
	            },
	            "birth_state": {
	                required: false,
	                lettersonly: true	                            
	            },
	            "marital_status": {
	                required: true	                            
	            },
	            "primary_email": {
	                required: false	                	              
	            },
	            "country": {
	                required: true	                            
	            },
	            "state": {
	                required: true	                            
	            },
	            "city": {
	                required: true	                            
	            },
	            "zip": {
	                required: true,
	                digits:true
	            },
	            "soc_sec_number": {
	                required: true,
	                digits:true                            
	            },
	            "phone_number": {
	                required: true	                            
	            },
	            "amfname[]": {
	                required: true,
	                lettersonly: true	               
	            },
	            "ammname[]": {	                
	                lettersonly: true	               
	            },
				"amlname[]": {
	                required: true,
	                lettersonly: true	               
	            },
	            "amsoc_sec_number[]": {
	                required: true,
	                digits:true                            
	            },
	            "amrelationship[]": {
	                required: true,
	                lettersonly: true	                                          
	            },
	            "ambirth_state[]": {
	                required: false,	
	                lettersonly: true                                          
	            },
	            "befname[]": {
	                required: true,
	                lettersonly: true	               
	            },
	            "bemname[]": {	                
	                lettersonly: true	               
	            },
				"belname[]": {
	                required: true,
	                lettersonly: true	               
	            },
	            "becoverage_amount[]": {
	                required: true,
	                digits:true                            
	            },
	            "berelationship[]": {
	                required: true,
	                lettersonly: true	                                          
	            },
	            "bebirth_state[]": {
	                required: false,	
	                lettersonly: true                                          
	            },
	            "pre_exist_condition": {
	                required: false
	            },
	            "use_tobacco": {
	                required: false	                
	            },
	            "plan_type": {
	                required: true	                
	            },
	            "single_enrollment_fee": {
	                required: false	                
	            },
	            "single_monthly_payment": {
	                required: false	                
	            },
	            "single_co_pays": {
	                required: false	                
	            },
	            "single_specialist_co_pay": {
	                required: false	                
	            },
	            "single_deductible_amount": {
	                required: false	                
	            },
	            "single_maximum_benefits": {
	                required: false	                
	            },
	            "single_maximum_out_of_pocket": {
	                required: false	                
	            },
	            "post_date": {
	                required: false	                
	            },
	            "first_payment": {
	                required: false	                
	            },
	            "total_monthly_payment": {
	                required: false	                
	            },
	            "single_spouse_enrollment_fee": {
	                required: false	                
	            },
	            "single_spouse_monthly_payment": {
	                required: false	                
	            },
	            "single_spouse_add_on_product": {
	                required: false	                
	            },
	            "single_spouse_benefit_amount": {
	                required: false	                
	            },
	            "single_child_enrollment_fee": {
	                required: false	                
	            },
	            "single_child_monthly_payment": {
	                required: false	                
	            },
	            "single_child_coverage_option": {
	                required: false	                
	            },
	            "single_child_benefit_amount": {
	                required: false	                
	            },
	            "single_child_deductible_amount": {
	                required: false	                
	            },
	            "family_enrollment_fee": {
	                required: false	                
	            },
	            "family_monthly_payment": {
	                required: false	                
	            },
	            "family_co_pays": {
	                required: false	                
	            },
	            "family_specialist_co_pay": {
	                required: false	                
	            },
	            "family_deductible_amount": {
	                required: false	                
	            },
	            "family_maximum_benefits": {
	                required: false	                
	            },
	            "family_maximum_out_of_pocket": {
	                required: false	                
	            },
	            "bank_name": {
	                required: true,
	                lettersonly: true	               
	            },	
	            "bank_address": {
	                required: true	              
	            },
	            "bank_country": {
	                required: true	              
	            },
	            "bank_state": {
	                required: true	              
	            },
	            "bank_city": {
	                required: true	              
	            },
	            "bank_zip": {
	                required: true,
	                digits: true	               
	            },
	            "routing_number": {
	                required: true,
	                digits: true	               
	            },
	            "bank_number": {
	                required: true,
	                digits: true	               
	            },
	            "card_fname": {
	                required: true,
	                lettersonly: true	               
	            },  
	            "card_mname": {
	                required: true,
	                lettersonly: true	               
	            },
	            "card_lname": {
	                required: true,
	                lettersonly: true	               
	            },         	            	            	            
	            "card_type": {
	                required: true	                
	            },           	            	            	            
	            "card_number": {
	                required: true,
	                digits: true	               
	            },
	            "expiration_date": {
	                required: true,
	                digits: true	               
	            },
	            "ccv_number": {
	                required: true,
	                digits: true	               
	            },
	            "billing_same": {
	                required: true	                	             
	            },
	            "billing_address": {
	                required: true               
	            },
	            "billing_country": {
	                required: true               
	            },
	            "billing_state_list": {
	                required: true               
	            },
	            "billing_city": {
	                required: true               
	            },
	            "billing_zip": {
	                required: true,
	                digits: true           
	            }	                          
                },

                messages: { // custom messages for radio buttons and checkboxes
                    'nonresident_license_state[]': {
                        required: "Please select at least one state",
                        minlength: jQuery.validator.format("Please select at least one state")
                    }
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("name") == "gender" || element.attr("name") == "marital_status" || element.attr("name") == "pre_exist_condition" || element.attr("name") == "use_tobacco") { // for uniform radio buttons, insert the after the given container
                        error.insertAfter("#form_gender_error");
                    } else if (element.attr("name") == "nonresident_license_state[]") { // for uniform checkboxes, insert the after the given container
                        error.insertBefore('#error');
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    App.scrollTo(error, -200);
                },

                highlight: function (element) { // hightlight error inputs
					$(element)
						.closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    if (label.attr("for") == "gender" || label.attr("for") == "payment[]" || label.attr("for") == "marital_status" || label.attr("for") == "pre_exist_condition" || label.attr("for") == "use_tobacco") { // for checkboxes and radio buttons, no need to show OK icon
                        label
                            .closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); // remove error label here
                    } else { // display success icon for other inputs
                        label
                            .addClass('valid') // mark the current input as valid and display OK icon
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    }
                },

                submitHandler: function (form) {
                    success.show();
                    error.hide();
                    form.submit();
                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
                }

            });

            var displayConfirm = function() {
                $('#tab4 .form-control-static', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));
                    } else if ($(this).attr("data-display") == 'payment[]') {
                        var payment = [];
                        $('[name="payment[]"]:checked', form).each(function(){ 
                            payment.push($(this).attr('data-title'));
                        });
                        $(this).html(payment.join("<br>"));
                    }
                });
            }

            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i <= index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                    displayConfirm();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                App.scrollTo($('.page-title'));
            }
            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    return false;
                    
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    if (form.valid() == false) {
                        return false;
                    }

                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').click(function () {
                success.hide();
                error.hide();

                if (form.valid() == false) {
                    return false;
                }
               // form.submit();
                return true;
            }).hide();          
        }

    };

}();

jQuery(document).ready(function() {
    FormWizard.init();
});
