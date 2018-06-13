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
            <span class="caption-subject bold uppercase"><?php echo $listtitle; ?> </span>
        </div>
    </div>
    <div class="portlet-body">
        <form id="searchform" name="searchform" action="" method="post" class="form-horizontal" >
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo 'Agency' ?></label>
                            <?php if ($this->session->userdata ( 'user' )->group_name == 'Agency'): ?>
                                <?php $tree = buildTree($agencies,0); ?>
                            <select name="agency_id" class="form-control" id="agency_id" onchange="javascript:selectUsers(this.value)" style="width:80%">
                                    <option value=""><?php echo "Please Select Agency"; ?></option>
                                    <?php echo printTreeWithEncrypt($tree,0, null, isset($postData['agency_id']) ? decode_url($postData['agency_id']) : ''  ); ?>
                                </select>
                            <?php else: ?>
                                <?php $tree = buildTree($agencies,0); ?>
                                <select name="agency_id" class="form-control" id="agency_id" onchange="javascript:selectUsers(this.value)" style="width:80%">
                                    <option value=""><?php echo "Please Select Agency"; ?></option>
                                <?php echo printTreeWithEncrypt($tree,0, null, isset($postData['agency_id']) ? decode_url($postData['agency_id']) : ''  ); ?>
                                </select>
                            <?php endif; ?>
                            <br />
                            <label><?php echo 'Agents' ?></label>                            
                            <select name="user" class="form-control" id="user_start" style="width:80%">
                                <option value="" selected="">Please Select</option>
                            </select>                           
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo 'Lead Id' ?></label>
                            <input type="text" name="lead_id" id="lead_id" class="form-control" style="width:80%"/>
                            <br />
                            <!--label><?php echo 'Start Time' ?></label>
                            <div class="input-group date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                <input type="text" class="form-control" name="start_query_date" style="width:100%">
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" name="start_end_date" style="width:80%">
                            </div-->                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <!--label><?php echo 'End Time' ?></label>
                            <div class="input-group date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
                                <input type="text" class="form-control" name="end_query_date"  style="width:100%">
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" name="end_end_date"  style="width:80%">
                            </div-->                              
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-5 col-md-9">
                        <button class="btn blue" type="submit"><?php echo 'Submit'  ?></button>
                    </div>
                </div>
            </div>
        </form>        
    </div>    
    <div class="portlet-body">
        <div class="table-container">
            <div class="table-actions-wrapper"></div>
            <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_ajax">
                <thead>
                    <tr role="row" class="heading">
                        <th><?php echo '&nbsp;#&nbsp;' ?></th>
                        <th><?php echo 'Channel' ?></th>
                        <th><?php echo 'Start Time' ?></th>
                        <th><?php echo 'End Time' ?></th>
                        <th><?php echo 'Length (Seconds)' ?></th>
                        <th><?php echo 'Lead Id' ?></th>
                        <th><?php echo 'File' ?></th>
                        <th><?php echo 'User/Agent' ?></th>
                        <th><?php echo 'Agency' ?></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
var searchData = {};    
var grid = null;
function selectUsers(agencyId){
    jQuery('#loading').modal("show");
    jQuery.ajax({
        url:'<?php echo site_url('dialer/ajax/getUser') ?>',
        method: 'POST',
        async: false,
        dataType: 'JSON',
        data:{id: agencyId, user:'<?php echo isset($postData['user_start']) ? $postData['user_start'] : "" ?>'},
        success: function(result){
            var flag = Boolean(result.success);
            jQuery('#user_start').replaceWith(result.html);
            jQuery('#loading').modal("hide");
            jQuery('#user_start').prepend('<option selected value="">Please Select User</option>')
            jQuery('#user_start').css('width','80%');
        }
    });
}    
TableDatatablesAjax = function () {

    var initPickers = function () {
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
    }

    var handleRecords = function () {

        grid = new Datatable();

        grid.init({
            src: $("#datatable_ajax"),
            onSuccess: function (grid, response) {
                // grid:        grid object
                // response:    json object of server side ajax response
                // execute some code after table records loaded
                var as = audiojs.createAll();
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            onDataLoad: function(grid) {
                // execute some code on ajax data load               
                var as = audiojs.createAll();               
            },
            loadingMessage: 'Loading...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
                
                "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "ajax": {
                    "url": "<?php echo site_url('dialer/treport/recjson') ?>", // ajax source                   
                },
                "order": [
                    [0, "asc"]
                ]// set first column as a default sort by asc
            }
        });

        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", action.val());
                grid.setAjaxParam("id", grid.getSelectedRows());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else if (action.val() == "") {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });

        grid.setAjaxParam("customActionType", "group_action");
        grid.getDataTable().ajax.reload();
        grid.clearAjaxParams();
    }

    return {

        //main function to initiate the module
        init: function () {

            initPickers();
            handleRecords();
        }

    };

}();
jQuery(document).ready(function() {
    TableDatatablesAjax.init();
    jQuery('.input-daterange').datepicker({
        orientation: "bottom",
    });
    jQuery('#searchform').on('submit',function(event){
        event.preventDefault();       
        var data = {};
        var agency = jQuery('#agency_id').val();
        
        if(agency.length > 0){
            data.agency_id = agency;
        }
        var user_start = jQuery('#user_start').val();
        if(user_start.length > 0){
            data.user_start = user_start;
        }
        var lead_id = jQuery('#lead_id').val();
        if(lead_id.length > 0){
            data.lead_id = lead_id;
        }   
        /*var start_query_date = jQuery('[name="start_query_date"]').val();
        if( start_query_date.length > 0){
            data.start_query_date = start_query_date;
        }   
        var start_end_date = jQuery('[name="start_end_date"]').val() ;
        if(start_end_date.length > 0){
            data.start_end_date = start_end_date;
        }   
        var end_query_date = jQuery('[name="end_query_date"]').val();
        if(start_end_date.length > 0){
            data.end_query_date = end_query_date;
        }   
        var end_end_date = jQuery('[name="end_end_date"]').val() ;
        if(end_end_date.length > 0){
            data.end_end_date = end_end_date;
        }*/
        console.log(data);
        grid.setAjaxParam("customActionType", data);        
        grid.getDataTable().ajax.reload();
        //grid.clearAjaxParams();                
    });
});
</script>