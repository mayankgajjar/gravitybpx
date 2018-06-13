
<div class="quote">
    <div class="breadcrumbs">
    <h1 class="page-title"> <?php echo $pagetitle ?> </h1>     
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo 'New Quote' ?>
        </li>
    </ol>        
</div>
    <div class="row" class="quote-form">
        <div class="col-md-12">
            <form class="form-horizontal" method="post">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-2"><?php echo 'Zip Code' ?>:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="zipcode" id="zipcode"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2"><?php echo 'Birth Date' ?>:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="birthday" id="birthday" placeholder="mm/dd/yyyy"/>
                        </div>
                    </div>                
                </div>
            </form>
        </div>    
    </div>

    <ul class="row quote-boxes">
        <li>
            <div class="quote-box" onclick="javascript:displayPop()">
                <img class="image" src="<?php echo site_url() ?>assets/images/mediacare.png" />
                    <div class="middle">
                        <div class="text">Medicare</div>
                    </div>
            </div>
        </li>
        <li>
            <div class="quote-box" onclick="javascript:displayPop()">
                <img class="image" src="<?php echo site_url() ?>assets/images/health.png" />
                <div class="middle">
                    <div class="text">Health</div>
                </div>
                
            </div>
        </li>
        <li>
            <div class="quote-box" onclick="javascript:displayPop()">
                <img class="image" src="<?php echo site_url() ?>assets/images/dental&vision.png" />
                    <div class="middle">
                        <div class="text">Dental & Vision</div>
                    </div>
                
            </div>
        </li>
        <li>
            <div class="quote-box" onclick="javascript:displayPop()">
                <img class="image" src="<?php echo site_url() ?>assets/images/life.png" />
                    <div class="middle">
                        <div class="text">Life</div>
                    </div>                
            </div>
        </li>    
    </ul>
    
    <div class="escope" style="display: none;">
        <h4>eScope</h4>
        <p>Would you like to set an eScope for this transaction?</p>
        <div class="buttonss">
            <a class="yes" href="<?php echo site_url('quote/product') ?>">Yes</a>
            <a class="not-now" href="<?php echo site_url('quote/product') ?>">Not Now</a>
        </div>
    </div>
    <script type="text/javascript">
    function displayPop(){
        jQuery('.escope').fadeToggle();
    }
    </script>
</div>