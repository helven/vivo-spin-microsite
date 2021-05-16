<style>
    body {
        background: transparent url('<?php echo base_url();?>media/images/Index_Index/top.png') no-repeat center 0;
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
            background: transparent url('<?php echo base_url();?>media/images/Index_Index/prize.png') no-repeat center 0;
            height: 742px;
            margin-bottom: 72px;
        }
        
        #div_ThankYou {
            background: transparent url('<?php echo base_url();?>media/images/<?php echo $this->pageName;?>/thank_you.png') no-repeat center center;
            height: 462px;
            width: 654px;
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
            </div>
        </div>
    </div>
</div>
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
    
    
    jQuery(this).zboxOpen({
        text: jQuery('#div_PopupCampaignEnd').html(),//jQuery('<div>').append(jQuery('#div_PopupPrize').clone()).html(),
        callback: function(){
            jQuery('a.zbox_close').remove();
            jQuery('.zbox .main_slot').css('min-height', 'auto').css('min-width', 'auto')
        }
    });
});
jQuery(window).on('load', function(){
    
});
</script>