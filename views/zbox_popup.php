<div id="div_PopupMsgbox" class="zbox_text_container" style="display:none">
    <div class="zbox_msgbox_container">
        <div class="zbox_msgbox_title"></div>
        <div class="zbox_msgbox_message"></div>
    </div>
</div>

<div id="div_PopupPrize" class="zbox_text_container" style="display:none;">
    <div class="zbox_prize_container <?php echo (isset($this->spin_index) && $this->spin_index != '')?'prize_'.$this->spin_index:'';?>">
        <div class="zbox_prize_submission">
            <div class="zbox_prize_submission_detail">
                <b>Name:</b> <?php echo (isset($_SESSION['ss_Submission']['name']) && $_SESSION['ss_Submission']['name'] != '')?$_SESSION['ss_Submission']['name']:'';?><br />
                <b>Phone:</b> <?php echo (isset($_SESSION['ss_Submission']['phone']) && $_SESSION['ss_Submission']['phone'] != '')?$_SESSION['ss_Submission']['phone']:'';?><br />
                <b>IMEI:</b> <?php echo (isset($_SESSION['ss_Submission']['imei']) && $_SESSION['ss_Submission']['imei'] != '')?$_SESSION['ss_Submission']['imei']:'';?><br />
                <b>Location:</b> <?php echo (isset($_SESSION['ss_Submission']['area_id']) && $_SESSION['ss_Submission']['area_id'] != '')?$this->a_area['area_'.$_SESSION['ss_Submission']['area_id']]:'';?>
            </div>
        </div>
    </div>
    <div class="zbox_share_container">
        <div class="zbox_share_title">Share with your friends</div>
        <div class="zbox_share_buttons">
            <a href="javascript:void(0)" class="zbox_share_button facebook st-custom-button" data-network="facebook" data-url="https://www.vivocampaign.com/?utm_source=facebook&utm_medium=organic_social&utm_campaign=raya2021"></a>
            <a href="javascript:void(0)" class="zbox_share_button wechat st-custom-button" data-network="wechat" data-url="https://www.vivocampaign.com/?utm_source=wechatk&utm_medium=organic_social&utm_campaign=raya2021"></a>
        </div>
    </div>
</div>

<div id="div_PopupCampaignEnd" style="display:none;">
    <div id="div_ThankYou"></div>
</div>