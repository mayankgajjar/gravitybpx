<h4><?php echo "Documents" ?></h4>
<div class="message"></div>
<table class="table table-striped">
    <caption class="caption text-center"><strong><?php echo 'Attached Files' ?></strong></caption>
    <thead>
        <tr>
            <th>#</th>
            <th><?php echo 'Description' ?></th>
            <th><?php echo 'Actions' ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if ($leadDocs): ?>
            <?php $i = 0; ?>
            <?php foreach ($leadDocs as $doc): ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><a href="<?php echo site_url('uploads/leads/agent/'.$doc->path) ?>" target="_blank"><?php echo $doc->path ?></a></td>
                    <td><a href="javascript:;" onclick="fileDelete('<?php echo encode_url($doc->file_id) ?>')"><?php echo 'Delete' ?></a></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td align="center" colspan="3"><?php echo 'No Documents found.' ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<h3><?php echo "Attach A File:" ?></h3>
<form method="post" enctype="multipart/form-data" class="form-horizontal" action="" onsubmit="uploadFiles(event)">
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo 'File' ?></label>
            <div class="col-md-4">
                <input type="file" name="attachment" onchange="prepareUpload(event)" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo 'File Name' ?></label>
            <div class="col-md-4">
                <input type="text" name="attachname" class="form-control" placeholder="example, Schedule of Benefits"/>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-4 col-md-8">
                <button type="submit" class="btn green"><?php echo 'Upload' ?></button>
            </div>
        </div>
    </div>
</form>
<h3><?php echo "Call Recording Files:" ?></h3>
<table class="table table-border">
    <tbody>
        <?php if(count($recordings) > 0): ?>
            <?php $i=1;foreach($recordings as $record): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><audio controls><source src="<?php echo $record['recording_url'] ?>" /></audio></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="2"><?php echo 'No Files Found.' ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

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
                leadMenu('files');
                jQuery('#loading').modal('hide');
            },
            error: function (jqXHR, textStatus, errorThrown){
                // Handle errors here
                jQuery('#loading').modal('hide');
                // STOP LOADING SPINNER
            }
        });
    }
    function fileDelete(fileId){
        jQuery('#loading').modal('show');
        jQuery.ajax({
            url : '<?php echo site_url("lead/filedelete") ?>'+'/'+fileId,
            method : 'post',
            dataType : 'json',
            success : function(result){
                jQuery('.message').html(result.html);
                leadMenu('files');
                jQuery('#loading').modal('hide');
            }
        });
    }
</script>