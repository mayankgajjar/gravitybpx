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
    <div class="page-toolbar">
    </div>
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
<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <?php echo $this->session->flashdata('error'); ?>
</div>
<?php endif; ?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
        <div class="actions">
        </div>
    </div>
    <form name="calltimeform" id="calltimeform" method="post" class="form-horizontal" action="<?php echo site_url('dialer/alists/searchleadpost') ?>">
        <div class="portlet-body">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Vendor ID(vendor lead code)"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="vendor_id" maxlenght="20" class="form-control" value="" />
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
        </div>
        <div class="portlet-body">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Phone"; ?></label>
                    <div class="col-md-4">
                        <input type="text" name="phone" maxlenght="18" class="form-control" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo "Alt. Phone search"; ?></label>
                    <div class="col-md-4">
                        <select name="alt_phone_search" class="form-control">
                            <option value="Y"><?php echo 'Yes' ?></option>
                            <option value="N" selected=""><?php echo 'No' ?></option>
                        </select>
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
        </div>
        <div class="portlet-body">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Lead ID' ?></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="lead_id" class="for-control" value="" />
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
        </div>
        <div class="portlet-body">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Status' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="status" class="form-control" maxlength="6" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'List ID' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="list_id" class="form-control" maxlength="15" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'User' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="user" class="form-control" maxlength="20" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Owner' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="owner" class="form-control" maxlength="50" />
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
        </div>
        <div class="portlet-body">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'First' ?></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="first_name" maxlength="30" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Last' ?></label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="last_name" maxlength="30" />
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
        </div>
        <div class="portlet-body">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'Email' ?></label>
                    <div class="col-md-4">
                        <input type="text" name="email" class="form-control" value="" />
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
        </div>
    </form>
</div>