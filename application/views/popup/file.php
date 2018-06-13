<form method="post" enctype="multipart/form-data" class="form-horizontal" action="" onsubmit="uploadFiles(event)">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title"><?php echo 'Attach Document' ?></h4>
    </div>
    <div class="modal-body">
        <!-- ============= List File Upload For this Lead ============== -->
        <?php if(count($files) > 0) :?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>File Name</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($files as $key=>$file) :?>
                            <tr>
                                <td><?=$key+1?></td>
                                <td><a href="<?php echo site_url('uploads/leads/agent/'.$file->path) ?>" target="_blank"><?=$file->path?></a></td>
                                <td><?=$file->created?></td>
                            </tr>    
                        <?php endforeach; ?>
                    </tbody>
                </table> 
            </div>
        <?php endif; ?>
        <!-- ============= End List File Upload For this Lead ============== -->
        <div class="form-group form-group-md">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'File' ?></label>
                    <div class="col-md-6">
                        <input type="file" name="attachment" onchange="prepareUpload(event)" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"><?php echo 'File Name' ?></label>
                    <div class="col-md-6">
                        <input type="text" name="attachname" class="form-control" placeholder="example, Schedule of Benefits"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn blue"><?php echo 'Save' ?></button>
    </div>
</form>
<script type="text/javascript">
    var files;
// Grab the files and set them to our variable
    function prepareUpload(event) {
        files = event.target.files;
    }
    function uploadFiles(event) {
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening
        jQuery('#loading').modal('show');
        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
        var data = new FormData();
        jQuery.each(files, function (key, value){
            data.append('attachment', value);
        });

        data.append('attachname', jQuery('[name="attachname"]').val());
        jQuery.ajax({
            url: '<?php echo site_url('lead/upload/' . encode_url($leadId)) ?>',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function (data){
                jQuery('.message').html(data.html);
                jQuery('#ajax').modal('hide');
                jQuery('#loading').modal('hide');
            },
            error: function (jqXHR, textStatus, errorThrown){
                // Handle errors here
                jQuery('#loading').modal('hide');
                // STOP LOADING SPINNER
            }
        });
    }
</script>