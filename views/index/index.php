<style>
    body.debug {
        background-image: url('<?php echo base_url();?>media/images/<?php echo $this->pageName;?>/ref.jpg');
        background-position: center 0;
        background-repeat: no-repeat;
    }
    body {
        background: transparent url('<?php echo base_url();?>media/images/<?php echo $this->pageName;?>/top.png') no-repeat center 0;
    }
    #div_Top {
        height: 829px;
    }
    #div_Mid {
        background: #1E489D;
        border-radius: 20px 20px 0 0;
        margin-top: 30px;
        padding-top: 72px;
        padding-bottom: 66px;
    }
        #div_Prize {
            background: transparent url('<?php echo base_url();?>media/images/<?php echo $this->pageName;?>/prize.png') no-repeat center 0;
            height: 742px;
            margin-bottom: 72px;
        }
        #div_EnterNow {
            color: #FFF;
            font-family: "Myriad Pro Bold";
            font-size: 36px;
            margin-bottom: 37px;
            text-align: center;
        }
        #frm_Form {
            margin: 0 auto;
            width: 700px;
        }
            #div_Name, #div_Phone, #div_IMEI {
                margin-bottom: 30px;
            }
            #div_Location {
                
            }
            #div_Location:before {
                background: repeat;
                background-image: url('<?php echo base_url();?>media/images/dropdown_arrow.png');
                content: "";
                height: 18px;
                margin-top: -9px;
                position: absolute;
                right: 20px;
                top: 50%;
                width: 32px;
            }
            #div_Location.expanded:before {
                -webkit-transform: rotate(30deg);
                -moz-transform: rotate(180deg);
                -ms-transform: rotate(180deg);
                -o-transform: rotate(180deg);
                transform: rotate(180deg);
            }
            #div_AgreeTnC {
                margin-top: 30px;
                margin-bottom: 34px;
            }
                #div_AgreeTnC .text a {
                    color: #FFF;
                    text-decoration: underline !important;
                }
            #btn_Redeem {
                background: #083E3F;
                border: none;
                border-radius: 50px;
                color: #FFF;
                display: block;
                font-size: 28px;
                font-family: "Myriad Pro Bold";
                height: 70px;
                line-height: 70px;
                margin: 0 auto;
                text-align: center;
                width: 332px;
            }
