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
    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4" style="float:right">
                </div>
            </div>
        </div>
        <form name="uploadform" method="post" enctype="multipart/form-data" class="form-horizontal" action="<?php echo site_url('dialer/aaudio/uploadfile')  ?>">
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-5 control-label"><?php echo 'Audio File to Upload' ?></label>
                    <div class="col-md-7">
                        <input type="file" name="audio" />
                        <p class="help-block"><?php echo "We STRONGLY recommend uploading only 16bit Mono 8k PCM WAV audio files(.wav)" ?></p>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-12">
                        <button class="btn blue" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
        <br /><br />
        <p class="text-center"><?php echo 'All spaces will be stripped from uploaded audio file names' ?></p><br />
        <a href="<?php echo site_url('dialer/aaudio/sound/master_audiofile') ?>" data-toggle="modal" data-target="#ajax" class="text-center" style="display: block;"><?php echo 'Audio File List' ?></a>
        <form name="copyform" action="<?php echo site_url('dialer/aaudio/renamefile') ?>" method="post" class="form-horizontal">
            <h3 class="text-center"><?php echo 'File to Copy' ?></h3>
            <div class="form-body">
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'Original file' ?></label>
                    <div class="col-md-8">
                        <input type="text" size="50" maxlength="100" name="master_audiofile"  id="master_audiofile" value="" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label"><?php echo 'New file' ?></label>
                    <div class="col-md-8">
                        <input type="text" size="50" maxlength="100" name="new_audiofile" id="new_audiofile" value="" />
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-7">
                        <button class="btn blue" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        jQuery(function(){
            jQuery('.audio').addClass('active');
        });
        function chooseFile(file, id){
            jQuery('#'+ id).val(file);
            jQuery('#ajax').modal('hide');
        }
    </script>
</div>
<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo site_url() ?>/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>