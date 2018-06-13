<style>
    .age-section{margin-bottom: 10px;}
</style>
<div class="lead-row">
    <div class="row age-section">
        <div class="col-sm-12">
            <label class="col-sm-4 control-label">Consumer Age Minimum (Years)</label>
            <div class="col-sm-8">
                <select class="form-control" name="min_age">
                    <option selected><?php echo 'None' ?></option>
                    <?php  for ($x = 21; $x <= 80; $x++) { ?>
                        <option value=<?php echo $x; ?>><?php echo $x; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row age-section">
        <div class="col-sm-12">
            <label class="col-sm-4 control-label">Consumer Age Maximum (Years)</label>
            <div class="col-sm-8">
                <select class="form-control" name="max_age">
                    <option selected><?php echo 'None' ?></option>
                   <?php  for ($x = 80; $x >= 40; $x--) { ?>
                        <option value=<?php echo $x; ?>><?php echo $x; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</div>