</style>
<?php if($this->config['environment'] == 'live'){ ?>

<?php } ?>
<div class="container">
    <div class="row">
        <div class="col-12 p-0">
            <div id="div_Top"></div>
            <div id="div_Mid">
                <div id="div_Prize"></div>
                <div id="div_EnterNow">Enter Now</div>
                <form id="frm_Form" class="form-horizontal" method="post">
                    <input type="hidden" id="hdd_Action" name="hdd_Action" value="submit" />
                    <input type="hidden" id="hdd_SessionID" name="hdd_SessionID" />
                    <input type="hidden" id="hdd_Location" name="hdd_Location" value="<?php echo set_value('hdd_Location');?>" />
                    <input type="hidden" id="hdd_AgreeTnC" name="hdd_AgreeTnC" value="0" />
                    
                    <input type="hidden" id="hdd_UTMSource" name="hdd_UTMSource" value="<?php echo $_GET['utm_source'];?>" />
                    <input type="hidden" id="hdd_UTMMedium" name="hdd_UTMMedium" value="<?php echo $_GET['utm_medium'];?>" />
                    <input type="hidden" id="hdd_UTMCampaign" name="hdd_UTMCampaign" value="<?php echo $_GET['utm_campaign'];?>" />
                    <input type="hidden" id="hdd_UTMContent" name="hdd_UTMContent" value="<?php echo $_GET['utm_content'];?>" />
                    
                    <div class="input_wrapper">
                        <div id="div_Name" class="input_textbox"><input type="textbox" id="txt_Name" name="txt_Name" placeholder="Your Name" value="<?php echo set_value('txt_Name');?>" /></div>
                        <span id="span_ErrorName" class="speech_bubble error">Please fill in your name.</span>
                    </div>
                    <div class="input_wrapper">
                        <div id="div_Phone" class="input_textbox"><input type="textbox" id="txt_Phone" name="txt_Phone" placeholder="Phone" value="<?php echo set_value('txt_Name');?>" /></div>
                        <span id="span_ErrorPhone" class="speech_bubble error">Please fill in your phone no.</span>
                    </div>
                    <div class="input_wrapper">
                        <div id="div_IMEI" class="input_textbox"><input type="textbox" id="txt_IMEI" name="txt_IMEI" placeholder="IMEI" value="<?php echo set_value('txt_IMEI');?>" /></div>
                        <span id="span_ErrorIMEI" class="speech_bubble error">Please fill in IMEI.</span>
                    </div>
                    
                    <div class="input_wrapper">
                        <?php $area_id = set_value('hdd_Location', '');?>
                        <?php $area = ($area_id != '')?$this->a_area['area_'.$area_id]:'Location';?>
                        <div id="div_Location" class="input_dropdown"><span class="text"><?php echo $area;?></span></div>
                        <div id="div_LocationList" class="input_dropdown_list">
                            <ul id="ul_LocationList" class="scrollbar-dynamic">
                                <?php foreach($this->a_area as $key => $value){ ?>
                                    <?php $key  = str_replace('area_', '', $key);?>
                                    <li><span data-key="<?php echo $key;?>"><?php echo $value;?></span></li>
                                <?php } ?>
                            </ul>
                        </div>
                        <span id="span_ErrorLocation" class="speech_bubble error">Please select your location.</span>
                    </div>
                    
                    <div class="input_wrapper">
                        <div id="div_AgreeTnC" class="input_checkbox">
                            <span class="checkbox"></span>
                            <span class="text">
                                <?php if(strtolower($this->geoCountryCode) == 'sg'){ ?>
                                    I agree to the <a id="a_IndexTnC" href="<?php echo base_url();?>media/vivo_campaign_tnc.pdf" target="_blank">Terms and Conditions</a> and <a id="a_IndexPrivacy" href="<?php echo base_url();?>media/vivo_privacy_policy.pdf" target="_blank">Privacy Policy</a>.
                                <?php }else{ ?>
                                    I agree to the <a id="a_IndexTnC" href="<?php echo base_url();?>media/vivo_campaign_tnc.pdf" target="_blank">Terms and Conditions</a> and <a id="a_IndexPrivacy" href="<?php echo base_url();?>media/vivo_privacy_policy.pdf" target="_blank">Privacy Policy</a>.
                                <?php } ?>
                            </span>
                        </div>
                        <span id="span_ErrorAgreeTnC" class="speech_bubble error">Please agree to Terms and Conditions &amp; Privacy Policy.</span>
                    </div>
                    <button id="btn_Redeem" type="button">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /*<div id="div_ToggleDebug" style="background:#FF0000;position:fixed;height:100px;width:100px;bottom:0;right:0;z-index:2147483647"></div>*/ ?>
