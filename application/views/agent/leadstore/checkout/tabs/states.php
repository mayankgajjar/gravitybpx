<style>
    .action-box{
        margin-top: 20px;
        margin-bottom: 20px;
    }
</style>
<div class="lead-row">
    <div class="row">
        <?php $i = 0;
            if(count($state_result) > 0){
            foreach($state_result as $key=>$state){
        ?>
        <?php if(($i++ % 17) == 0) : ?>
            <div class="col-sm-4">
        <?php endif; ?>   
            <div class="row">
                <div class="col-sm-12"> 
                    <div class="checkbox-inline">
                        <label>
                        <input checked type="checkbox" class="select-state" name="state_code[]" value="<?php echo $state['abbreviation']; ?>">
                        <span><?php echo $state['name']; ?></span>
                        </label>
                    </div>
                </div> 
            </div>   
        <?php if(($i%17) == 0 || $i == count($state_result)) : ?>        
            </div>
        <?php endif;?>    
        <?php } } ?>
    </div>

    <div class="row action-box">
        <div class="row">
            <div class="col-sm-4"><button type="button" class="btn" id="chk_all" onclick="checkStates('y')">Select All States</button></div>
            <div class="col-sm-4"><button type="button" class="btn" id="unchk_all" onclick="checkStates('n')">Unselect All States</button></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(document).on('click', '#chk_all', function () {
            $('.select-state').prop('checked', true);
        });

        $(document).on('click', '#unchk_all', function () {
            $('.select-state').prop('checked', false);
        });
    });
function checkStates(action){
    if(action == 'y'){
        jQuery('.select-state').prop('checked', true);
    }else{
        jQuery('.select-state').prop('checked', false);
    }
}
</script>