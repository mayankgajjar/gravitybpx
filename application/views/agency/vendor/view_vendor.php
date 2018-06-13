<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?php echo site_url(); ?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?php echo $label; ?></span>
        </li>
    </ul>
    <div class="page-toolbar">
    </div>
</div>
<h3 class="page-title"><?php echo $pagetitle; ?> </h3>
<div class="portlet light portlet-fit portlet-datatable bordered">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-user font-dark"></i>
            <span class="caption-subject font-dark sbold uppercase">
                <?php echo $vendor['fname'].' '.$vendor['lname'] ?>
            </span>
        </div>
    </div>
    <div class="portlet-body">
        <table class='table'>
                <tr>
                    <td style='width:40%'>
                        Agent Name
                    </td>
                    <td style='width:60%'>
                        <?php echo $vendor['agent_name'] ?>
                    </td>
                </tr>    
                <tr>
                    <td style='width:40%'>
                        First Name
                    </td>
                    <td style='width:60%'>
                        <?php echo $vendor['fname'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Middle Name
                    </td>
                    <td>
                        <?php echo $vendor['mname']?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Last Name
                    </td>
                    <td>
                        <?php echo $vendor['lname'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Email Address
                    </td>
                    <td>
                        <?php echo $vendor['email_id'] ?>
                    </td>
                </tr> 
                <tr>
                    <td style='width:40%'>
                        Phone Number
                    </td>
                    <td style='width:60%'>
                        <?php echo $vendor['phone_number'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Fax Number
                    </td>
                    <td>
                        <?php echo $vendor['fax_number'] ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Date of Birth
                    </td>
                    <td>
                        <?php echo $vendor['date_of_birth'] ?>
                    </td>
                </tr>
                <?php
                    if(empty($vendor['address_line_2']) || is_null($vendor['address_line_2']))
                    {
                        ?>
                        <tr>
                            <td rowspan='1'>
                                Address
                            </td>
                            <td>
                                <?php echo $vendor['address_line_1'] ?>
                                
                            </td>
                        </tr>
                        <?php
                    }
                    else
                    {
                        ?>
                        <tr>
                            <td rowspan='2'>
                                Address
                            </td>
                            <td>
                                <?php echo $vendor['address_line_1'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $vendor['address_line_2']; ?>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
                <tr>
                    <td>
                        Country
                    </td>
                    <td>
                        <?php echo $vendor['country_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        State
                    </td>
                    <td>
                        <?php echo $vendor['state_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        City
                    </td>
                    <td>
                        <?php echo $vendor['city_name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Zip Code
                    </td>
                    <td>
                        <?php echo $vendor['zip_code']; ?>
                    </td>
                </tr>          
        </table>     
    </div>
</div>

<script type="text/javascript">
$('document').ready(function(){  
        jQuery('#vendor').addClass('open');
        jQuery('.view_vendor').addClass('active');
        // jQuery('#vendor').addClass('active');
});        
</script>