<script>
var idleTime	= 0;
jQuery(document).ready(function(){
    // Increment the idle time counter every minute.
    var idleInterval = setInterval(function(){
        idleTime	= idleTime + 1;
        if (idleTime > 19) { // 20 minutes
            window.location.reload();
        }
    }, 60000); // 1 minute

    // Zero the idle timer on mouse movement.
    jQuery(this).mousemove(function (e) {
        idleTime = 0;
    });
    jQuery(this).keypress(function (e) {
        idleTime = 0;
    });
    
    
    <?php if($this->formError){ ?>
        msgbox('Opps!', '<?php echo $this->formErrorMsg;?>');
    <?php } ?>
        
    jQuery('#txt_Name').keyup(function(e){
        if(!is_empty(jQuery('#txt_Name').val()))
        {
            jQuery('#span_ErrorName').hide();
        }
    });

    jQuery('#txt_Phone').keyup(function(e){
        // remove +6 - [space] ( )
        phone   = jQuery('#txt_Phone').val();
        phone   = phone.replace('+6', '');
        phone   = phone.replace(' ', '');
        phone   = phone.replace('-', '');
        phone   = phone.replace('_', '');
        phone   = phone.replace('(', '');
        phone   = phone.replace(')', '');

        // remove + and 6
        if(phone.charAt(0) == 6 || phone.charAt(0) == '+')
        {
            phone = phone.substr(1);
        }

        jQuery('#txt_Phone').val(phone);

        if(!is_empty(jQuery('#txt_Phone').val()))
        {
            jQuery('#span_ErrorPhone').hide();
        }
    });

    jQuery('#txt_IMEI').keyup(function(e){
        if(!is_empty(jQuery('#txt_IMEI').val()))
        {
            jQuery('#span_ErrorIMEI').hide();
        }
    });

    jQuery('#txt_IMEI').keyup(function(e){
        if(!is_empty(jQuery('#txt_IMEI').val()))
        {
            jQuery('#span_ErrorIMEI').hide();
        }
    });

    jQuery('#div_Location').click(function(){
        jQuery(this).toggleClass('expanded');
        jQuery('#div_LocationList').fadeToggle(100);
    });
    jQuery('#ul_LocationList span').click(function(){
        jQuery(this).removeClass('expanded');
        jQuery('#div_LocationList').fadeToggle(100);
        
        jQuery('#hdd_Location').val(jQuery(this).data('key'));
        
        jQuery('#div_Location span.text').addClass('selected').text(jQuery(this).text());
        
        if(!is_empty(jQuery('#hdd_Location').val()))
        {
            jQuery('#span_ErrorLocation').hide();
        }
    });
	
    jQuery('.input_checkbox').click(function(e){
        jQuery(this).children('.checkbox').toggleClass('checked');
    });
    jQuery('.input_checkbox a').click(function(e){
        e.stopPropagation();
    })
    jQuery('#div_AgreeTnC').click(function(){
        jQuery('#hdd_AgreeTnC').val((jQuery('#hdd_AgreeTnC').val() == 0)?1:0);
        
        if(!is_empty(jQuery('#hdd_AgreeTnC').val()) && jQuery('#hdd_AgreeTnC').val() != 0)
        {
            jQuery('#span_ErrorAgreeTnC').hide();
        }
    });
    jQuery('#div_SubscribeNewsletter.input_checkbox .checkbox').click(function(){
        jQuery('#hdd_SubscribeNewsletter').val((jQuery('#hdd_SubscribeNewsletter').val() == 0)?1:0);
    });
    
    jQuery('.speech_bubble').click(function(){
        jQuery(this).hide();
    });
    
    /*jQuery('#a_IndexPrivacy').click(function(){
        jQuery(this).zboxOpen({
            text: jQuery('#div_PrivacyPolicyContent').html(),
            callback: zbox_callback
        });
    });
    jQuery('#a_IndexTnC').click(function(){
        jQuery(this).zboxOpen({
            text: jQuery('#div_TnCContent').html(),
            callback: zbox_callback
        });
    });*/
    
    jQuery('#btn_Redeem').click(function(){
        jQuery('#txt_Name').val(jQuery('#txt_Name').val().trim());
        jQuery('#txt_Phone').val(jQuery('#txt_Phone').val().trim());
        jQuery('#txt_IMEI').val(jQuery('#txt_IMEI').val().trim());
        
        formError	= false;
        if(is_empty(jQuery('#txt_Name').val()))
        {
            jQuery('#span_ErrorName').show();
            formError	= true;
        }
        if(is_empty(jQuery('#txt_Phone').val()))
        {
            jQuery('#span_ErrorPhone').text('Please fill in your mobile no.').show();
            formError	= true;
        }
        else if(!is_positive_int(jQuery('#txt_Phone').val()))
        {
            jQuery('#span_ErrorPhone').text('Please fill in a valid mobile no.').show();
            formError	= true;
        }
        if(is_empty(jQuery('#txt_IMEI').val()))
        {
            jQuery('#span_ErrorIMEI').show();
            formError	= true;
        }
        if(is_empty(jQuery('#hdd_Location').val()))
        {
            jQuery('#span_ErrorLocation').show();
            formError	= true;
        }
        if(is_empty(jQuery('#hdd_AgreeTnC').val()) || jQuery('#hdd_AgreeTnC').val() == 0)
        {
            jQuery('#span_ErrorAgreeTnC').show();
            formError	= true;
        }
        
        if(!formError)
        {
            jQuery('#frm_Form').submit();
            jQuery(this).prop('disabled', true);
            setTimeout(function(){
                jQuery('#btn_Redeem').prop('disabled', false);
            }, 3000);
            
            jQuery('#div_PageLoader').show();
        }
    });
});
jQuery(window).on('load', function(){
    
});
</script>