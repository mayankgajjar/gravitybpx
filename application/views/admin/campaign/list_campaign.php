<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo "Campaign"; ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title"><?php echo "Campaign"; ?> </h3>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo "Campaign Listing"; ?> </span>
        </div>
        <div class="actions">
            <a href="<?php echo site_url('adm/campaign/edit'); ?>" class="btn btn-info">
                <i class="fa fa-plus"></i>
                <span class="hidden-xs"><?php echo "Add New Campaign"; ?></span>
            </a> 
        </div>
    </div>
    <div class="portlet-body">    
        <form class="categories_from" action="<?php echo site_url('adm/campaign/massaction'); ?> " name="categories_form" method="post" onsubmit="submitform(event)">
            <?php if($this->session->flashdata()) : ?>
                <?php if($this->session->flashdata('error') != "") : ?>
                    <div class='alert alert-danger'>
                        <i class="fa-lg fa fa-warning"></i>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php  else :   ?>
                    <div class='alert alert-success'>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>
            <?php  endif;   ?>
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
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                <thead>
                    <th>
                        <input type="checkbox" class="group-checkable" data-set="#datatable .checkboxes" />
                    </th>                   
                    <th>Campaign Name</th>
                    <th>Buyer Name</th>
                    <th>Company Name</th>
                    <th>Lead Category</th>
                    <th>Type</th>
                    <!-- <th>Leads Won</th>
                    <th>Spend</th> -->
                    <th>Daily Budget</th>
                    <!-- <th>CPL</th> -->
                    <th>Bid</th>
                    <th>Active</th>
                    <th> &nbsp; </th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </form>        
    </div>
</div>
<script type="text/javascript">
    jQuery(function(){
        jQuery('#bid').addClass('active');
        jQuery('.campaign').addClass('active'); 
        jQuery("#campaign").removeClass('active');       
        jQuery('#datatable').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo site_url('adm/campaign/indexjson'); ?>",
                "columnDefs": [ {
                    'orderable': false,
                    'targets': [0,9]
                },{
                    "searchable": false,
                    "targets": [0,9]
                }],
                "order": [
                        [0, "DESC"]
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
