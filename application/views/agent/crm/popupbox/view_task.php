<style>
    .lead_input_div{
        position: relative;
        display: inline-block;
        width:70%;
    }
    .lead_input_div input{width: 100% !important;}
    .lead_input_div span.input-group-btn {
        position: absolute; 
        right: 42px;
        top: 0px;
    }
    .nipl-lead-model .input-group.date-picker.input-daterange input{
        width:100%;
    }
    .nipl-lead-model .input-daterange {
        width: 70%;
    }
</style>
<div class="modal-dialog modal-lg nipl-lead-model nipl_dynamic_model">
    <?php $task = $task_info[0] ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"></h4>
                <div class="caption font-dark">
                    <i class="fa fa-building-o font-dark"></i>
                    <span class="caption-subject bold uppercase" style="font-size: 16px;"><?php echo $title; ?></span>
                </div>
            </div>
            <div class="modal-body"> 
                <div class="portlet-body">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">Task Description :</label>
                            <div class="nipl_input_div">
                                <span class="control-label"> <?php echo $task['task_description']; ?> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Task Date :</label>
                            <div class="nipl_input_div">
                                <span class="control-label"> <?php echo $task['task_date']; ?> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Task Start Time :</label>
                            <div class="lead_input_div">
                                <span class="control-label"> <?php echo $task['task_start_time']; ?> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Task End Time :</label>
                            <div class="lead_input_div">
                                <span class="control-label"> <?php echo $task['task_end_time']; ?> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Assign Agent Name  :</label> 
                            <div class="nipl_input_div">
                                <span class="control-label"> <?php echo $task['assign_agent_name']; ?> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Task Note :</label>
                            <div class="nipl_input_div">
                                <span class="control-label"> <?php echo $task['task_note']; ?> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Task Status:</label>
                            <div class="nipl_input_div">
                                <span class="control-label"> <?php echo $task['task_status']; ?> </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </div>
    <!-- /.modal-content -->
</div> 
<!-- /.modal-dialog -->
