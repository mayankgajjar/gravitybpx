 <style>
    #filter_by_zip_codes {resize: none;}
</style>
<div class="form-horizontal">
    <div class="form-body">
        <div class="form-group">
            <div class="col-md-6">
                <div class="radio-inline">
                    <label for="filter_by_zip_code"><input type="radio" name="filter_by_zip_code" value="YES" onclick="enableField('y')"/>  Filter by zip code (<strong>include</strong> list of zip codes)</label>
                </div>
                <div class="radio-inline" style="margin-left: 0px;">
                    <label for="filter_by_zip_code"> <input type="radio" name="filter_by_zip_code" value="NO" checked="" onclick="enableField('n')" />  Don't filter by zip code</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label>Comma separated list of zip codes (e.g. 90210, 12345):</label>
                <textarea disabled="" name="filter_by_zip_codes" cols="98" rows="4" id="filter_by_zip_codes"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3">
                <label class="bold">State</label>
                <select disabled class="form-control" name="zip_code_state" id="zip_code_state" onchange="getCounty(this.value)">
                    <option value=""><?php echo 'Please Select' ?></option>
                    <?php foreach($state_result as $state): ?>
                    <option value="<?php echo $state['abbreviation'] ?>"><?php echo $state['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                    <label class="bold"><?php echo 'County' ?></label>
                    <select disabled class="form-control" name="zip_code_county" id="zip_code_county" onchange="getCity(this.value)">

                    </select>
            </div>
            <div class="col-md-3">
                    <label class="bold"><?php echo 'City' ?></label>
                    <select  disabled class="form-control" name="zip_code_city" id="zip_code_city">

                    </select>
            </div>
            <div class="col-md-3">
                <label class="bold">&nbsp;</label><br />
                <button type="button" id="getzipf" class="btn green disabled" onclick="getZip()"><?php echo 'Get Zip Codes' ?></button>
            </div>
        </div>
        <div class="form-group">
            <div class="text-center bold" style="color: red;"><?php echo 'OR' ?></div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label class="col-md-2 control-label"><?php echo 'Zipcodes within' ?></label>
                <input disabled type="text" name="filter_by_radius" class="col-md-4 form-control" placeholder="Radius here" id="filter_by_radius" style="width: 30%;" />
                <label class="col-md-2 control-label" style="text-slign: left;width: 10%;"><?php echo 'miles of' ?></label>
                <input disabled type="text" name="filter_by_search_zip" class="col-md-4 form-control" placeholder="Zip Code here" id="filter_by_search_zip" style="width: 17%;"/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="getzips" class="btn green disabled" onclick="getZipS()"><?php echo 'Get Zip Codes' ?></button>
            </div>
        </div>
        <div class="form-group">
            <div class="text-center bold" style="color: red;"><?php echo 'OR' ?></div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <label class="col-md-5 control-label"><?php echo 'Enter SCF code (1st 3 digits of zip code)' ?></label>
                <input name="filter_by_scf" placeholder="SCF" class="col-md-4 form-control" id="filter_by_scf" type="text" disabled="" style="width: 10%;" />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button  type="button" id="getzipt" class="btn green disabled" onclick="getZipT()"><?php echo 'Get Zip Codes' ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function getCounty(state_id){
        if(state_id.length > 0){
            jQuery.ajax({
                url : '<?php echo site_url('storecheckout/getCounty') ?>',
                method : 'post',
                datType : 'json',
                data : {is_ajax: true,state: state_id},
                success : function(result){
                    //console.log(result);
                    var html = '<option>Please Select</option>';
                    jQuery.each(result, function(index, value){
                        if(value.name != 'null'){
                            html += '<option value="'+value['name']+'">'+value['name']+'</option>'
                        }
                    });
                    jQuery('[name="zip_code_county"]').html(html);
                }
            });
        }
    }

    function getCity(county){
        var state_id = jQuery('[name="zip_code_state"]').val();
        if(county.length > 0){
            jQuery.ajax({
                url : '<?php echo site_url('storecheckout/getCity') ?>',
                method : 'post',
                datType : 'json',
                data : {is_ajax: true,state: state_id, county : county},
                success : function(result){
                    //console.log(result);
                    var html = '<option>Please Select</option>';
                    jQuery.each(result, function(index, value){
                        if(value.name != 'null'){
                            html += '<option value="'+value['name']+'">'+value['name']+'</option>'
                        }
                    });
                    jQuery('[name="zip_code_city"]').html(html);
                }
            });
        }
    }

    function getZip(){
        var state_id = jQuery('[name="zip_code_state"]').val();
        var county = jQuery('[name="zip_code_county"]').val();
        var city_name = jQuery('[name="zip_code_city"]').val();
        if(city_name.length > 0){
            jQuery.ajax({
                url : '<?php echo site_url('storecheckout/getZip') ?>',
                method : 'post',
                datType : 'json',
                data : {is_ajax: true,state: state_id, county : county, city : city_name},
                success : function(result){
                    var str = jQuery('#filter_by_zip_codes').val();
                    jQuery('#filter_by_zip_codes').val(str+result.zip+',');
                }
            });
        }
    }

    function getZipS(){
        var zip = jQuery('[name="filter_by_search_zip"]').val();
        var mile = jQuery('[name="filter_by_radius"]').val();
        if(zip.length > 0){
            jQuery.ajax({
                url : '<?php echo site_url('storecheckout/getZipByRadius') ?>',
                method : 'post',
                datType : 'json',
                data : {is_ajax: true,zipcode: zip, miles : mile},
                success : function(result){
                    var str = jQuery('#filter_by_zip_codes').val();
                    jQuery('#filter_by_zip_codes').val(str+result.zip+',');
                }
            });
        }

    }
    function getZipT(){
        var filter_by_scf = jQuery('[name="filter_by_scf"]').val();
        if(filter_by_scf.length > 0){
            jQuery.ajax({
                url : '<?php echo site_url('storecheckout/getZipByScf') ?>',
                method : 'post',
                datType : 'json',
                data : {is_ajax: true,scf: filter_by_scf},
                success : function(result){
                    var str = jQuery('#filter_by_zip_codes').val();
                    jQuery('#filter_by_zip_codes').val(str+result.zip+',');
                }
            });
        }
    }

    function enableField(action){
        if(action == 'y'){
            jQuery('#zip_code_city').attr('disabled',false);
            jQuery('#zip_code_county').attr('disabled',false);
            jQuery('#zip_code_state').attr('disabled',false);
            jQuery('#filter_by_zip_codes').attr('disabled',false);
            jQuery('#getzipf').removeClass('disabled');
            jQuery('#getzips').removeClass('disabled');
            jQuery('#getzipt').removeClass('disabled');
            jQuery('#filter_by_radius').attr('disabled',false);
            jQuery('#filter_by_search_zip').attr('disabled',false);
            jQuery('#filter_by_scf').attr('disabled',false);
        }else{
            jQuery('#filter_by_zip_codes').val('');
            jQuery('#zip_code_city').attr('disabled',true);
            jQuery('#zip_code_county').attr('disabled',true);
            jQuery('#zip_code_state').attr('disabled',true);
            jQuery('#filter_by_zip_codes').attr('disabled',true);
            jQuery('#getzipf').addClass('disabled')
            jQuery('#getzips').addClass('disabled');
            jQuery('#getzipt').addClass('disabled');
            jQuery('#filter_by_radius').attr('disabled',true);
            jQuery('#filter_by_search_zip').attr('disabled',true);
            jQuery('#filter_by_scf').attr('disabled',true);
            jQuery('#filter_by_zip_codes').val('');
        }
    }
</script>