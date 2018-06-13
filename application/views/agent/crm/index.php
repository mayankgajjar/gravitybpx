<style>
    #filter_data .actions{
        margin: 15px 5px;
        float: right;
    }
    #filter_data .actions label{
        margin-bottom: 5px;
    }

    .lead-details{
        padding-left: 0;
        list-style: none;
    }
    .lead-details li{
        display: inline-block;
        color: #A6A8A8;
        margin-right: 10px;
    }
    .lead-details li > span > i{
        color : #26A1AB;
    }
    .opportu .mt-action-info {
        padding: 10px 0px;
    }
    .opportu ul.lead-details {
        margin-left: 50px;
        text-align: center;
    }
    .opportu .dropdown-menu > li {
        display: inline-block;
        float: none;
        text-align: center;
    }
    .opportu .dropdown-menu > li > a i {
        color: #337ab7 !important;
        font-size: 18px;
    }
    .opportu .dropdown-menu > li > a {
        line-height: 25px;
        padding: 9px 10px 5px;
    }
    .opportu .mt-action-body{
        overflow: visible!important;
    }
    .opportu ul.lead-details {
        margin-left: 0;
    }
    .opportu ul.lead-details li{float:left;}
    .opportu .mt-action-img{width:8% !important;}
    .opportu .mt-action-body{width:92% !important;float:left !important;}
    .opportu .mt-action{overflow: hidden;}
    .opportu{padding: 0 !important;}
    .opportu .mt-action-info > img {
        padding-left: 20px;
    }
    @media(max-width:1200px){
        .opportu{
            overflow-y: hidden;
            width: 100%;
        }
        .opportu .mt-actions{
            width: 700px;
        }
    }
    @media(max-width:767px){
        .opportu .mt-actions,
        .opportu .mt-action-info,
        .opportu .mt-action-buttons  {
            display: inline-block !important;
        }
        .opportu .mt-action-buttons{
            margin-right: 20px;
        }
    }
</style>

<div class="breadcrumbs lead">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo 'CRM' ?>
        </li>
    </ol>
</div>

<!-- Filter Data -->
<div class="row">
    <form name="filter_data" method="POST" id="filter_data">
        <div class="actions">
            <div class="btn-group btn-group-devided" data-toggle="buttons">
                <label class="btn green btn-outline btn-circle btn-sm Today">
                    <input type="radio" name="duration" class="toggle" value="Today">Today</label>
                <label class="btn green btn-outline btn-circle btn-sm Week">
                    <input type="radio" name="duration" class="toggle" value="Week">This Week</label>
                <label class="btn green btn-outline btn-circle btn-sm Month">
                    <input type="radio" name="duration" class="toggle" value="Month">This Month</label>
                <label class="btn green btn-outline btn-circle btn-sm Quarter">
                    <input type="radio" name="duration" class="toggle" value="Quarter">This Quarter</label>
                <label class="btn green btn-outline btn-circle btn-sm Year">
                    <input type="radio" name="duration" class="toggle" value="Year">This Year</label>
                <label class="btn green btn-outline btn-circle btn-sm All">
                    <input type="radio" name="duration" class="toggle" value="All">All Time</label>
            </div>
        </div>
        <script>
            $("input[name=duration]").change(function () {
                $('#filter_data').submit();
            });
            $(".<?php echo $duration; ?>").addClass('active');
        </script>
    </form>
</div>
<!-- End Filter Data -->


<div class="row">
    <div class="message"></div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="javascript:;" class="crm-dashboard-stat dashboard-stat dashboard-stat-v2 blue">
            <div class="visual">
                <i class="fa fa-comments"></i>
            </div>
            <div class="details">
                <div class="desc"> <?php echo 'Total Leads' ?> </div>
                <div class="number">
                    <span data-value="<?php echo $totalAssignedLeads ?>" data-counter="counterup">0</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="javascript:;" class="crm-dashboard-stat dashboard-stat dashboard-stat-v2 red">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="desc"> <?php echo 'Total Opportunities' ?> </div>
                <div class="number">
                    <span data-value="<?php echo $totalOpportunityLeads; ?>" data-counter="counterup">0</span></div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="javascript:;" class="crm-dashboard-stat dashboard-stat dashboard-stat-v2 green">
            <div class="visual">
                <i class="fa fa-users"></i>
            </div>
            <div class="details">
                <div class="desc"> <?php echo 'Total Clients' ?> </div>
                <div class="number">
                    <span data-value="<?php echo $totalClientLeads; ?>" data-counter="counterup">0</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a href="javascript:;" class="crm-dashboard-stat dashboard-stat dashboard-stat-v2 purple">
            <div class="visual">
                <i class="fa fa-globe"></i>
            </div>
            <div class="details">
                <div class="desc"> <?php echo 'Total Premiums' ?> </div>
                <div class="number"> $
                    &nbsp;<span data-value="<?php echo isset($totalPremiumLeads) ? $totalPremiumLeads : '0'; ?>" data-counter="counterup">0</span> </div>
            </div>
        </a>
    </div>
