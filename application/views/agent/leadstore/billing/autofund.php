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
<div class="page-content-container">
    <div class="page-content-row">
        <div class="page-sidebar">
            <nav role="navigation" class="navbar">
                <ul class="nav navbar-nav margin-bottom-35">
                    <li>
                        <a href="<?php echo site_url('billing/transaction') ?>">
                            <i class="fa fa-tasks"></i> <?php echo 'Transaction' ?> </a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('billing/creditcards') ?>">
                            <i class="fa fa-credit-card"></i> <?php echo 'Credit Cards' ?> </a>
                    </li>
                    <li class="active">
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

                    </div>
                </div>
                <div class="portlet-body">
                    <h4><?php echo 'Settings' ?></h4>
                    <p>This feature automatically replenishes your account by an amount you specify when your funds run low. This ensures that leads will continue to flow without having to constantly remember to fund your account. Editing these settings will not charge your credit card. This feature is optional, but we recommend you use it.</p>
                    <p>To enable auto-funding, you must first select a credit card and choose your settings.</p>                    
                    <form class="form-horizontal" method="post" action="<?php echo site_url('billing/autofundpost'); ?>" id='commentForm'>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo 'Autofund active' ?></label>
                                <div class="col-md-4">
                                    <div class="radio-list">
                                        <label class="radio-inline">
                                            <input name="is_active" type="radio" value="YES" <?php echo ($autoFund->is_active == "YES") ? 'checked="checked"' : ''; ?>>Yes
                                        </label>
                                        <label class="radio-inline">
                                            <input name="is_active" type="radio" value="NO" <?php echo ($autoFund->is_active == "NO") ? 'checked="checked"' : ''; ?>> No
                                        </label>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo "Automatically add..."; ?></label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                        <input class="form-control" type="text" name="add_price" value="<?php echo $autoFund->add_price ?>"/>
                                    </div>	
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo "When my balance falls below..."; ?></label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                                        <input class="form-control" type="text" name="condition_name" value="<?php echo $autoFund->condition_name ?>"/>
                                    </div>	
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><?php echo "Using this payment method:"; ?><span aria-required="true" class="required"> * </span></label>
                                <div class="col-md-4">                                    
                                    <?php
                                    $agent = $this->agents->get($this->session->userdata('agent')->id);
                                    $result = $this->stripe->customer_list_cards($agent->stripe_client_id, 100);
                                    $resultDecode = json_decode($result);
                                    $cards = $resultDecode->data;
                                    ?>                    
                                    <select name="method" class="form-control">
                                        <option value=""><?php echo 'Please Select'; ?></option>
                                        <?php if (count($cards) > 0): ?>
                                            <?php foreach ($cards as $card): ?>                        
                                                <?php $aCard = $this->card_m->get_by(array('stripe_card_id' => $card->id), TRUE); ?>
                                                <?php if ($aCard): ?>
                                                    <option value="<?php echo encode_url($aCard->card_id); ?>" <?php echo $autoFund->card_id == $aCard->card_id ? 'selected="selected"' : '' ?>><?php echo $card->name . ' - ' . $card->brand ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>					
                                </div>										
                            </div>                            
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn green" type="submit">Submit</button>
                                    <button class="btn default" type="button" onClick="javascript:enableForm()">Cancel</button>
                                </div>
                            </div>				
                        </div>                        
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

        jQuery("#commentForm").validate({
            rules: {
                add_price: "required",
                condition: "required",
                method: "required",
            },
            messages: {
                name: "Please enter company name.",
                time_zone: "Please select one options.",
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
</script>