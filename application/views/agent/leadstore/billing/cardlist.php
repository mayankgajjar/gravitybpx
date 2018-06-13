<div class="breadcrumbs">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>     
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo $label ?>
        </li>
    </ol>        
</div>
<?php if ($this->session->flashdata()) : ?>
    <?php if ($this->session->flashdata('error') != "") : ?>
        <div class='alert alert-danger'>
            <i class="fa-lg fa fa-warning"></i>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php else : ?>
        <div class='alert alert-success'>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php $creditcards = unserialize(CREDIT_CARDS);  ?>
<div class="page-content-container">
    <div class="page-content-row">
        <div class="page-sidebar">
            <nav role="navigation" class="navbar">
                <ul class="nav navbar-nav margin-bottom-35">
                    <li>
                        <a href="<?php echo site_url('billing/transaction') ?>">
                            <i class="fa fa-tasks"></i> <?php echo 'Transaction' ?> </a>
                    </li>
                    <li class="active">
                        <a href="<?php echo site_url('billing/creditcards') ?>">
                            <i class="fa fa-credit-card"></i> <?php echo 'Credit Cards' ?> </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('billing/autofund') ?>">
                            <i class="fa fa-money"></i> <?php echo 'Auto Funding' ?> </a>
                    </li>
                </ul>
            </nav>      
        </div>
        <div class="page-content-col">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-building-o font-dark"></i>
                        <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
                    </div>
                    <div class="actions">
                        <a class="btn sbold green"  data-toggle="modal" href="#responsive"  id="sample_editable_1_new" > Add New Credit Card
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" method="post" action="<?php echo site_url('billing/massdeletecards') ?>" onsubmit="submitform(event)">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4" style="float:right">
                                    <div class="table-group-actions pull-right">
                                        <select name="action" class="table-group-action-input form-control input-inline input-small input-sm">
                                            <option value="">Select...</option>
                                            <option value="del">Delete</option>
                                        </select>
                                        <button class="btn btn-sm btn-success table-group-action-submit">
                                            <i class="fa fa-check"></i> Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <th><input type="checkbox" data-set="#datatable .checkboxes" class="group-checkable"></th>
                                <th><?php echo 'Card Name' ?></th>
                                <th><?php echo 'Expire Date' ?></th>
                                <th><?php echo '' ?></th>
                            </thead>
                            <tbody>
                                <?php if(count($cards) > 0): ?>
                                <?php foreach($cards as $card): ?>                               
                                <tr>
                                    <td class="sorting_1"><input class="checkboxes" type="checkbox" name="id[]" value="<?php echo encode_url($card->id) ?>"/></td>
                                    <td><?php echo $card->name.' - '.$card->brand ?></td>
                                    <td><?php echo $card->exp_month.'/'.$card->exp_year ?></td>
                                    <td>
                                        <a class="delete btn green btn-xs" href="<?php echo site_url('billing/carddelete/'.encode_url($card->id)) ?>" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function () {
        
        jQuery('#leadstr').addClass('open');
        jQuery('#billindm').addClass('active');
        
        jQuery('#datatable').dataTable({
            "columnDefs": [ {
                'orderable': false,
                'targets': [0,3]
            },{
                "searchable": false,
                "targets": [0,3]
            }],
            "order": [
                    [2, "DESC"]
                ]            
        });
        jQuery('#datatable').find('.group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).prop("checked", true);
                        $(this).parents('tr').addClass("active");
                    } else {
                        $(this).prop("checked", false);
                        $(this).parents('tr').removeClass("active");
                    }
                });
                jQuery.uniform.update(set);
        });
        jQuery(document).on('click', '.delete', function(event){
            event.preventDefault();
            var href = jQuery(this).attr('href');                 
            swal({
              title: "Are you sure?",
              text: "You will not be able to recover this imaginary file!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Yes, delete it!",
              closeOnConfirm: false,
              html: false
            }, function(){
                location.href = href;          
            });            
        });        
        jQuery(document).on('submit','#cardForm',function(event){
            event.preventDefault();
            var postdata = jQuery(this).serialize();            
            jQuery.ajax({
                url : jQuery(this).attr('action'),
                method : jQuery(this).attr('method'),
                dataType : 'json',
                data : postdata,
                success : function(result){
                     var succ = Boolean(result.success);
                    if( succ == true ){
                        var msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.message +'</div>';
                        location.reload();
                    }else{
                        var msg = '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.message+'</div>';
                    }
                    jQuery('.msg').html(msg);
                },
            });
        });
        
        $("[name='card_exp_date']").inputmask("m/y", {
            "placeholder": "mm/yyyy"
        });        
        
        jQuery("#cardForm").validate({
            rules: {
                card_holder_name: "required",
                card_number : {
                        minlength: 12,
                        maxlength: 16,
                        required: !0
                },
                card_exp_date: {
                     required: !0
                },
                card_cvv_code: {
                    digits: !0,
                    required: !0,
                    minlength: 3,
                    maxlength: 4
                },
                card_type: "required",
            },
            messages: {
                cat_name: "Please enter vertical name.",
                active: "Please select one options.",
            },
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            invalidHandler: function (event, validator) { //display error alert on form submit
                    //success1.hide();
                    //error1.show();
                    //App.scrollTo(error1, -200);
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                      .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                     .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                 label
                     .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {                
                 success1.show();
                 error1.hide();
            }
        });        
    });
