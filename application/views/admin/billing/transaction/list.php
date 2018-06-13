<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $maintitle; ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
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
<div class="message-fund">

</div> 
<h3 class="page-title"><?php echo $maintitle; ?> </h3>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-building-o font-dark"></i>
            <span class="caption-subject bold uppercase"> <?php echo $listtitle; ?> </span>
        </div>
        <div class="actions">
            <a href="<?php echo site_url('adm/billing/exporttransaction') ?>" class="btn green"><span>Export To CSV</span></a>
        </div>
    </div>   
    <div class="portlet-body">   
       
        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
            <thead>
                <tr>
                    <th> <?php echo '#' ?> </th>
                    <th> <?php echo 'Agent' ?> </th>
                    <th> <?php echo 'Agency' ?> </th>
                    <th> <?php echo 'Transaction ID' ?> </th>
                    <th> <?php echo 'Date' ?> </th>
                    <th> <?php echo 'Amount' ?> </th>
                    <th> <?php echo 'Status' ?> </th>
                    <th> <?php echo 'Payment Mode' ?> </th>
                    <th> <?php echo 'Action'; ?> </th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    jQuery(function(){
        jQuery('#billing').addClass('active');
        
        jQuery('#datatable').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo site_url('adm/billing/transactionjson'); ?>",
                "columnDefs": [ {
                    'orderable': false,
                    'targets': [0, 8]
                },{
                    "searchable": false,
                    "targets": [0, 8]
                }],
                "order": [
                        [0, "DESC"]
                    ]
            });        
    });
function doRefund(tranId){
    var surl = '<?php echo site_url("adm/billing/refund") ?>'+'/'+tranId;
    jQuery('#loading').modal("show");
    jQuery.ajax({
        url : surl,
        method : 'POST',
        dataType : 'json',
        data : {transaction_id : tranId },
        success: function(result){
            jQuery('.loader').hide();
            var flag = Boolean(result.success);
            if(flag == true){
                var msg = '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.message +'</div>';
                location.reload();
            }else{
                var msg = '<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+result.message+'</div>';
            }
            jQuery('.message-fund').html(msg);
            jQuery('#loading').modal("hide");
        }
    });
}    
</script>