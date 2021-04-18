<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="keywords" content=""/>
        <meta http-equiv="description" content=""/>
        
        <meta property="fb:admins" content="0"/>
        <meta property="og:title" content="<?php echo $this->config['og_title'];?>" />
        <meta property="og:description" content="<?php echo $this->config['og_desc'];?>" />
        <meta property="og:url" content="" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="" />
        <meta property="og:site_name" content="">
        
        <link rel="shortcut icon" type="image/ico" href="<?php echo base_url();?>media/images/favicon.ico">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="<?php echo ($this->o_MobileDetect->isMobile())?'width=1310, user-scalable=no':'width=device-width, initial-scale=1, user-scalable=no';?>">
        
        <title><?php echo $this->config['title'];?></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-style-type" content="text/css" />
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>media/js/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>media/css/general.css" type="text/css" media="screen, projection" />
        <link rel="stylesheet" href="<?php echo base_url();?>media/css/default.css" type="text/css" media="screen, projection" />
        <link rel="stylesheet" href="<?php echo base_url();?>media/js/scrollbar/jquery.scrollbar.css" type="text/css" media="screen, projection" />
        <link rel="stylesheet" href="<?php echo base_url();?>media/js/zbox/css/jQuery.zbox.css" type="text/css" media="screen, projection" />
        <link rel="stylesheet" href="<?php echo base_url();?>media/css/<?php echo $this->platform;?>.css" type="text/css" media="screen, projection" />
        <!--[if IE]>
        <style type="text/css">
            .clearfix {
                zoom: 1; /* triggers hasLayout */
            }
        </style>
        <![endif]-->
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="<?php echo base_url();?>media/js/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>media/js/generic.js"></script>
        <script src="<?php echo base_url();?>media/js/validate.js"></script>
        <script><!--
            jQuery = jQuery.noConflict();
            var addthis_config = {
                data_track_clickback: false
            }
            global = {
                fontSize        : 12,
                animFast        : 0.15,
                animNorm        : 0.2,
                animSlow        : 0.4,
                anim500         : 0.5,
                //headerSize    : jQuery('#div_Header').height(),
                loader          : '<img src="<?php echo base_url();?>media/images/loader/loader-24.gif" alt="loading..." style="vertical-align: middle;" />',
                baseUrl         : '<?php echo base_url();?>',
                platformUrl     : '',
                mediaUrl        : '<?php echo base_url();?>media/',
                language        : {
                    reload_page : 'Reload Page',
                }
            };
        //-->
        </script>
        <style>
        .zbox .main_slot .body {
            max-height: <?php echo 100 / $this->zoom * 0.8;?>vh;
        }
        </style>
    </head>
    <body id="body_<?php echo ucfirst($this->platform);?>" class="page_fadein page_fadeout">
        <div id="div_PageLoader"><img src="<?php echo base_url();?>media/images/page_loader.svg" /></div>
        <div class="scroll_wrapper scrollbar-macosx">
            <div id="div_Page-<?php echo $this->pageName;?>" class="site_container">
                <?php echo $this->pageContent;?>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo base_url();?>media/js/zbox/js/jQuery.zbox.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>media/js/scrollbar/jquery.scrollbar.min.js"></script>
        <script><!--
        jQuery(document).ready(function(){
            
        });
        jQuery(window).on('load', function(){
            jQuery('body').removeClass('page_fadeout');
        });
        jQuery(window).on('unload', function(){
            jQuery('body').addClass('page_fadeout');
        });
        
        function zbox_callback()
        {
            jQuery('.zbox .main_slot .body').addClass('scrollbar-dynamic');
            
            <?php //if($this->platform != 'desktop'){ ?>
                if(jQuery('.zbox .body').height() >= jQuery(window).height() * <?php echo $this->zoom * 0.8;?> || <?php echo (($this->platform != 'desktop')?'true':'false');?>)
                {
                    jQuery('.zbox .main_slot').css({'top': '50%'});
                }
            <?php //}?>
            jQuery('.zbox .main_slot .body').scrollbar({});
        }
        //-->
        </script>
        <?php if($this->platform == 'desktop'){ ?>
            <style>
            html {zoom: <?php echo $this->zoom;?>;}
            <?php if($this->customScrollBar){ ?>
                .scroll_wrapper {max-height: <?php echo 100 / $this->zoom;?>vh;max-width: <?php echo 100 / $this->zoom;?>vw;}
                body {overflow:hidden;}
            <?php }?>
            </style>
            <script><!--
            <?php if($this->customScrollBar){ ?>
                jQuery(document).ready(function(){
                    jQuery('.scroll_wrapper').scrollbar({
                        "onScroll": function(y, x){}
                    });
                });
            <?php }?>
            //-->
            </script>
        <?php } ?>
    </body>
</html>