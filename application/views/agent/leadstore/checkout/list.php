<div class="breadcrumbs">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo $label ?>
        </li>
    </ol>
</div>
<?php if($this->session->flashdata()) : ?>
    <?php if($this->session->flashdata('error') != "") : ?>
        <div class='alert alert-danger'>
            <i class="fa-lg fa fa-warning"></i>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php  else :   ?>
        <div class='alert alert-success'>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
<?php  endif;   ?>
<div class="portlet light bordered">
    <div class="portlet-title">
<!--        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>-->
        <div class="actions">
<!--            <a href="<?php echo site_url('leadstore/edit'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Add New Campaign"; ?></span>
            </a>-->
           <!--  <a href="<?php echo site_url($importactioncontroller); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Import New Campaign"; ?></span>
            </a>    -->
        </div>
    </div>
    <div class="portlet-body filter-table">
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
            <thead>
                <tr>
                    <th> <?php echo '#' ?> </th>
                    <th> <?php echo 'Filters' ?> </th>
                    <th> <?php echo 'Created Date' ?> </th>
                    <th> &nbsp;&nbsp; </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script type="text/javascript">
    jQuery('#leadstr').addClass('open');
    jQuery(function(){
        jQuery('#datatable').dataTable( {
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?php echo site_url('storecheckout/findexjson'); ?>",
            "columnDefs": [ {
                'orderable': false,
                'targets': [0,3]
            },{
                "searchable": false,
                "targets": [0,3]
            }],
            "order": [
                [0, "DESC"]
            ]
        });
        jQuery(document).on('click', '.delete', function(event){
            event.preventDefault();
            var href = jQuery(this).attr('href');
            swal({
              title: "Are you sure?",
              text: "You will not be able to recover this recordss!",
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
    });
</script>