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
			
            $.validator.addClassRules({
    			percent: {
    				percent:true
    			}    			
			});

			$.validator.addMethod("percent",
			    function cals(value, element, params) 
			    {			        
			        var total_element = 0;
			        /*var percent = element;*/
			        var total = 0;			        
			        /*for (var i = 0; i < percent.length; i++) 
			        {
			            total += Number(percent[i].value);
			        }*/
			        //console.log(total);
			    	/*return  total == 100;*/		
			    	$(".percent").each(function ()
			    	{
            			total_element = total_element + 1;
        			});	   			  
        			
        			if(total_element == 1)
        			{       
        				total = value;        				
        				if(parseFloat(value) === 100)
        				{        					
        					return true;
        				}
        				else
        				{        				
        					return false;
        				}
        			}
        			else
        			{
        				$(".percent").each(function ()
				    	{
	            			total += parseFloat($(this).val());	            				            			
	        			});
	        			console.log(total);
	        			if(parseFloat(total) === 100)
        				{        					
        					return true;
        				}
        				else
        				{        				
        					return false;
        				}
        			}

			}, $.validator.format("Percentage fields must total up to 100%"));

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
	            "zip": {
	                required: true,
	                digits:true
	            },
	            "phone_number": {
	                required: true	                            
	            },
	            "email": {
	                required: true	                
	            },
	            "app_fname": {
	               required: true,
	               lettersonly: true	               
	            },
	            "app_mname": {	                
	                lettersonly: true	               
	            },
	            "app_lname": {
	                required: true,
	                lettersonly: true	               
	            },
	            "app_marital_status": {
	                required: true	                            
	            },
	            "app_gender": {
	                required: true	               
	            },	            
	            "app_height-feet": {
	                required: false,
	                digits:true,
	                min: 1	                
	            },
	            "app_height-Inches": 
	            {
	                required: false,
	                digits:true,
	                min : 0,
	                max : 11
	            },
	            "app_weight": 
	            {
	                required: false,
	                digits:true
	            },	            	           	            
	            "app_primary_email": {
	                required: true	                	              
	            },
	            "app_zip": {
	                required: true,
	                digits:true
	            },
	            "app_how_to_long": {
	                //required: false,
	                digits:true
	            },
	            "app_another_address": {
	                required: true	                
	            },	            
	            "app_another_zip": {
	                required: true,
	                digits:true
	            },
	            "app_another_time_at_address": {
	                required: true	                
	            },
	            "app_phone_number": {
	                required: true	                            
	            },
	            "app_email": {
	                required: true	                
	            },
	            "app_soc_sec_number": {
	                required: true	                                        
	            },
	            "app_dob": {
	                required: true,	                
	            },
	            "app_birth_country": {
	                required: false,	                
	            },
	            "app_birth_state": {
	                required: false,	                
	            },
	            /*"app_us_citizen": {
	                required: false,	                
	            },
	            "app_employed": {
	                required: false,	                
	            },*/
	            "app_employer": {
	                required: false,	                
	            },
	            "app_occupation": {
	                required: false,	                
	            },
	            "app_annual_salary": {
	                required: false,	                
	            },
	            "app_des_of_job_duties": {
	                required: false,	                
	            }, 	            
	            "beneficiaries_type": {
	                required: true	                
	            },
	            "individual_type": {
	                required: true	                
	            },
	            /*"befname[]": {
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
	            "besoc_sec_number[]": {
	                required: false	                	                                         
	            },	            
	            "berelationship[]": {
	                required: true,
	                lettersonly: true	                                          
	            },
	            "bedob[]": {
	                required: true	                
	            },
	            "bephone_number[]": {
	                required: false	                
	            },
	            "beemail[]": {
	                required: false	                
	            },
	            "beper_of_share[]": 
	            {
	                required: true,
	                digits: true,
	                min: 0,
	                max: 100            	
	            },*/
	            "pre_exist_condition": {
	                required: true
	            },
	            "use_tobacco": {
	                required: true	                
	            },
	            "plan_type": {
	                required: true	                
	            },	                               
	            "post_date": {
	                required: false	                
	            },
	            "first_payment": {
	                required: true	
	            },
	            "total_monthly_payment": {
	                required: false	                
	            },	            	            
	            "bank_name": {
	                required: true	                          
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
	                required: true	                	           
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
                    /*'beper_of_share[]': 
                    {                       
                        max: jQuery.validator.format("The sum of percentages must be 100")
                    }*/
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("name") == "gender" || element.attr("name") == "app_marital_status" || element.attr("name") == "app_gender" || element.attr("name") == "app_us_citizen" || element.attr("name") == "app_employed" || element.attr("name") == "marital_status" || element.attr("name") == "pre_exist_condition" || element.attr("name") == "use_tobacco" || element.attr("name") == "beneficiaries_type" || element.attr("name") == "individual_type" || element.attr("name") == "app_height-feet" || element.attr("name") == "app_height-Inches" || element.attr("name") == "billing_same") { // for uniform radio buttons, insert the after the given container
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
                    if (label.attr("for") == "gender" || label.attr("name") == "app_marital_status" || label.attr("name") == "app_gender" || label.attr("name") == "app_us_citizen" || label.attr("name") == "app_employed" || label.attr("for") == "payment[]" || label.attr("for") == "marital_status" || label.attr("for") == "pre_exist_condition" || label.attr("for") == "use_tobacco" || label.attr("for") == " beneficiaries_type" || label.attr("name") == "individual_type" || label.attr("name") == "app_height-feet" || label.attr("name") == "app_height-Inches" || label.attr("name") == "billing_same") { // for checkboxes and radio buttons, no need to show OK icon
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
                onNext: function (tab, navigation, index)
                {                    
                    success.hide();
                    error.hide();

                    if (form.valid() == false)
                    {
                        return false;
                    }
                    if(index == 2)
                    {                    	
                    	if($('.first_payment').val() == "$0.00")
                    	{                    		
                    		$('.step.step2').trigger('click');
                    		swal("Please add at least one product into cart");
                    		return false;
                    	}                    	
                    }
                    if(index == 3)
                    {                    	
                    	if($('#height-error').text() != "")
                    	{                    		                    		
                    		return false;
                    	}
                    	if($('#weight-error').text() != "")
                    	{
                    		return false;
                    	}
                    	if($('#feet-error').text() != "")
                    	{
                    		return false;
                    	}
                    	if($('#inches-error').text() != "")
                    	{
                    		return false;
                    	}
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
