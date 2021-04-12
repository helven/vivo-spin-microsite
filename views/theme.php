<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="keywords" content="Baskin Robbins"/>
        <meta http-equiv="description" content="Baskin-Robbins ice cream.  Home of delicious cones, shakes, treats, cakes, pies, and more!"/>
        
        <meta property="fb:admins" content="0"/>
        <meta property="og:title" content="<?php echo $this->config['og_title'];?>" />
        <meta property="og:description" content="<?php echo $this->config['og_desc'];?>" />
        <meta property="og:url" content="https://www.baskinrobbins.com.my/welcometobrday/" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="https://www.baskinrobbins.com.my/welcometobrday/media/images/og_image.jpg" />
        <meta property="og:site_name" content="baskinrobbins.com">
        
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
            <footer>
                <div class="footer_container">
                    <div class="footer_left">
                        <div>
                            <a id="a_Privacy" href="http://www.baskinrobbins.com.sg/content/baskinrobbins/en/privacypolicy.html" target="_blank">Privacy Policy</a>
                            | <a id="a_TnC" href="<?php echo base_url();?>tnc/" target="_blank">Terms of Use</a>
                        </div>
                        <div di="div_Copyright">
                            Copyright 2021 &copy; VIVO Malaysia. All Rights Reserved.
                        </div>
                    </div>
                    <div class="footer_right">
                        <a id="a_SocialFacebook" href="" target="_blank" class="footer_social_button"></a>
                        <a id="a_SocialWeChat" href="" target="_blank" class="footer_social_button"></a>
                        <a id="a_SocialTwitter" href="" target="_blank" class="footer_social_button"></a>
                        <a id="a_SocialYoutube" href="" target="_blank" class="footer_social_button"></a>
                        <a id="a_SocialInstagram" href="" target="_blank" class="footer_social_button"></a>
                        <a id="a_SocialWebsite" href="" target="_blank" class="footer_social_button"></a>
                    </div>
                </div>
            </footer>
        </div>
        <script type="text/javascript" src="<?php echo base_url();?>media/js/zbox/js/jQuery.zbox.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>media/js/scrollbar/jquery.scrollbar.min.js"></script>
        <script><!--
        jQuery(document).ready(function(){
            jQuery('#ul_LocationList').scrollbar({});
            jQuery(window).resize(function(){
                resize();
            });
            resize();
            function resize()
            {
                if((jQuery('.site_container').height() * <?php echo $this->zoom;?>) < jQuery(window).height())
                {
                    jQuery('html').addClass('float_bottom_footer');
                }
            }
            
            /*jQuery('#a_Privacy').click(function(){
                jQuery(this).zboxOpen({
                    text: jQuery('#div_PrivacyPolicyContent').html(),
                    callback: zbox_callback
                });
            });
            jQuery('#a_TnC').click(function(){
                jQuery(this).zboxOpen({
                    text: jQuery('#div_TnCContent').html(),
                    callback: zbox_callback
                });
            });*/
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