function submitform(event){    
    var length = jQuery('.checkboxes:checked').length;
    if(length <= 0){
        event.preventDefault();
        swal({
            title: "Error",
            text: "Please select atleast on record!",
            type: "error",
            showCancelButton: false,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "",
            closeOnConfirm: true,
            html: false
        }, function(){
            event.preventDefault();
        });    
    }   
}   
</script>
<!-- Popup Model -->                          
<div id="responsive" class="modal fade" tabindex="-1" data-width="380">

    <form method="post" action="<?php echo site_url('billing/cardsprocess') ?>" id="cardForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Add a Credit Card</h4>
                </div>
                <div class="modal-body" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="msg">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo "Name on Card: "; ?>&nbsp;&nbsp;<span class="card-info">Your name as it appears on the credit card</span></label>
                                <input type="text" name="card_holder_name" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo "Card Number: "; ?>&nbsp;&nbsp;<span class="card-info">Visa, MasterCard, or American Express</span></label>
                                <input type="text" name="card_number" class="form-control" id="card_number"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-7" style="padding-left: 0px;">  
                                <div class="form-group">
                                    <label class="control-label"><?php echo "Expiration Date:"; ?>&nbsp;&nbsp;<span class="card-info">(MM/YYYY)</span></label>
                                    <input type="text" name="card_exp_date" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-5" style="padding-right: 0px;">  
                                <div class="form-group">
                                    <label class="control-label"><?php echo "CVV Code:"; ?></label>
                                    <input type="text" name="card_cvv_code" class="form-control" />
                                </div>
                            </div>                                                    
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"><?php echo "Card Type:"; ?></label>
                                <select class="form-control" name="card_type" id="card_type">      
                                    <option value=""><?php echo "Select a Card Type"; ?></option>
                                    <?php foreach($creditcards as $key => $credit): ?>
                                      <option value="<?php echo $key; ?>"><?php echo $credit; ?></option>
                                      <?php endforeach; ?>
                                </select>
                            </div>
                        </div>                                   
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-outline dark">Cancel</button>
                    <button type="submit" id="btn-submit"  class="btn green">Save changes</button>
                </div>
            </div>
        </div>
    </form>                                        
</div>

<script>
/*----------- For Detect Card Type based on Card Number ---- */
$('#card_number').keyup(function(){

  //start without knowing the credit card type
  var result = "";
  var accountNumber = $('#card_number').val();
  //first check for MasterCard
  if (/^5[1-5]/.test(accountNumber))
  {
    result = "MC";
  }

  //then check for Visa
  else if (/^4/.test(accountNumber))
  {
    result = "VI";
  }

  //then check for AmEx
  else if (/^3[47]/.test(accountNumber))
  {
    result = "AX";
  }
  console.log(result);
  $("#card_type").val(result);
  // return result;

});
/*----------- End For Detect Card Type based on Card Number ---- */
</script>