</div>

<!-- Recent Leads & Oppurtunities -->
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark"><?php echo 'Recent Leads' ?></span>
                </div>
                <div class="actions">

                </div>
            </div>
            <div class="portlet-body recent-leads">
                <div class="mt-actions">
                    <?php if (count($recentLeads) > 0): ?>
                        <?php foreach ($recentLeads as $lead): ?>
                            <div class="mt-action">
                                <div class="mt-action-img">
                                    <img src="<?php echo site_url() ?>uploads/agents/users.jpg" width="40" />
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-details ">
                                                <span class="mt-action-author"><a href="<?php echo site_url('crm/edit/lead/' . encode_url($lead['lead_id'])); ?>"><?php echo $lead['first_name'] . ' ' . $lead['last_name'] ?></a></span>
                                                <p class="mt-action-desc"><?php echo formatPhoneNumber($lead['phone']) ?></p>
                                            </div>
                                            <ul class="lead-details">
                                                <li class="leadinfo lead-email" title="Email"><i class="fa fa-envelope"></i> <?= isset($lead['email']) ? $lead['email'] : '-' ?></li>
                                                <li class="leadinfo lead-source" title="Source"><i class="fa fa-location-arrow"></i> <?= isset($lead['source']) ? $lead['source'] : '-' ?> </li>
                                                <li class="leadinfo lead-created" title="Created On"><i class="fa fa-clock-o"></i> <?= $lead['created'] ?></li>
                                            </ul>

                                        </div>
                                        <div class="mt-action-buttons ">
                                            <div class="btn-group">
                                                <a class="a-tooltip" data-placement="bottom" title="Call" href="javasceipt:;"><i class="icon-call-out"></i></a>
                                                <a class="a-tooltip sms_lead" data-placement="bottom" title="Message" href="javasceipt:;" style="font-size: 12px;" data-target="#smsbox" data-toggle="modal" data-lead-id='<?php echo encode_url($lead['lead_id']); ?>' ><i class="fa fa-2x fa-comments-o"></i></a>
                                                <a class="a-tooltip" data-placement="bottom" href="<?php echo site_url('lead/emailpopup/' . encode_url($lead['lead_id'])) ?>" data-target="#ajaxemail" title="Email Message" data-toggle="modal"><i class="icon-envelope"></i></a>
                                                <a class="a-tooltip" data-placement="bottom" href="<?php echo site_url('lead/filepopup/' . encode_url($lead['lead_id'])) ?>" data-target="#ajax" title="File Upload" data-toggle="modal"><i class="  icon-paper-clip"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark"><?php echo 'Recent Opportunities' ?></span>
                </div>
                <div class="actions">

                </div>
            </div>
            <div class="opportu portlet-body">
                <div class="mt-actions">
                    <?php if (count($recentOppurtunities) > 0) : ?>
                        <?php foreach ($recentOppurtunities as $oppurtunity): ?>
                            <div class="mt-action">
                                <div class="mt-action-img">
                                    <img src="<?php echo site_url() ?>uploads/agents/users.jpg" width="40">
                                </div>
                                <div class="mt-action-body">
                                    <div class="mt-action-row">
                                        <div class="mt-action-info ">
                                            <div class="mt-action-details ">
                                                <span class="mt-action-author"><a href="<?php echo site_url('crm/edit/opportunity/' . encode_url($oppurtunity['lead_id'])); ?>"><?php echo $oppurtunity['first_name'] . ' ' . $oppurtunity['last_name'] ?></a></span>
                                            </div>
                                        </div>
                                        <div class="mt-action-info ">
                                            <?php if ($oppurtunity['opportunity_status'] == 'Pre-Qualified') : ?>
                                                <img src="<?php echo site_url('') ?>assets/images/stepwizard/step-wizzard1.png" />
                                            <?php elseif ($oppurtunity['opportunity_status'] == 'Appointment Set') : ?>
                                                <img src="<?php echo site_url('') ?>assets/images/stepwizard/step-wizzard2.png" />
                                            <?php elseif ($oppurtunity['opportunity_status'] == 'Quote Sent') : ?>
                                                <img src="<?php echo site_url('') ?>assets/images/stepwizard/step-wizzard3.png" />
                                            <?php elseif ($oppurtunity['opportunity_status'] == 'Quote Accepted') : ?>
                                                <img src="<?php echo site_url('') ?>assets/images/stepwizard/step-wizzard4.png" />
                                            <?php elseif ($oppurtunity['opportunity_status'] == 'Deal Won') : ?>
                                                <img src="<?php echo site_url('') ?>assets/images/stepwizard/step-wizzard5.png" />
                                            <?php else : ?>
                                                <img src="<?php echo site_url('') ?>assets/images/stepwizard/step-wizzard1.png" />
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-action-buttons ">
                                            <div class="btn-group">
                                                <a class="a-tooltip" data-placement="bottom" title="Call" href="javasceipt:;"><i class="icon-call-out"></i></a>
                                                <a class="a-tooltip sms_lead" data-placement="bottom" title="Message" href="javasceipt:;" style="font-size: 12px;" data-target="#smsbox" data-toggle="modal" data-lead-id='<?php echo encode_url($oppurtunity['lead_id']); ?>'><i class="fa fa-2x fa-comments-o"></i></a>
                                                <a class="a-tooltip" data-placement="bottom"  href="<?php echo site_url('lead/emailpopup/' . encode_url($oppurtunity['lead_id'])) ?>" data-target="#ajaxemail" title="Email Message" data-toggle="modal"><i class="icon-envelope"></i></a>
                                                <a class="a-tooltip" data-placement="bottom"  href="<?php echo site_url('lead/filepopup/' . encode_url($oppurtunity['lead_id'])) ?>" data-target="#ajax" title="Fil Upload" data-toggle="modal"><i class="  icon-paper-clip"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="lead-details">
                                    <li class="leadinfo lead-phone">
                                        <i class="fa fa-phone"></i>
                                        <?php echo formatPhoneNumber($oppurtunity['phone']) ?>
                                    </li>
                                    <li class="leadinfo lead-email" title="Email"><i class="fa fa-envelope"></i> <?= isset($oppurtunity['email']) ? $oppurtunity['email'] : '-' ?></li>
                                    <li class="leadinfo lead-source" title="Source"><i class="fa fa-location-arrow"></i> <?= isset($oppurtunity['source']) ? $oppurtunity['source'] : '-' ?> </li>
                                    <li class="leadinfo lead-created" title="Created On"><i class="fa fa-clock-o"></i> <?= $oppurtunity['created'] ?></li>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Recent Leads & Oppurtunities-->

