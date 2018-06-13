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
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body form">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1_1" data-toggle="tab"> <?php echo "System Setting"; ?> </a>
            </li>
            <li>
                <a href="#tab_1_2" data-toggle="tab"> <?php echo "Label Setting"; ?> </a>
            </li>
            <li>
                <a href="#tab_1_3" data-toggle="tab"> <?php echo "Queue Setting"; ?> </a>
            </li>
        </ul>
        <form name="form" id="form" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tab_1_1">
                    <?php $this->load->view('dialer/admin/setting/one') ?>
                </div>
                <div class="tab-pane fade in" id="tab_1_2">
                    <?php $this->load->view('dialer/admin/setting/two') ?>
                </div>
                <div class="tab-pane fade in" id="tab_1_3">
                    <?php $this->load->view('dialer/admin/setting/three') ?>
                </div>
            </div>
        </form>
    </div>
</div>