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
                    </div>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable">
                <thead>
                    <tr>
                        <th>
                            <?php echo '#' ?>
                        </th>
                        <th> <?php echo "Lead ID"; ?> </th>
                        <th> <?php echo "Status"; ?> </th>
                        <th> <?php echo "Vendor ID"; ?> </th>
                        <th> <?php echo "Last Agent"; ?> </th>
                        <th> <?php echo "List ID"; ?> </th>
                        <th> <?php echo "Phone"; ?> </th>
                        <th> <?php echo "Name"; ?> </th>
                        <th> <?php echo "City"; ?></th>
                        <th> <?php echo "Security"; ?> </th>
                        <th> <?php echo "Last Call" ?> </th>
                        <th> <?php echo "Agency" ?> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach($results as $result): $i++; ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><a href="<?php echo site_url('dialer/alists/addlead/'.  encode_url($result->lead_id)) ?>" target="_blank"><?php echo $result->lead_id; ?></a></td>
                        <td><?php echo $result->status; ?></td>
                        <td><?php echo $result->vendor_lead_code; ?></td>
                        <td><?php echo $result->user; ?></td>
                        <td><?php echo $result->list_id; ?></td>
                        <td><?php echo $result->phone_number; ?></td>
                        <td><?php echo $result->first_name.' '.$result->last_name; ?></td>
                        <td><?php echo $result->city; ?></td>
                        <td><?php echo $result->security_phrase; ?></td>
                        <td><?php echo $result->last_local_call_time; ?></td>
                        <td>
                            <?php $alist = $this->alists_m->get_by(array('vicidial_list_id' => $result->list_id), TRUE); ?>
                            <?php $agency = $this->agency_model->getAgencyInfo($alist->agency_id); ?>
                            <?php if($agency): ?>
                                <a target="_blank" href="<?php echo site_url('agency/manage_agency/agency_info/'.$agency->id) ?>"><?php echo $agency->name; ?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
</div>
<script type="text/javascript">
    jQuery(function(){
        jQuery('#datatable').dataTable({
            "columnDefs": [ {
                'orderable': false,
                'targets': [0]
            }]
        });
//        jQuery('#datatable').dataTable( {
//                "bProcessing": true,
//                "bServerSide": true,
//                "sAjaxSource": "<?php //echo site_url('dialer/lists/indexJson'); ?>",
//                "columnDefs": [ {
//                    'orderable': false,
//                    'targets': [0,4,5,10]
//                },{
//                    "searchable": false,
//                    "targets": [0,4,5,10]
//                }],
//                "order": [
//                        [0, "DESC"]
//                    ]
//            });
    });
</script>
