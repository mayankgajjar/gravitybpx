<div class="breadcrumbs">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>     
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo $label ?>
        </li>
    </ol>        
</div>
<div class="page-content-container">
    <div class="page-content-row">
        <div class="page-sidebar">
            <nav role="navigation" class="navbar">
                <ul class="nav navbar-nav margin-bottom-35">
                    <li class="active">
                        <a href="<?php echo site_url('billing/transaction') ?>">
                            <i class="fa fa-tasks"></i> <?php echo 'Transaction' ?> </a>
                    </li>
                    <li>
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
                        <a href="#add-fund" data-toggle="modal" class="btn green" ><span><?php echo 'Add Fund' ?></span><i class="fa fa-plus"></i></a>
                        <a href="<?php echo site_url('billing/exporttransaction') ?>" class="btn green"><span><?php echo 'Export To CSV' ?></span></a>
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" method="post">
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
                    
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                        <thead>                 
                        <th> <?php echo "#"; ?> </th>
                        <th> <?php echo "Date"; ?> </th>
                        <th> <?php echo "Type"; ?> </th>
                        <th> <?php echo "Amount"; ?> </th>
                        <th> <?php echo "Transaction ID"; ?> </th>
                        <th> <?php echo "Status"; ?> </th>
                        <th> <?php echo "Payment Card"; ?> </th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function(){
        jQuery('#datatable').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "<?php echo site_url('billing/transactionJson'); ?>",
                "columnDefs": [ {
                    'orderable': false,
                    'targets': [0,6]
                },{
                    "searchable": false,
                    "targets": [0,6]
                }],
                "order": [
                        [1, "DESC"]
                    ]
            });        
    });
</script>
<?php  $this->load->view('agent/leadstore/billing/add-fund.php'); ?>