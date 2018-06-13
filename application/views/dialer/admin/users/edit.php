<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $title; ?></span>
        </li>
    </ul>
    <div class="tool-box"></div>
</div>
<h3 class="page-title"><?php echo $title; ?> </h3>
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Success!</strong> <?php echo $this->session->flashdata('success') ?>
</div>
<?php endif; ?>
<?php if(validation_errors() != ''): ?>
<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php echo validation_errors(); ?>
</div>
<?php endif; ?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <form id="groupForm" name="groupForm" id="groupForm" action="" method="post" class="form-horizontal" >
            <div class="form-body">
                <?php if($user->user_id != ''): ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'User Id' ?><span class="required">*</span></label>
                    <div class="col-md-4">
<!--                        <input type="text" name="user" maxlength="20" class="form-control" value="<?php echo $user->user; ?>"/>-->
                        <label class="form-control"><b><?php echo $user->user; ?></b></label>
                    </div>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Email' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="email" value="<?php echo $user->email; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Password' ?>
                        <?php if($user->user_id == ''): ?>
                           <span class="required">*</span>
                        <?php endif; ?>
                    </label>
                    <div class="col-md-4">
                        <input type="password" id="pass" name="pass" maxlength="20" class="form-control" value="<?php echo $user->pass; ?>"/>
                        <br /><button type="button" class="pass-btn btn">Show Password</button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Name' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="text" name="full_name" value="<?php echo $user->full_name; ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'User Role' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <select name="user_level" class="form-control">
                            <option value="9" <?php echo optionSetValue(9,$user->user_level ) ?>><?php echo 'Admin' ?></option>
                            <option value="8" <?php echo optionSetValue(8,$user->user_level ) ?>><?php echo 'Agency' ?></option>
                            <option value="1" <?php echo optionSetValue(1,$user->user_level ) ?>><?php echo 'Agent' ?></option>
                            <?php /* for($i = 1; $i<=9; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo optionSetValue($i,$user->user_level ) ?>><?php echo $i; ?></option>
                            <?php endfor;*/ ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Active'; ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <select class="form-control" name="active">
                            <option value="Y" <?php echo optionSetValue('Y',$user->active ) ?>><?php echo 'Yes'; ?></option>
                            <option value="N" <?php echo optionSetValue('N',$user->active ) ?>><?php echo 'No'; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'User Group' ?><span class="required">*</span></label>
                    <div class="col-md-4">
                        <select class="form-control" name="user_group">
                            <option value=""><?php echo '--Please Selelct--' ?></option>
                            <?php foreach($groups as $group): ?>
                            <option value="<?php echo $group->user_group; ?>" <?php echo optionSetValue($group->user_group,$user->user_group ) ?>><?php echo $group->user_group.' - '.$group->group_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Inbound Group' ?><span class="required">*</span></label>
                    <div class="col-md-9">
                        <?php
                              $vinAgents = array_column($inagents, 'group_id');
                        ?>
                        <table class="table">
                            <tr>
                                <th>&nbsp;</th>
                                <th><?php echo 'Inbound Group' ?></th>
                                <th><?php echo 'Rank' ?></th>
                                <th><?php echo 'Grade' ?></th>
                                <th><?php echo 'Calls' ?></th>
                                <th><?php echo 'Web Vars' ?></th>
                                <th><?php echo 'Agency' ?></th>
                            </tr>
                            <?php foreach($ingroups as $ingroup): ?>
                            <?php $flag = FALSE; ?>
                            <?php if($key = array_search($ingroup->group_id, $vinAgents)){
                                     $flag = TRUE;
                                 }
                            ?>
                            <tr>
                                <td><input type="checkbox" class="form-control" name="ingroup[]" value="<?php echo $ingroup->group_id ?>" <?php if($flag){ echo 'checked="checked";'; } ?>/></td>
                                <td><?php echo $ingroup->group_id.'-'.$ingroup->group_name ?></td>
                                <td>
                                    <?php $h = 9;  ?>
                                    <select class="form-control" name="RANK_<?php echo $ingroup->group_id ?>">
                                        <?php while($h >= -9): ?>
                                        <option value="<?php echo $h; ?>" <?php if($flag && $inagents[$key]['group_rank'] == $h){echo 'selected';}elseif($h == 0){echo 'selected';} ?>><?php echo $h; ?></option>
                                        <?php $h--; ?>
                                        <?php endwhile; ?>
                                    </select>
                                </td>
                                <td>
                                    <?php $h = 10;  ?>
                                    <select class="form-control" name="GRADE_<?php echo $ingroup->group_id ?>">
                                        <?php while($h >= 1): ?>
                                        <option value="<?php echo $h; ?>" <?php if($flag && $inagents[$key]['group_grade'] == $h){echo 'selected';}elseif($h == 1){echo 'selected';} ?>><?php echo $h; ?></option>
                                        <?php $h--; ?>
                                        <?php endwhile; ?>
                                    </select>
                                </td>
                                <td>
                                    <?php if($flag): ?>
                                        <?php echo $inagents[$key]['calls_today']; ?>
                                    <?php else: ?>
                                        <?php echo '0'; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <input class="form-control" type="text" name="WEB_<?php echo $ingroup->group_id ?>" maxlength="255" value="<?php if($flag){echo $inagents[$key]['group_web_vars'];} ?>" />
                                </td>
                                <td><?php echo $ingroup->name;?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
jQuery(function(){
    jQuery('#groupForm').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules:{
           user :{
               required: true,
               minlenght: 2,
               maxlenght: 20,
           },
           email :{
              required: true,
              email: true,
           },
           <?php if($user->user_id == ''): ?>
           pass :{
              required: true
           },
           <?php endif; ?>
           full_name:{
              required: true
           },
           name :{
             required: true
           },
           user_group:{
               required: true,
           }
       },
        highlight: function (element) { // hightlight error inputs
             $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
        },
    });
    jQuery(document).on('click', '.pass-btn', function(){
        var type = jQuery('#pass').attr('type');
        if(type == 'password'){
            jQuery('#pass').attr('type','text');
            jQuery(this).html('Hide Password');
        }else{
            jQuery('#pass').attr('type','password');
            jQuery(this).html('Show Password');
        }
    });
});
</script>