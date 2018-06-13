var EcommerceProducts = function () {

    var initPickers = function () {
        //init date pickers
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
    }    
    var handleProducts = function() {
        var grid = new Datatable();        
        
        /*$('table#datatable_products thead tr th').click(function()
        {
            order_by = $(this).attr('data-order');            
        });
        alert(order_by);*/
        grid.init({
            src: $("#datatable_products"),
            onSuccess: function (grid) {                
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            loadingMessage: 'Loading...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

                "lengthMenu": [
                    [10, 20, 50, 100, 150],
                    [10, 20, 50, 100, 150] // change per page values here 
                ],                
                "pageLength": 10, // default record count per page
                "processing": true,
                "ajax": {
                    "url": "products/prodcut_pagination", // ajax source
                },
                "aoColumnDefs": [
                      { "sName": "id", "aTargets": [ 1 ] },
                      { "sName": "category.category_name", "aTargets": [ 2 ] },
                      { "sName": "products.product_name", "aTargets": [ 3 ] },
                      { "sName": "company.company_name", "aTargets": [ 4 ] },
                      { "sName": "products.product_levels", "aTargets": [ 5 ] },
                      { "sName": "products.product_price", "aTargets": [ 6 ] },
                      { "sName": "products.age_from", "aTargets": [ 7 ] },
                      { "sName": "products.is_active", "aTargets": [ 8 ] }                     
                ],               
                "order": [
                    [1, "asc"]
                ],
                 // set first column as a default sort by asc
            }
        });

         // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) 
        {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "") 
            {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", action.val());
                //grid.setAjaxParam("id", grid.getSelectedRows());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } 
            else if (action.val() == "") 
            {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
            /*else if (grid.getSelectedRowsCount() === 0) 
            {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }*/
        });
    }

    return {

        //main function to initiate the module
        init: function () {

            handleProducts();
            initPickers();
            
        }

    };

}();

jQuery(document).ready(function() {    
   EcommerceProducts.init();
});