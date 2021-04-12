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
</style>
<div class="container">
    <div class="row">
        <div class="col-12 p-0">
            <div id="div_SpinAndWin"></div>
            <div id="div_Mid">
                <div id="div_Ketupat"></div>
                <?php //if(isset($this->a_Submission['spin_status']) && $this->a_Submission['spin_status'] == 0){ ?>
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
<script src="<?php echo base_url();?>media/js/Winwheel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
<script>
var idleTime	= 0;
var is_spinning   = false;
var total_prize     = 6;
var prize_angle     = 360 / 6;
var spin_duration   = 5;
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
            'callbackFinished' : function(segment){
                // ACTIVATE spin button
                //is_spinning   = false;
                // SHOW prize

                return;

                <?php if(isset($this->a_Submission['spin_status']) && $this->a_Submission['spin_status'] == 0){ ?>
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

    <?php if(isset($this->a_Submission['spin_status']) && $this->a_Submission['spin_status'] == 0){ ?>
        // spin_status == 0, allow spin
        jQuery('#btn_Spin').click(function(){
            if(is_spinning)
            {
                return;
            }

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
        });
    <?php }else { ?>
        // spin_status == 1, auto spin
        o_TheWheel.animation.stopAngle  = calculate_stop();
        o_TheWheel.animation.duration   = 0;
        o_TheWheel.startAnimation();
    <?php } ?>
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
    prize   = <?php echo (isset($this->a_Submission['spin_prize']) && $this->a_Submission['spin_prize'] != '')?$this->a_Submission['spin_prize']:6;?>;
    
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