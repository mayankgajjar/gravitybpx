<style>
    .show-area-code{margin-bottom: 10px; margin-top: 15px;}
    .action-box{margin-top: 20px;margin-bottom: 20px;}
    .action-box-2{margin-top: 20px;margin-bottom: 20px;}
    #area_codes {resize: none;}
</style>
<div class="lead-row">
    <div class="area-code-filter">
    <div class="row">
        <div class="col-sm-6">
            <div class="col-sm-1"><input type="radio" id="filter" name="filter_by_area_code" value="none" checked="checked"></div>
            <div class="col-sm-10">Don't filter by area code.</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="col-sm-1"><input type="radio" id="filter" name="filter_by_area_code" value="filter_area_include"></div>
            <div class="col-sm-10">Filter by area code (include list of area codes).</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="col-sm-1"><input type="radio" id="filter" name="filter_by_area_code" value="filter_area_exclude"></div>
            <div class="col-sm-10">Filter by area code (exclude list of area codes).</div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-sm-12 m_20">
           <label for="area_code">Comma separated list of area codes (e.g. 949, 310, 212):</label>
           <textarea class="form-control" name="filter_by_area_codes" rows="5" id="area_codes" disabled></textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 m_20">
           <label for="state">State</label>
            <select class="form-control" name="state_list" id="state_list" disabled>
                    <?php
                        if(count($state_result) > 0){
                        foreach($state_result as $state){
                    ?>
                        <option value=<?php echo $state['abbreviation']; ?>><?php echo $state['name']; ?></option>
                    <?php } } ?>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <button type="button" class="btn show-area-code" id="show_area_codes" name="show_area_codes" disabled>Show Area Codes</button>
        </div>
    </div>

    <div class='row'>
        <div id = "area_code"> </div>
    </div>

    <div class="row action-box" style="display: none;">
        <div class="col-sm-8 ">
            <div class="col-sm-6"><button type="button" class="btn" id="chk_all">Select All States</button></div>
            <div class="col-sm-6"><button type="button" class="btn" id="unchk_all">Unselect All States</button></div>
        </div>
    </div>

    <div class="row action-box-2" style="display: none;">
        <div class="col-sm-4">
            <button type="button" class="btn" id="add_selected_area_codes" name="add_selected_area_codes">Add Selected Area Codes</button>
        </div>
    </div>

</div>


<script>
    $(document).ready(function () {

        $(document).on('click', '#chk_all', function () {
            $('.state-chk').prop('checked', true);
        });

        $(document).on('click', '#unchk_all', function () {
            $('.state-chk').prop('checked', false);
        });


        $(document).on('click', '#filter', function () {
            var filterby = $(this).val();
            if (filterby == "none") {
                $("#area_codes").attr('disabled','disabled');
                $("#state_list").attr('disabled','disabled');
                $("#show_area_codes").attr('disabled','disabled');
                $("#area_code").hide();
                $(".action-box").hide();
                $(".action-box-2").hide();
                $('#area_codes').val("");
            } else {
                $('#area_codes').prop("disabled", false);
                $('#state_list').prop("disabled", false);
                $('#show_area_codes').prop("disabled", false);
            }
        });

        $(document).on('click', '#show_area_codes', function () {
            var StateName = $('#state_list').val();
             $.ajax({
                    url : '<?php echo site_url('storecheckout/getAreaCode') ?>',
                    method : 'post',
                    data : {state : StateName},
                    success: function (data) {
                        $('#area_code').html(data);
                        $('#area_code').show();
                        $('.action-box').show();
                        $('.action-box-2').show();
                    },
                });
        });

        $(document).on('click', '#add_selected_area_codes', function () {
            var code_arr = [];
            $( ".state-chk:checked" ).each(function() {
                code_arr.push($(this).val());
            });
            $("#area_codes").val(code_arr.toString());
        });
    });

</script>
