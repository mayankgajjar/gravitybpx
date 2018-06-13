<div class="form-horizontal">
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-4 control-label"><?php echo 'Cell phone or Land line selection' ?></label>
            <div class="col-md-8">
                <select name="cell_phone_land_line" id="cell_phone_land_line" class="form-control">
                    <?php $options = unserialize(LEADSTORE_FILTER_PHONE_OPTIONS); ?>
                    <?php foreach($options as $key=>$option): ?>
                        <option value="<?php echo $option ?>"><?php echo $key ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>