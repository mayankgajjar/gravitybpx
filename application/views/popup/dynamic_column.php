
<form method="post" class="form-horizontal nipl-dynamic-column" action="" id="frmdynamiccolumn">
    <input type="hidden" name="dynamic_id" value="<?=isset($dynamic_col_data->dynamic_id)?encode_url($dynamic_col_data->dynamic_id):''?>"> 
    <input type="hidden" name="status" value="<?=$lead_status?>"> 
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Select the columns you want to see in this list</h4>
    </div>
    <div class="modal-body">
        <div class="search-bar">
            <div class="searchidiv">
                <input type="text" class="form-control" id="search-column" placeholder="Search For a column"/>
                <a href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="form-group form-group-md">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 col-sm-12 left-column-div">
                        <div class="left-list-view">
                            <span>Contacts</span>
                            <span class="badge"><i class="select-column">0</i> / <?=count($column_list)?></span>
                        </div>
                    </div> 
                    <div class="col-md-8 col-sm-12 right-column-div">
                        <div class="right-list-view">
                            <ul class="filter">
                                <?php 
                                $dyn_col = array();
                                if(isset($dynamic_col_data->display_column) && $dynamic_col_data->display_column != '') {
                                    $dyn_col=unserialize($dynamic_col_data->display_column);
                                    $dyn_col=array_keys($dyn_col); // Fetch Array key and make a new array
                                }else{
                                    $dyn_col=array('member_id', 'dispo', 'city', 'phone', 'status', 'last_local_call_time');
                                }
                               ?>
                                <?php foreach($column_list as $key=>$column) : ?>
                                    <li>
                                        <input type="checkbox" name="columns[<?=$key?>]" class="chk-column" value="<?=$column?>" <?php if(in_array($key,$dyn_col)) { echo "checked"; } ?> />
                                        <span><?=$column?></span>
                                    </li>
                                <?php endforeach; ?>    
                            </ul>
                        </div>
                    </div>   
                </div>    
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn blue store-column">Submit</button>
    </div>
</form> 

<script>
$(document).ready(function(){
    var count = $(".chk-column:checked").length;
    $(".select-column").html(count);
})

$(".chk-column").click(function(){
    var count = $(".chk-column:checked").length;
    $(".select-column").html(count);
})

$("#search-column").keyup(function(e){
    var rex = new RegExp($(this).val(), 'i');
    $('.filter li').hide();
    $('.filter li').filter(function () {
        return rex.test($(this).text());
    }).show();
});

$(".store-column").on("click", function (event) {
    event.preventDefault();
    $.post("<?=base_url('crm/store_dynamic_column')?>",$("#frmdynamiccolumn").serialize(),function(res){
        location.reload();
    });
});
</script>     
