<style>
    .custom-table-heading{background: #009dc7;}
    .custom-table-heading td{color: #fff;}
    .custom-btn .btn{margin-right: 0px;}
    .custom-lead-title{margin: 0px;color: #fff;}
    .lead-table td{border: 1px solid #32c5d2 !important;text-align: center;}
    .action-box{margin-right: 8px;font-size: 16px;}
    .lead-store-table-fixes .dataTables_length {display: none;}
    .lead-store-table-fixes .dataTables_filter {display: none;}
    /*   .lead-purchased {width: 100%;background-color: #f3f3f3;}
      .lead-purchased tbody {height: 200px;overflow-y: auto;width: 100%;}
      .lead-purchased thead, .lead-purchased tbody, .lead-purchased tr, .lead-purchased td, .lead-purchased th {display: block;}
      .lead-purchased tbody td {float: left;}
      .lead-purchased thead tr th {float: left;}
      .lead-purchased.no-data-table-custom tbody{height: 40px;}
      .lead-purchased.no-data-table-custom tbody tr td{float:none;text-align:center;}*/
</style>
<div class="lead-store">
    <div class="breadcrumbs">
        <h1 class="page-title"> <?php echo $pagetitle ?> </h1>
        <!--    <ol class="breadcrumb">
                <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
                <li class="active">
        <?php echo 'CRM' ?>
                </li>
            </ol>        -->
    </div>
    <?php if ($this->session->flashdata('success') != ''): ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error') != ''): ?>
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-3 lead-left-part">
            <div class='balance-summary'>
                <p><?php echo 'Current Balance' ?></p>
                <p><span class='symbol'>$</span><span class='amount'><?php echo formatMoney($currentBalance, 2) ?></span></p>
            </div>
            <p class="add_lead"><a href='#add-fund' data-toggle="modal">+&nbsp;<?php echo 'Add Funds' ?></a></p>
            <div class="today-summary">
                <h4><?php echo 'Metrics For Today' ?></h4>
                <ul class="summary">
                    <li>
                        <p>
                            <span><?php echo 'Lead Purchased' ?>:</span>
                            <span><?php echo '67' ?></span>
                        </p>
                    </li>
                    <li>
                        <p>
                            <span><?php echo 'Lead Purchased' ?>:</span>
                            <span><?php echo '$3,316.00' ?></span>
                        </p>
                    </li>
                    <li>
                        <p>
                            <span><?php echo 'Cost per Lead' ?>:</span>
                            <span><?php echo '$49.49' ?></span>
                        </p>
                    </li>
                    <li>
                        <p>
                            <span><?php echo 'Deposits' ?>:</span>
                            <span><?php echo formatMoney($todayDeposits, 2, TRUE) ?></span>
                        </p>
                    </li>
                </ul>
                <h4><?php echo 'Current Settings' ?></h4>
                <ul class='summary'>
                    <li>
                        <p>
                            <span><?php echo 'Auto-funding' ?>:</span>
                            <span><?php echo $autoFundStatus ?></span>
                        </p>
                    </li>
                    <li>
                        <p>
                            <span><?php echo 'Active Campaigns' ?>:</span>
                            <span><?php echo $activeCampaigns ?></span>
                        </p>
                    </li>
                </ul>
            </div>
            <div class="btn-group">
                <!-- <button class="btn green"><?php echo 'Add Vendor' ?></button> -->
                <button onclick="location.href = '<?php echo site_url('leadstore/edit') ?>'" class="btn green"><?php echo 'Add Campaign' ?></button>
            </div>
        </div>
        <div class="col-md-9 lead-right-part">
            <div class="lead-content">
                <!-- Live Transfer Lead -->
                <div class="lead-company" id="lead-conpany-1" data-toggle="close">
                    <div class="lead-title">
                        <h2 class="custom-lead-title">Live Transfer Leads </h2>
                        <!-- <img src="<?php echo site_url('assets/images/nextgen.png') ?>" /> -->
                    </div>
                    <div class="lead-data">
                        <div class="lead-row">
                            <div class="lead-col">
                                <div class="lead-value"><?php echo '20' ?></div>
                                <div class="lead-text"><?php echo 'Purchased' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value"><?php echo '4' ?></div>
                                <div class="lead-text"><?php echo 'Closed' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value"><?php echo '20%' ?></div>
                                <div class="lead-text"><?php echo 'Close Ratio' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value"><?php echo '$41.00' ?></div>
                                <div class="lead-text"><?php echo 'Avg. Cost per Lead' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value"><?php echo '$788.00' ?></div>
                                <div class="lead-text"><?php echo 'Total Spend' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value"><?php echo '$ 245.00' ?></div>
                                <div class="lead-text"><?php echo 'Current Balance' ?></div>
                            </div>
                            <div class="lead-col">
                                <!-- <div class="btn-group btn-toggle">
                                  <button class="btn btn-default lead-btn-on1">ON</button>
                                  <button class="btn btn-primary lead-btn-off1">OFF</button>
                                </div> -->
                                <input type="checkbox" data-on-text="ON" data-off-text="OFF" name="activeall" class="make-switch"/>
                            </div>
                        </div>
                        <!-- <div class="lead-row-seprator" style="display: none;"></div> -->
                        <div class="lead-row table-responsive" style="display: none;">
                            <table class="table table-bordered lead-table" cellspacing="0" cellpadding="0">
                                <thead class="custom-table-heading">
                                    <tr>
                                        <td>Campaign Name</td>
                                        <td>Lead Category</td>
                                        <td>Bid Type</td>
                                        <td>Purchased</td>
                                        <td>Closed</td>
                                        <td>Cost Per Lead</td>
                                        <td>Total Spend</td>
                                        <td>Daily Budget</td>
                                        <td>Bid</td>
                                        <td style="width: 120px;">Active</td>
                                        <td>Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($live_transfer) > 0) : ?>
                                        <?php foreach ($live_transfer as $transfer): ?>
                                            <tr>
                                                <td><?= $transfer['name'] ?></td>
                                                <td><?= $transfer['lead_category'] ?></td>
                                                <td><?= $transfer['bid_type'] ?></td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>$<?= $transfer['daily_budget'] ?></td>
                                                <td>--</td>
                                                <td>
                                                    <?php
                                                    if ($transfer['active'] == 1) {
                                                        $check = 'checked="checked"';
                                                    } else {
                                                        $check = '';
                                                    }
                                                    ?>
                                                    <input type="checkbox" data-on-text="ON" data-off-text="OFF" name="campaign_status" class="make-switch" data-camp-id="<?php echo $transfer['campaign_id']; ?>" <?php echo $check; ?>/>
                                                </td>
                                                <td>
                                                    <a href="<?= site_url('leadstore/edit/' . encode_url($transfer['campaign_id'])) ?>" title="Edit"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr class="text-center">
                                            <td colspan="11"><strong> No Campaigns Found</strong></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- End Live Transfer Lead -->

                <div class="lead-row-footer">
                    <a hrf="javascript:;" id="mini-1" onclick="toggleDiv('1')" style="display: none;"><i class="fa fa-chevron-up" aria-hidden="true"></i><?php echo 'Minimize' ?><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
                    <a hrf="javascript:;" id="expand-1" onclick="toggleDiv('1')"><i class="fa fa-chevron-down" aria-hidden="true"></i><?php echo 'Expand' ?><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                </div>

                <!-- Real - Time Data Leads -->
                <div class="lead-company" id="lead-conpany-2" data-toggle="close">
                    <div class="lead-title">
                        <h2 class="custom-lead-title">Real - Time Data Leads</h2>
                    </div>
                    <div class="lead-data">
                        <div class="lead-row">
                            <div class="lead-col">
                                <div class="lead-value"><?php echo '20' ?></div>
                                <div class="lead-text"><?php echo 'Purchased' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value"><?php echo '4' ?></div>
                                <div class="lead-text"><?php echo 'Closed' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value"><?php echo '20%' ?></div>
                                <div class="lead-text"><?php echo 'Close Ratio' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value"><?php echo '$41.00' ?></div>
                                <div class="lead-text"><?php echo 'Avg. Cost per Lead' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value"><?php echo '$788.00' ?></div>
                                <div class="lead-text"><?php echo 'Total Spend' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value"><?php echo '$ 245.00' ?></div>
                                <div class="lead-text"><?php echo 'CPA' ?></div>
                            </div>
                            <div class="lead-col">
                                <input type="checkbox" data-on-text="ON" data-off-text="OFF" name="activeall" class="make-switch"/>
                            </div>
                        </div>
                        <div class="lead-row table-responsive" style="display: none;">
                            <table class="table table-bordered lead-table" cellspacing="0" cellpadding="0">
                                <thead class="custom-table-heading">
                                    <tr>
                                        <td>Campaign Name</td>
                                        <td>Lead Category</td>
                                        <td>Bid Type</td>
                                        <td>Purchased</td>
                                        <td>Closed</td>
                                        <td>Cost Per Lead</td>
                                        <td>Total Spend</td>
                                        <td>Daily Budget</td>
                                        <td>Bid</td>
                                        <td style="width: 120px;">Active</td>
                                        <td>Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($data_leads) > 0) : ?>
                                        <?php foreach ($data_leads as $data_lead): ?>
                                            <tr>
                                                <td><?= $data_lead['name'] ?></td>
                                                <td><?= $data_lead['lead_category'] ?></td>
                                                <td><?= $data_lead['bid_type'] ?></td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>--</td>
                                                <td>$<?= $data_lead['daily_budget'] ?></td>
                                                <td>--</td>
                                                <td>
                                                    <?php
                                                    if ($data_lead['active'] == 1) {
                                                        $check = 'checked="checked"';
                                                    } else {
                                                        $check = '';
                                                    }
                                                    ?>
                                                    <input type="checkbox" data-on-text="ON" data-off-text="OFF" name="campaign_status" class="make-switch" data-camp-id="<?php echo $data_lead['campaign_id']; ?>" <?php echo $check; ?>/>
                                                </td>
                                                <td>
                                                    <a href="<?= site_url('leadstore/edit/' . encode_url($data_lead['campaign_id'])) ?>" title="Edit"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr class="text-center">
                                            <td colspan="11"><strong> No Campaigns Found</strong></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End Real - Time Data Leads -->
                <div class="lead-row-footer">
                    <a hrf="javascript:;" id="mini-2" onclick="toggleDiv('2')" style="display: none;"><i class="fa fa-chevron-up" aria-hidden="true"></i><?php echo 'Minimize' ?><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
                    <a hrf="javascript:;" id="expand-2" onclick="toggleDiv('2')"><i class="fa fa-chevron-down" aria-hidden="true"></i><?php echo 'Expand' ?><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                </div>


                <!-- Aged Leads -->
                <div class="lead-company" id="lead-conpany-3" data-toggle="close">
                    <div class="lead-title">
                        <h2 class="custom-lead-title">Aged Leads</h2>
                    </div>
                    <div class="lead-data">
                        <div class="lead-row">
                            <div class="lead-col">
                                <div class="lead-value" data-value="<?php echo $totalPurchasedAgedLead ?>" data-counter="counterup"><?php echo 0; ?></div>
                                <div class="lead-text"><?php echo 'Purchased' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value"><?php echo $totalClosedAgedLead ?></div>
                                <div class="lead-text"><?php echo 'Closed' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value">
                                    <span data-value="<?php echo $totalClosedAgedLeadRation ?>" data-counter="counterup">0</span><span>&percnt;</span>
                                </div>
                                <div class="lead-text"><?php echo 'Close Ratio' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value">
                                    <span>&dollar;</span>
                                    <span data-value="<?php echo formatMoney($averagePeragedLeadCost, 2) ?>" data-counter="counterup">0</span>
                                </div>
                                <div class="lead-text"><?php echo 'Avg. Cost per Lead' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value">
                                    <span>&dollar;</span>
                                    <span data-value="<?php echo formatMoney($totalAgedSpent, 2) ?>" data-counter="counterup">0</span>
                                </div>
                                <div class="lead-text"><?php echo 'Total Spend' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value">
                                    <span>&dollar;</span>
                                    <span data-value="<?php echo formatMoney($agedLeadCPA, 2) ?>" data-counter="counterup">0</span>
                                </div>
                                <div class="lead-text"><?php echo 'CPA' ?></div>
                            </div>
                            <div class="lead-col">
                                <a id="aged_lead_buy" class="btn green sbold" data-target="#large" data-toggle="modal" data-backdrop="static" data-keyboard="false" href="<?php echo site_url('storecheckout/filter/aged') ?>"> BUY NOW </a>
                            </div>
                        </div>
                        <div class="lead-row table-responsive" style="display: none;">
                            <table id="datatable-age" class="table table-bordered lead-purchased <?php echo(count($aged_purchased_lead_data) <= 0) ? 'no-data-table-custom' : '' ?>" cellspacing="0" cellpadding="0">
                                <thead class="custom-table-heading">
                                    <tr>
                                        <td class="col-xs-2">Date - Time</td>
                                        <td class="col-xs-2">File Name</td>
                                        <td class="col-xs-1">Lead Category</td>
                                        <td class="col-xs-1">Quantity Purchased</td>
                                        <td class="col-xs-2">Price Per Lead</td>
                                        <td class="col-xs-2">Total Purchase Price</td>
                                        <td class="col-xs-2">Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($aged_purchased_lead_data) > 0) : ?>
                                        <?php foreach ($aged_purchased_lead_data as $purchased_data_lead): ?>
                                            <tr>
                                                <td class="col-xs-2"><?php echo formatDate($purchased_data_lead['created']); ?></td>
                                                <td class="col-xs-2"><?php echo $purchased_data_lead['csv_file_name']; ?></td>
                                                <td class="col-xs-1">Medicare</td>
                                                <td class="col-xs-1"><?php echo $purchased_data_lead['qty']; ?></td>
                                                <td class="col-xs-2"><?php echo formatMoney($purchased_data_lead['item_price'], 2, TRUE); ?></td>
                                                <td class="col-xs-2"><?php echo formatMoney($purchased_data_lead['total_price'], 2, TRUE); ?></td>
                                                <td class="col-xs-2">
                                                    <a class="action-box" href="<?php echo base_url('/Storecheckout/copy_lead/' . urlencode(base64_encode($purchased_data_lead['order_item_id']))); ?>" title="Copy"><i class="fa fa-copy" aria-hidden="true"></i></a>
                                                    <a class="action-box" href="<?php echo base_url('/Storecheckout/DownloadLeadCSV/' . urlencode(base64_encode($purchased_data_lead['order_item_id']))); ?>" title="Download"><i class="fa fa-download" aria-hidden="true"></i></a>
                                                    <a class="action-box" href="<?php echo base_url('/leadstore/receipt/' . urlencode(base64_encode($purchased_data_lead['order_item_id']))); ?>" title="View Receipt"><i class="fa fa-file-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr class="text-center">
                                            <td colspan="11" class="no-data"><strong> No Date Found</strong></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End Aged Leads -->

                <div class="lead-row-footer">
                    <a hrf="javascript:;" id="mini-3" onclick="toggleDiv('3')" style="display: none;"><i class="fa fa-chevron-up" aria-hidden="true"></i><?php echo 'Minimize' ?><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
                    <a hrf="javascript:;" id="expand-3" onclick="toggleDiv('3')"><i class="fa fa-chevron-down" aria-hidden="true"></i><?php echo 'Expand' ?><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                </div>

                <!-- Row Data -->
                <div class="lead-company" id="lead-conpany-4" data-toggle="close">
                    <div class="lead-title">
                        <h2 class="custom-lead-title">Raw Data</h2>
                    </div>
                    <div class="lead-data">
                        <div class="lead-row">
                            <div class="lead-col">
                                <div class="lead-value" data-value="<?php echo $totalPurchasedRawLead ?>" data-counter="counterup"><?php echo 0 ?></div>
                                <div class="lead-text"><?php echo 'Purchased' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value" data-value="<?php echo $totalClosedRawLead ?>" data-counter="counterup"><?php echo 0 ?></div>
                                <div class="lead-text"><?php echo 'Closed' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value" >
                                    <span data-value="<?php echo $totalClosedRawLeadRation ?>" data-counter="counterup">0</span><span>&percnt;</span>
                                </div>
                                <div class="lead-text"><?php echo 'Close Ratio' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value">
                                    <span>&dollar;</span>
                                    <span data-value="<?php echo formatMoney($averagePerRawLeadCost, 2) ?>" data-counter="counterup">0</span>
                                </div>
                                <div class="lead-text"><?php echo 'Avg. Cost per Lead' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value" >
                                    <span>&dollar;</span>
                                    <span data-value="<?php echo formatMoney($totalRawSpent, 2) ?>" data-counter="counterup">0</span>
                                </div>
                                <div class="lead-text"><?php echo 'Total Spend' ?></div>
                            </div>
                            <div class="lead-col">
                                <div class="lead-value">
                                    <span>&dollar;</span>
                                    <span data-value="<?php echo formatMoney($rawLeadCPA, 2) ?>" data-counter="counterup">0</span>
                                </div>
                                <div class="lead-text"><?php echo 'CPA' ?></div>
                            </div>
                            <div class="lead-col">
                                <a id="raw_lead_buy" class="btn green sbold" data-target="#large" data-toggle="modal" data-backdrop="static" data-keyboard="false" href="<?php echo site_url('storecheckout/filter/raw') ?>"> BUY NOW </a>
                            </div>
                        </div>
                        <div class="lead-row table-responsive lead-store-table-fixes" style="display: none;">
                            <table id="datatable-raw" class="table table-bordered lead-purchased <?php echo(count($raw_purchased_lead_data) <= 0) ? 'no-data-table-custom' : '' ?>">
                                <thead class="custom-table-heading">
                                    <tr>
                                        <td class="col-xs-2">Date - Time</td>
                                        <td class="col-xs-2">File Name</td>
                                        <td class="col-xs-1">Lead Category</td>
                                        <td class="col-xs-1">Quantity Purchased</td>
                                        <td class="col-xs-2">Price Per Lead</td>
                                        <td class="col-xs-2">Total Purchase Price</td>
                                        <td class="col-xs-2">Actions</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($raw_purchased_lead_data) > 0) : ?>
                                        <?php foreach ($raw_purchased_lead_data as $purchased_data_lead): ?>
                                            <tr>
                                                <td class="col-xs-2"><?php echo formatDate($purchased_data_lead['created']); ?></td>
                                                <td class="col-xs-2"><?php echo $purchased_data_lead['csv_file_name']; ?></td>
                                                <td class="col-xs-1">Medicare</td>
                                                <td class="col-xs-1"><?php echo $purchased_data_lead['qty']; ?></td>
                                                <td class="col-xs-2"><?php echo formatMoney($purchased_data_lead['item_price'], 2, TRUE); ?></td>
                                                <td class="col-xs-2"><?php echo formatMoney($purchased_data_lead['total_price'], 2, TRUE); ?></td>
                                                <td class="col-xs-2">
                                                    <a class="action-box" href="<?php echo base_url('/Storecheckout/copy_lead/' . urlencode(base64_encode($purchased_data_lead['order_item_id']))); ?>" title="Copy"><i class="fa fa-copy" aria-hidden="true"></i></a>
                                                    <a class="action-box" href="<?php echo base_url('/Storecheckout/DownloadLeadCSV/' . urlencode(base64_encode($purchased_data_lead['order_item_id']))); ?>" title="Download"><i class="fa fa-download" aria-hidden="true"></i></a>
                                                    <a class="action-box" href="<?php echo base_url('/leadstore/receipt/' . urlencode(base64_encode($purchased_data_lead['order_item_id']))); ?>" title="View Receipt"><i class="fa fa-file-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr class="text-center">
                                            <td colspan="11" class="no-data"><strong> No Date Found</strong></td>
                                        </tr>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End Row Data -->

                <div class="lead-row-footer">
                    <a hrf="javascript:;" id="mini-4" onclick="toggleDiv('4')" style="display: none;"><i class="fa fa-chevron-up" aria-hidden="true"></i><?php echo 'Minimize' ?><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
                    <a hrf="javascript:;" id="expand-4" onclick="toggleDiv('4')"><i class="fa fa-chevron-down" aria-hidden="true"></i><?php echo 'Expand' ?><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                </div>

            </div> <!-- .lead-content -->
        </div>
    </div>
