<style>
    body {
        background: transparent url('<?php echo base_url();?>media/images/<?php echo $this->pageName;?>/top.png') no-repeat center 0;
    }
    body.debug {
        background-image: url('<?php echo base_url();?>media/images/<?php echo $this->pageName;?>/ref.jpg');
        background-position: center 0;
        background-repeat: no-repeat;
    }
    #div_SpinAndWin {
        background: transparent url('<?php echo base_url();?>media/images/<?php echo $this->pageName;?>/spin_and_win.png') no-repeat center 0;
        height: 140px;
        left: -537px;
        margin-left: 50%;
        position:absolute;
        top: 292px;
        width: 1074px;
    }
    #div_Mid {
        margin-top: 528px;
        padding-bottom: 66px;
        position: relative;
    }
    #div_Ketupat {
        background: transparent url('<?php echo base_url();?>media/images/<?php echo $this->pageName;?>/ketupat.png') no-repeat center 0;
        height: 265px;
        left: -68px;
        margin-left: 50%;
        position: absolute;
        top: -140px;
        width: 151px;
    }
    #div_Wheel,
    #canvas_Wheel {
        display: block;
        height: 840px;
        margin: 0 auto;
        width: 840px;
    }
    #div_Wheel {
        background: transparent url('<?php echo base_url();?>media/images/<?php echo $this->pageName;?>/wheel.png') no-repeat center 0;
    }
    #btn_Spin {
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
        margin-top: 50px;
        text-align: center;
        width: 332px;
    }
    .zbox_prize_container {
        background: transparent url('<?php echo base_url();?>media/images/<?php echo $this->pageName;?>/prize-<?php echo $this->spin_index;?>.jpg') no-repeat center 0;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-12 p-0">
            <div id="div_SpinAndWin"></div>
            <div id="div_Mid">
                <div id="div_Ketupat"></div>
                <?php //if(isset($this->a_submission['spin_status']) && $this->a_submission['spin_status'] == 0){ ?>
                    <canvas id='canvas_Wheel' width="840" height="840">
                        Canvas not supported, use another browser.
                    </canvas>
                <?php /*}else{ ?>
                    <div id="div_Wheel"></div>
                <?php }*/ ?>
                <button id="btn_Spin" type="button">SPIN</button>
            </div>
        </div>
    </div>
</div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : 'your-app-id',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v10.0'
    });
  };