<!-- Recent Client -->
<div class="row over-leads">
    <div class="col-md-12 col-sm-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark"><?php echo 'Recent Clients' ?></span>
                </div>
                <div class="actions">

                </div>
            </div>
            <div class="portlet-body">
                <div class="clients mt-actions">
                    <div class="table-responsive">
                        <table class="table recent-client">
                            <thead>
                                <tr>
                                    <th> &nbsp; </th>
                                    <th> &nbsp; </th>
                                    <th> <?php echo 'Email' ?> </th>
                                    <th> <?php echo 'Source' ?> </th>
                                    <th> <?php echo 'Carrier' ?> </th>
                                    <th> <?php echo 'Plan' ?> </th>
                                    <th> <?php echo 'Policy ID' ?> </th>
                                    <th> <?php echo 'Dependents' ?> </th>
                                    <th> <?php echo 'Created' ?> </th>
                                    <th> &nbsp </th>
                                </tr>
                            </thead>
                            <tbody class="mt-action-body">
                                <?php if (count($recentClients) > 0): ?>
                                    <?php
                                    $i = 0;
                                    foreach ($recentClients as $client) : $i++;
                                        ?>
                                        <?php $position = 'bottom'; ?>
                                        <?php if (count($recentClients) == $i): ?>
                                            <?php $position = 'top'; ?>
                                        <?php endif; ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo site_url() ?>uploads/agents/users.jpg" width="40">
                                            </td>
                                            <td>
                                                <span class="mt-action-author"><a href="<?php echo site_url('crm/edit/client/' . encode_url($client['main_lead_id'])); ?>"><?php echo $client['first_name'] . ' ' . $client['last_name'] ?></a></span>
                                                <p class="mt-action-desc"><?php echo formatPhoneNumber($client['phone']) ?></p>
                                            </td>
                                            <td>
                                                <p class="mt-action-desc a-tooltip" data-toggle="tooltip" data-placement="<?php echo $position ?>" title="<?php echo $client['email'] ?>"><?php echo substr($client['email'], 0, 10) . '...' ?>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mt-action-desc a-tooltip" data-toggle="tooltip" data-placement="<?php echo $position ?>" title="<?php echo $client['source'] ?>">
                                                    <?php if (strlen($client['source']) > 10) : ?>
                                                        <?php echo substr($client['source'], 0, 10) . '...' ?>
                                                    <?php else: ?>
                                                        <?php echo $client['source'] ?>
                                                    <?php endif; ?>
                                                </p>
                                            </td>
                                            <td>
                                                <p class="mt-action-desc"><?php echo $client['company_name'] ?></p>
                                            </td>
                                            <td>
                                                <p class="mt-action-desc"><?php echo $client['plan_type'] ?></p>
                                            </td>
                                            <td>
                                                <p class="mt-action-desc"><?php echo $client['product_policy_no'] ?></p>
                                            </td>
                                            <td>
                                                <p class="mt-action-desc"><?php echo 0 ?></p>
                                            </td>
                                            <td>
                                                <p class="mt-action-desc"><?php echo formatDate($client['main_created']) ?></p>
                                            </td>
                                            <td>
                                                <div class="mt-action-buttons ">
                                                    <div class="btn-group">
                                                        <a class="a-tooltip" data-placement="<?php echo $position ?>" href="javasceipt:;" title="Call"><i class="icon-call-out"></i></a>
                                                        <a class="a-tooltip sms_lead" data-placement="<?php echo $position ?>" href="javasceipt:;" style="font-size: 12px;" title="Message" data-target="#smsbox" data-toggle="modal" data-lead-id='<?php echo encode_url($client['main_lead_id']); ?>'><i class="fa fa-2x fa-comments-o"></i></a>
                                                        <a class="a-tooltip" data-placement="<?php echo $position ?>" href="<?php echo site_url('lead/emailpopup/' . encode_url($client['main_lead_id'])) ?>" data-target="#ajaxemail" title="Email Message" data-toggle="modal"><i class="icon-envelope"></i></a>
                                                        <a class="a-tooltip" data-placement="<?php echo $position ?>" href="<?php echo site_url('lead/filepopup/' . encode_url($client['main_lead_id'])) ?>" data-target="#ajax" title="File Upload" data-toggle="modal"><i class="  icon-paper-clip"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center"><?php echo 'No Clients found.' ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Recent Client -->

<!--DOC: Aplly "modal-cached" class after "modal" class to enable ajax content caching-->
<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo site_url() ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajaxemail" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo site_url() ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
<div class="modal fade" id="smsbox" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="sms-text-box">
                <div class="modal-body">
                    <img src="<?php echo site_url() ?>assets/theam_assets/global/img/loading-spinner-grey.gif" alt="" class="loading">
                    <span> &nbsp;&nbsp;Loading... </span>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).on("click", ".sms_lead", function (event) {
        var checkIDS = [];
        var idsJson = [];
        var ID = $(this).attr("data-lead-id");
        checkIDS.push({
            'send': ID
        });
        idsJson = JSON.stringify(checkIDS);
        jQuery.ajax({
            url: '<?= site_url('lead/sendSMS/') ?>',
            method: 'post',
            data: {idsJson: idsJson, reload: 'false'},
            success: function (result) {
                jQuery(".sms-text-box").html(result);
            }
        });
    });
</script>
