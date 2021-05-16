<?php echo '<?xml version="1.0" encoding="UTF-8"?>';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="keywords" content="Vivo ,  Hati rapat raya berkat, spin & win, vivo campaign"/>
        <meta http-equiv="description" content="<?php echo $this->config['og_desc'];?>"/>
        
        <meta property="fb:admins" content="0"/>
        <meta property="og:title" content="<?php echo $this->config['og_title'];?>" />
        <meta property="og:description" content="<?php echo $this->config['og_desc'];?>" />
        <meta property="og:url" content="<?php echo base_url();?>" />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="<?php echo base_url();?>/media/images/og_image.jpg" />
        <meta property="og:site_name" content="vivocampaign.com">
        
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
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-196214715-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-196214715-1');
            //ga('create', 'UA-196214715-1', 'auto');
        </script>
        <!-- Google Analytics -->
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-196214715-1', 'auto');
        </script>
        <!-- End Google Analytics -->
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

            function init_sharethis()
            {
                jQuery('#script_ShareThis').remove();
                st  = document.createElement('script');
                st.src  = 'https://platform-api.sharethis.com/js/sharethis.js#property=6079d7e7c70c71001196ace4&product=custom-share-buttons';
                st.id   = 'script_ShareThis';
                st.async= 'async';
                document.head.appendChild(st);
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
        <?php require_once('zbox_popup'.EXT);?>
        <div id="div_PageLoader"><img src="<?php echo base_url();?>media/images/page_loader.svg" /></div>
        <div class="scroll_wrapper scrollbar-macosx">
            <div id="div_Page-<?php echo $this->pageName;?>" class="site_container">
                <?php echo $this->pageContent;?>
            </div>
            <footer>
                <div class="footer_container">
                    <div class="footer_left">
                        <div>
                            <a id="a_Privacy" href="<?php echo base_url();?>media/vivo_privacy_policy.pdf" target="_blank">Privacy Policy</a>
                            | <a id="a_TnC" href="<?php echo base_url();?>media/vivo_campaign_tnc.pdf" target="_blank">Terms of Use</a>
                        </div>
                        <div di="div_Copyright">
                            Copyright 2021 &copy; VIVO Malaysia. All Rights Reserved.
                        </div>
                    </div>
                    <div class="footer_right">
                        <a id="a_SocialFacebook" href="https://www.facebook.com/vivoMalaysia" target="_blank" class="footer_social_button"></a>
                        <a id="a_SocialTwitter" href="https://twitter.com/vivo_Malaysia" target="_blank" class="footer_social_button"></a>
                        <a id="a_SocialYoutube" href="https://www.youtube.com/channel/UCLaKL3B4OYKBO1LHIiSWd5w" target="_blank" class="footer_social_button"></a>
                        <a id="a_SocialInstagram" href="https://www.instagram.com/vivo_Malaysia/" target="_blank" class="footer_social_button"></a>
                        <a id="a_SocialWebsite" href="https://www.vivo.com/my" target="_blank" class="footer_social_button"></a>
                    </div>
                </div>
            </footer>
        </div>
        <script type="text/javascript" src="<?php echo base_url();?>media/js/zbox/js/jQuery.zbox.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>media/js/scrollbar/jquery.scrollbar.min.js"></script>
        <script><!--
        jQuery(document).ready(function(){
            jQuery('#ul_LocationList').scrollbar({});
            resize();
            
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
            <?php if(isset($_SESSION['ss_Msgbox']) && $_SESSION['ss_Msgbox'] != ''){ ?>
                msgbox('<?php echo $_SESSION['ss_Msgbox']['title'];?>', '<?php echo $_SESSION['ss_Msgbox']['message'];?>');

                <?php unset($_SESSION['ss_Msgbox']);?>
            <?php } ?>
        });
        jQuery(window).resize(function(){
            resize();
        });
        jQuery(window).on('load', function(){
            jQuery('body').removeClass('page_fadeout');
        });
        jQuery(window).on('unload', function(){
            jQuery('body').addClass('page_fadeout');
        });
        
        function resize()
        {
            if((jQuery('.site_container').height() * <?php echo $this->zoom;?>) < jQuery(window).height())
            {
                jQuery('html').addClass('float_bottom_footer');
            }
            else
            {
                jQuery('html').removeClass('float_bottom_footer');
            }
        }

        function msgbox(title, message)
        {
            jQuery('#div_PopupMsgbox .zbox_msgbox_title').html(title);
            jQuery('#div_PopupMsgbox .zbox_msgbox_message').html(message);
            jQuery(this).zboxOpen({
                text: jQuery('#div_PopupMsgbox').html(),
                callback: zbox_callback
            });
        }
        
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