</script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script src="<?php echo base_url();?>media/js/Winwheel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
<script>
var idleTime	= 0;
var is_spinning   = false;
var total_prize     = 6;
var prize_angle     = 360 / 6;
var spin_duration   = 5;
var o_fb_share_spec	= {
    width	: 768,
    height	: 500
};
o_fb_share_spec.top     = (screen.height / 2.5) - (o_fb_share_spec.height / 2);
o_fb_share_spec.left    = (screen.width / 2) - (o_fb_share_spec.width / 2);
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
    audio_click = new Audio('<?php echo base_url();?>media/audio/click.mp3');
    audio_tick  = new Audio('<?php echo base_url();?>media/audio/tick.mp3');
    audio_win   = new Audio('<?php echo base_url();?>media/audio/win.mp3');
    audio_lose  = new Audio('<?php echo base_url();?>media/audio/lose.mp3');
    let o_TheWheel = new Winwheel({
        'canvasId'       : 'canvas_Wheel',
        'numSegments'       : total_prize,            // Specify number of segments.
        'outerRadius'       : 420,            // Set outer radius so wheel fits inside the background.
        'drawMode'          : 'image',      // drawMode must be set to image.
        'drawText'          : true,         // Need to set this true if want code-drawn text on image wheels.
        'textFontSize'      : 12,
        'textOrientation'   : 'curved',     // Note use of curved text.
        'textDirection'     : 'reversed',   // Set other text options as desired.
        'textAlignment'     : 'outer',
        'textMargin'        : 5,
        'textFontFamily'    : '',
        'textStrokeStyle'   : '',
        'textLineWidth'     : 2,
        'textFillStyle'     : 'white',
        'animation' :                   // Specify the animation to use.
        {
            'type'     : 'spinToStop',
            'duration' : spin_duration,             // Duration in seconds.
            'spins'    : 8,             // Number of complete spins.
            'callbackSound'     : function(){
                <?php if(isset($this->a_submission['spin_status']) && $this->a_submission['spin_status'] == 0){ ?>
                    audio_tick.pause();
                    audio_tick.currentTime = 0;
                    audio_tick.play();
                <?php } ?>
            },
            'callbackFinished'  : function(segment){
                // ACTIVATE spin button
                //is_spinning   = false;

                // SHOW prize
                init_sharethis();
                jQuery(this).zboxOpen({
                    text: jQuery('#div_PopupPrize').html(),//jQuery('<div>').append(jQuery('#div_PopupPrize').clone()).html(),
                    callback: function(){
                        
                    }
                });

                <?php if(isset($this->a_submission['spin_status']) && $this->a_submission['spin_status'] == 0){ ?>
                    <?php if($this->spin_index != 6){ ?>
                        audio_win.currentTime = 0;
                        audio_win.play();
                    <?php }else{ ?>
                        audio_lose.currentTime = 0;
                        audio_lose.play();
                    <?php } ?>
                <?php } ?>
                
                <?php if(isset($this->a_submission['spin_status']) && $this->a_submission['spin_status'] == 0){ ?>
                jQuery.ajax({
                    type        : 'POST',
                    url         : '<?php echo base_url();?>spin/ajax-update-spin',
                    dataType    : 'json',
                    data        : {spin_status:1},
                    beforeSend  : function(){

                    },
                    error       : function(o_rtn){

                    },
                    success     : function(o_rtn){
                        
                    }
                });
                <?php } ?>
            }
        }
    });
    let loadedImg = new Image();
    loadedImg.onload = function()
    {
        o_TheWheel.wheelImage = loadedImg;    // Make wheelImage equal the loaded image object.
        o_TheWheel.draw();                    // Also call draw function to render the wheel.
    }
    loadedImg.src = '<?php echo base_url();?>media/images/<?php echo $this->pageName;?>/wheel.png';

    <?php if(isset($this->a_submission['spin_status']) && $this->a_submission['spin_status'] == 0){ ?>
        // spin_status == 0, allow spin
        jQuery('#btn_Spin').click(function(){
            if(is_spinning)
            {
                return;
            }

            audio_click.currentTime = 0;
            audio_click.play();

            // RESET the wheel
            o_TheWheel.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
            o_TheWheel.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
            o_TheWheel.draw();

            wheelPower  = 2
            if (wheelPower == 1) {
                o_TheWheel.animation.spins = 3;
            } else if (wheelPower == 2) {
                o_TheWheel.animation.spins = 8;
            } else if (wheelPower == 3) {
                o_TheWheel.animation.spins = 15;
            }

            o_TheWheel.animation.stopAngle = calculate_stop();
            o_TheWheel.startAnimation();

            // DEACTIVATE spin button
            is_spinning = true;

            jQuery('#btn_Spin').css('opacity', 0.5);
        });
    <?php }else { ?>
        // spin_status == 1, auto spin
        o_TheWheel.animation.duration   = 0;
        o_TheWheel.animation.stopAngle  = calculate_stop();
        o_TheWheel.startAnimation();

        jQuery('#btn_Spin').css('opacity', 0.5);
    <?php } ?>
    /*jQuery('.zbox_share_button.facebook').click(function(){
        window.open('https://www.facebook.com/sharer.php?t=&u=<?php echo urlencode(base_url());?>', "Post to Facebook", 'width=' + o_fb_share_spec.width + ',height=' + o_fb_share_spec.height + ',top=' + o_fb_share_spec.top + ',left=' + o_fb_share_spec.left);
    });
    jQuery('.zbox_share_button.wechat').click(function(){
        <?php //if($this->platform == 'desktop'){ ?>
            o_wechat_share_spec = {};
            o_wechat_share_spec.width   = 300;
            o_wechat_share_spec.height  = 300;
            o_wechat_share_spec.top     = (screen.height / 2.5) - (o_wechat_share_spec.height / 2);
            o_wechat_share_spec.left    = (screen.width / 2) - (o_wechat_share_spec.width / 2);
            window.open('https://chart.apis.google.com/chart?cht=qr&chs=154x154&chld=Q%7C0&chl=<?php echo urlencode(base_url());?>', "Share with WeChat", 'width=' + o_wechat_share_spec.width + ',height=' + o_wechat_share_spec.height + ',top=' + o_wechat_share_spec.top + ',left=' + o_wechat_share_spec.left);
        <?php /*}else{ ?>
            jQuery(this).zboxOpen({
                text: '<div id="div_BitLyShare" class="input_textbox"><input type="textbox" class="text" value="<?php echo base_url();?>" readonly /></div><button id="btn_ShareWeChat">Copy URL and open WeChat</button>'
            });
        <?php }*/ ?>
    });*/
});
jQuery(window).on('load', function(){
    
});
function calculate_stop()
{
    // 1: 331 - 30
    // 2: 31-90
    // 3: 91-150
    // 4: 151-180
    // 5: 211-240
    // 6: 271-300
    prize   = <?php echo $this->spin_index;?>;
    
    start   = (prize * prize_angle) - (prize_angle / 2) + 1 - prize_angle;
    if(start < 0)
    {
        start   = 360 + start;
    }

    spacing = 10;
    random  = Math.floor((Math.random() * prize_angle - (spacing * 2)));
    random  = (random > 0)?random:0;

    stop    = (start + spacing)+ random;
    
    return stop;
}
</script>