</div>
<!-- popup window -->
<div class="modal fade bs-modal-lg aged-lead-model" id="large" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo site_url() ?>/assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="filter_id" id="filter_id" />
<script type="text/javascript">
    jQuery(document).ready(function () {
        $(".make-switch").bootstrapSwitch();
        jQuery('#datatable-raw').dataTable({"bSort": false});
        jQuery('#datatable-age').dataTable({"bSort": false});
        $('#large').on('hidden.bs.modal', function () {
            var html = '<div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-body"><img src="<?php echo site_url() ?>/assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading"><span> &nbsp;&nbsp;Loading... </span></div></div></div>';
            jQuery(this).html(html);
        });

        /*--------- Check continue shopping ----------*/
        var conti_shop = "<?= $conti_shop ?>";
        if (conti_shop == 'YES') {
            var conti_cat = "<?= $conti_cat ?>";
            if (conti_cat == 'aged') {
                $("#aged_lead_buy").click();
            } else {
                $("#raw_lead_buy").click();
            }
        }
        /*--------- End Check continue shopping ----------*/
    });

    $('#buy-now').click(function () {

    });

    $('.btn-toggle').click(function () {
        jQuery(this).find('.btn').toggleClass('active');
        if ($(this).find('.btn-primary').size() > 0) {
            $(this).find('.btn').toggleClass('btn-primary');
        }
    });
    function toggleDiv(id) {
        var cnt = 0;
        jQuery('#lead-conpany-' + id).find('.lead-data').find('.lead-row-seprator').slideToggle();
        jQuery('#lead-conpany-' + id).find('.lead-data').find('.lead-row').each(function () {
            if (cnt > 0) {
                jQuery(this).slideToggle();
            }
            cnt++;
        });
        if (jQuery('#lead-conpany-' + id).attr('data-toggle') == 'close') {
            jQuery('#mini-' + id).show();
            jQuery('#expand-' + id).hide();
            jQuery('#lead-conpany-' + id).attr('data-toggle', 'open');
        } else {
            jQuery('#mini-' + id).hide();
            jQuery('#expand-' + id).show();
            jQuery('#lead-conpany-' + id).attr('data-toggle', 'close');
        }
    }


    /* -------- change Live transfer lead (campaign) status --------*/
    jQuery('input[name=campaign_status]').on('switchChange.bootstrapSwitch', function (event, state) {
        if (state) {
            var status = 1;
        } else {
            var status = 0;
        }
        var camp_id = $(this).data('camp-id');

        jQuery.ajax({
            url: '<?php echo site_url("leadstore/change_campaign_status") ?>',
            method: 'POST',
            data: {campaign_id: camp_id, active: status},
            success: function (res) {
                // console.log(res);
            },
        });



    });
    /* -------- End change Live transfer lead (campaign) status --------*/


</script>
<?php $this->load->view('agent/leadstore/billing/add-fund.php') ?>