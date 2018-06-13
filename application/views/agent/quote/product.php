<style>
    .row-logo > img {
    width: 100%;
}
</style>
<div class="breadcrumbs">
    <h1 class="page-title"><a href='<?php echo site_url('quote/index') ?>'><?php echo  'FRESNO, CA' ?>&nbsp;<span>(<?php echo 'edit' ?>)</span></a></h1>
<!--    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('agent') ?>"><?php echo 'Home' ?></a></li>
        <li class="active">
            <?php echo 'New Quote' ?>
        </li>
    </ol>        -->
</div>

<div class="page-content-container" style="min-height: 800px;">
    <div class="page-content-row">
        <div class="quote-sidebar page-sidebar">
            <nav role="navigation" class="navbar">
                <div class="filters">
                    <div class="filter-title"><?php echo 'Filter By' ?>:</div>
                    <h3>Product Type</h3>
                    <ul class="nav navbar-nav margin-bottom-35">
                        <li class="">
                            <a href="javascript:;">
                                <label>
                                <input type='checkbox' name="filter[]" />
                                <?php echo 'Medicare Advantage' ?>
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <label>
                                <input type='checkbox' name="filter[]" />
                                <?php echo 'Medicare RX(Part D)' ?>
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <label>
                                <input type='checkbox' name="filter[]" />
                                <?php echo 'Medicare Supplements' ?>
                                </label>
                            </a>
                        </li>
                    </ul>
                    <h3><?php echo 'Plan Type' ?></h3>
                    <ul class="nav navbar-nav" style="display: none;">
                        <li class="">
                            <a href="javascript:;">
                                <label>
                                <input type='checkbox' name="filter[]" />
                                <?php echo 'Medicare Advantage' ?>
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <label>
                                <input type='checkbox' name="filter[]" />
                                <?php echo 'Medicare RX(Part D)' ?>
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <label>
                                <input type='checkbox' name="filter[]" />
                                <?php echo 'Medicare Supplements' ?>
                                </label>
                            </a>
                        </li>
                    </ul>
                    <h3><?php echo 'Show Companies' ?></h3>
                    <ul class="nav navbar-nav" style="display: none;">
                        <li class="">
                            <a href="javascript:;">
                                <label><input type='checkbox' name="filter[]" />
                                <?php echo 'Medicare Advantage' ?>
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <label><input type='checkbox' name="filter[]" />
                                <?php echo 'Medicare RX(Part D)' ?></label>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                <label><input type='checkbox' name="filter[]" />
                                <?php echo 'Medicare Supplements' ?>
                                </label>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div><!-- .page-sidebar -->
        <div class="page-content-col">
            <div class="quote-product portlet light portlet-fit bordered">
                <div class='portlet-title'>
                    <div class="actions">
                        <div class="btn-group">
                            <a href='javascript:;'>
                                <i class="icon-envelope"></i>
                            </a>
                            <a href='javascript:;'>
                                <i class="icon-link"></i>
                            </a>
                            <a href='javascript:;'>
                                <i class="icon-printer"></i>
                            </a>
                            <a href='javascript:;'>
                                <i class="icon-reload"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <h3 class='row-title'><?php echo 'Humana Gold Plus HMO SNP-DE'; ?></h3>
                        <div class="col-md-12">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="row-logo">
                                    <img src='<?php echo site_url("assets/images/humana.png") ?>'/>
                                    <div class='row-logo-title'><?php echo 'Humana' ?></div>
                                </div>
                                <div class='row-max'>
                                    <span><?php echo 'Max Out Of Pocket' ?>:</span>
                                    <span>$6,700</span>
                                </div>
                                <div class="row-rating">
                                    <div class='rating-star'>
                                        <span><?php echo 'CMS Star Rating' ?>:</span>
                                        <span class="rating-star">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="attributes">
                                    <div class='attribute-row'>
                                        <span><?php echo 'Medical Deductible' ?>:</span>
                                        <span>$0.00</span>
                                    </div>
                                    <div class='attribute-row'>
                                        <span><?php echo 'Dr Visit Co-pay' ?>:</span>
                                        <span>$5.00</span>
                                    </div>
                                    <div class='attribute-row'>
                                        <span><?php echo 'Specialist Co-pay' ?>:</span>
                                        <span>$15.00</span>
                                    </div>
                                    <div class='attribute-row attribute-last'>
                                        <span><?php echo 'RX Co-pays' ?>:
                                            <span><?php echo 'Brand' ?>:</span>
                                            <span>$20.00</span>
                                            <span><?php echo 'Generic' ?>:</span>
                                            <span>$8.00</span>
                                        </span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 premimu-charge col-sm-12 col-xs-12">
                                <h3><?php echo 'Monthly Premium' ?></h3>
                                <div class="price-box">
                                    $ 24.10
                                </div>
                                <div class="buttons-group">
                                    <a href='javascript:;' class="btn green details"><?php echo 'Details' ?></a>
                                    <a href='javascript:;' class="btn green apply"><?php echo 'Apply' ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3 class='row-title'><?php echo 'AARP MedicareComplete SecureHorizons (HMO)'; ?></h3>
                        <div class="col-md-12">
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="row-logo">
                                    <img src='<?php echo site_url("assets/images/united.png") ?>'/>
                                    <div class='row-logo-title'><?php echo 'United Healthcare' ?></div>
                                </div>
                                <div class='row-max'>
                                    <span><?php echo 'Max Out Of Pocket' ?>:</span>
                                    <span>$6,700</span>
                                </div>
                                <div class="row-rating">
                                    <div class='rating-star'>
                                        <span><?php echo 'CMS Star Rating' ?>:</span>
                                        <span class="rating-star">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="attributes">
                                    <div class='attribute-row'>
                                        <spna><?php echo 'Medical Deductible' ?>:</spna>
                                        <span>$315.00</span>
                                    </div>
                                    <div class='attribute-row'>
                                        <spna><?php echo 'Dr Visit Co-pay' ?>:</spna>
                                        <span>$10.00</span>
                                    </div>
                                    <div class='attribute-row'>
                                        <spna><?php echo 'Specialist Co-pay' ?>:</spna>
                                        <span>$25.00</span>
                                    </div>
                                    <div class='attribute-row attribute-last'>
                                        <spna><?php echo 'RX Co-pays' ?>:
                                            <span><?php echo 'Brand' ?></span>
                                            <span>$17.00</span>
                                            <span><?php echo 'Generic' ?></span>
                                            <span>$3.00</span>
                                        </spna>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 premimu-charge col-sm-12 col-xs-12">
                                <h3><?php echo 'Monthly Premium' ?></h3>
                                <div class="price-box">
                                    $ 78.10
                                </div>
                                <div class="buttons-group">
                                    <a href='javascript:;' class="btn green details"><?php echo 'Details' ?></a>
                                    <a href='javascript:;' class="btn green apply"><?php echo 'Apply' ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .page-content-col -->
    </div>
</div>
<script type="text/javascript">
    jQuery('#quote').addClass('open');
    jQuery(document).on('click', '.filters h3', function(){
        jQuery('.quote-sidebar').find('.nav.navbar-nav').each(function(){
            if(jQuery(this).css('display') == 'block'){
                jQuery(this).slideUp();
            }
        });
        jQuery(this).next('ul').slideToggle();
    });
</script>