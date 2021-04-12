<style>
	body.debug {
		background-image: url('<?php echo base_url();?>media/images/<?php echo $this->platform;?>/<?php echo $this->pageName;?>/ref.jpg');
		min-height: 1495px;
	}
	body.debug .site_container {
		background: none !important;
		background-image: none !important;
	}
	.site_container {
		/*background-image: url('<?php echo base_url();?>media/images/<?php echo $this->platform;?>/<?php echo $this->pageName;?>/background-full.jpg');*/
	}
	<?php if($this->platform == 'desktop'){ ?>
		/*.site_container {
			background-color: transparent;
			background-image: url('<?php echo base_url();?>media/images/<?php echo $this->platform;?>/<?php echo $this->pageName;?>/background-0.5.png');
		}*/
	<?php } ?>
	/*#div_BackgroundComponent {
		background: transparent url('<?php echo base_url();?>media/images/<?php echo $this->platform;?>/<?php echo $this->pageName;?>/background_component.png') no-repeat center 0;
		height: calc(100% - 210px);
		position: absolute;
		margin: 0 auto;
		top: 0;
		width: 100%;
		z-index: 0;
	}*/
	#img_Stamp {
		left: 50%;
		margin-left: -240px;
		position: absolute;
	}
	#div_VoucherCode,
	#div_ValidationCode,
	#div_BitLy,
	#div_BitLyShare	{
		background-color: #FFF;
		border: 6px solid transparent;
		color: #005DA5;
		font-size: 30px;
		margin-left: auto;
		margin-right: auto;
		padding: 0 20px;
		position: relative;
		width: 600px;
	}
	#div_BitLyShare {
		margin-top: 0;
	}
	#div_ValidationCode {
		margin-top: 15px;
	}
		#div_VoucherCode span.title,
		#div_ValidationCode span.title {
			width: 270px;
			white-space: nowrap;
		}
		.input_textbox span.title,
		.input_textbox span.text,
		.input_textbox a.text {
			display: inline-block;
			font-family: "Neutra Text TF Demi";
			height: 66px;
			line-height: 66px;
		}
		.input_textbox input {
			border: 0;
			color: #808285;
			width: 100%;
		}
	#div_ThankYou,
	#div_ShareYourHappiness {
		text-align: center;
	}
	#div_ThankYou {
		color: #005DA5;
		line-height: 31px;
	}
	#div_BitLy,
	#div_BitLyShare {
		border-radius: 100px;
		color: #808285;
		margin: 10px auto 0;
		text-align: center;
	}
		#div_BitLy.input_textbox .text,
		#div_BitLyShare.input_textbox .text {
			font-size: 22px;
			text-align: center;
		}
	#div_SocialShare {
		display: block;
		height: 131px;
		text-align: center;
	}
		#a_SocialFacebook,
		#a_SocialLine,
		#a_SocialWhatsapp,
		#a_SocialWeChat {
			background: transparent url('<?php echo base_url();?>media/images/social_share_sprite.png') no-repeat 0 0;
			background-color: transparent !important;
			cursor: pointer;
			display: inline-block;
			height: 131px;
			margin: 0 5px;
			transition: all .2s ease-in-out;
			vertical-align: middle;
			width: 98px;
		}
		#a_SocialFacebook:hover,
		#a_SocialLine:hover,
		#a_SocialWhatsapp:hover,
		#a_SocialWeChat:hover {
			outline-offset: -1;
			transform: translateY(-4px);
		}
		#a_SocialLine {
			background-position: -196px 0;
		}
		#a_SocialWhatsapp {
			background-position: -294px 0;
		}
		#a_SocialWeChat {
			background-position: -392px 0;
		}
	#txt_BitlyURL {
		text-align: center;
	}
	#btn_ShareWeChat {
		margin-bottom: 20px;
	}
	
	#div_SocialShare div.at-share-btn-elements > a.at-icon-wrapper.at-share-btn {
		background: transparent url('<?php echo base_url();?>media/images/social_share_sprite.png') no-repeat 0 0 !important;
		background-color: transparent !important;
		display: inline-block !important;
		height: 131px !important;
		margin: 0 5px !important;
		width: 98px !important;
	}
		#div_SocialShare div.at-share-tbx-element {
			display: inline-block !important;
			vertical-align: middle !important;
		}
		#div_SocialShare div.at-share-btn-elements > a.at-icon-wrapper.at-share-btn > span {
			display: none;
		}
		#div_SocialShare div.at-share-btn-elements > a.at-icon-wrapper.at-share-btn.at-svc-lineme {
			background-position: -196px 0 !important;
		}
		#div_SocialShare div.at-share-btn-elements > a.at-icon-wrapper.at-share-btn.at-svc-whatsapp {
			background-position: -294px 0 !important;
		}
		#div_SocialShare div.at-share-btn-elements > a.at-icon-wrapper.at-share-btn.at-svc-wechat {
			background-position: -392px 0 !important;
		}
	
</style>
<?php if($this->config['environment'] == 'live'){ ?>
<!-- Event snippet for Website lead conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-663710308/f9TyCLDhvcgBEOTUvbwC'});
</script>
<?php } ?>
<?php /*<div id="div_BackgroundComponent"></div>*/ ?>
<a id="a_Logo" href="<?php echo base_url();?>"><img src="<?php echo media_url();?>images/logo.png" /></a>
<img id="img_Stamp" src="<?php echo media_url();?>images/<?php echo $this->pageName;?>-stamp-<?php echo strtolower($this->geoCountryCode);?>.png" />
<div class="container">
	<div class="row">
		<div class="col-12 p-0">
			<div id="div_Content">
				<div id="div_VoucherCode" class="input_textbox"><span class="title">VOUCHER CODE</span><span class="text">: <span class="text"><?php echo $_SESSION['ss_Submission']['voucher_code']?$_SESSION['ss_Submission']['voucher_code']:'&nbsp;';?> </span></div>
				<div id="div_ValidationCode" class="input_textbox"><span class="title">VALIDATION CODE</span><span class="text">: <span class="text"><?php echo $_SESSION['ss_Submission']['voucher_validation_code']?$_SESSION['ss_Submission']['voucher_validation_code']:'&nbsp;';?> </span></div>

				<div id="div_ThankYou">
					Valid for all Baskin-Robbins <?php echo (strtolower($this->geoCountryCode) == 'sg')?'Singapore':'Malaysia';?> outlets.*<br />
					Screenshot this page and present it to redeem your voucher!<br />
					Are you the Grand Prize winner? Check your email in April to find out!
				</div>

				<div id="div_ShareYourHappiness">Share your happiness with a friend!</div>

				<div id="div_BitLy" class="input_textbox"><input id="txt_BitlyURL" type="text" class="text" value="<?php echo $this->bitlyURL;?>" readonly /></div>

				<div id="div_SocialShare">
					<?php /*<a id="a_SocialFacebook" href="javascript:void(0);"></a>
					<a id="a_SocialLine" href="javascript:void(0);"></a>
					<a id="a_SocialWhatsapp" href="javascript:void(0);"></a>
					<a id="a_SocialWeChat" href="javascript:void(0);"></a>*/ ?>
					<div class="addthis_inline_share_toolbox" 
						data-url="<?php echo $this->bitlyURL;?>" 
						data-title="<?php echo $this->config[strtolower($this->geoCountryCode)]['line_share_desc'];?>">
						<a id="a_SocialFacebook" href="javascript:void(0);"></a>
						<a id="a_SocialWhatsapp" href="javascript:void(0);"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php /*<div id="div_ToggleDebug" style="background:#FF0000;position:fixed;height:100px;width:100px;bottom:0;right:0;z-index:2147483647"></div>*/ ?>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e57e125ca8ee092"></script>
<script>
jQuery(document).ready(function(){
	//jQuery('#div_BackgroundComponent').height((jQuery(document.body).outerHeight() - jQuery('footer').outerHeight()) + 'px');
	jQuery('#div_ToggleDebug').click(function(){
		jQuery('body').toggleClass('debug');
	});
	
	o_Spec	= {
		width	: 768,
		height	: 500
	};
	o_Spec.top	= (screen.height / 2.5) - (o_Spec.height / 2);
	o_Spec.left	= (screen.width / 2) - (o_Spec.width / 2);
	
	jQuery('#div_BitLy > input').click(function(){
		copy_inputbox('txt_BitlyURL');
	});
	
	// HACK Addthis
	/*addthisHacked	= false;
	function hack_addthis(evt){
		jQuery('#div_SocialShare div.at-share-btn-elements > a.at-icon-wrapper.at-share-btn').html('');
		jQuery('#div_SocialShare div.at-share-btn-elements > a.at-icon-wrapper.at-share-btn.at-svc-whatsapp')
			.unbind('click')
			.attr('id', 'a_SocialWhatsapp')
			.attr('class', '');
			
		if(jQuery('#a_SocialWhatsapp').length > 0)
		{
			jQuery(document).on('click', '#a_SocialWhatsapp', function(){
				<?php if($this->platform == 'desktop'){ ?>
					o_Spec.height	= 768;
					o_Spec.top		= (screen.height / 2.5) - (o_Spec.height / 2);
					window.open('https://web.whatsapp.com/send?text=<?php echo urlencode($this->bitlyURL);?>', "Share with Whatsapp", 'width=' + o_Spec.width + ',height=' + o_Spec.height + ',top=' + o_Spec.top + ',left=' + o_Spec.left);
				<?php }else{ ?>
					window.location = 'whatsapp://send?text=<?php echo urlencode($this->bitlyURL);?>';
				<?php } ?>
			});
			clearInterval(addthisHackInterval);
		}
	}
	
	addthis.addEventListener('addthis.ready', function(){
		addthisHackInterval	= setInterval(hack_addthis, 100);
		console.log(jQuery('#div_SocialShare .at-share-btn-elements').length)
	});*/
	
	jQuery('#a_SocialFacebook').click(function(){
		window.open('https://www.facebook.com/sharer.php?t=&u=<?php echo urlencode($this->bitlyURL);?>', "Post to Facebook", 'width=' + o_Spec.width + ',height=' + o_Spec.height + ',top=' + o_Spec.top + ',left=' + o_Spec.left);
	});
	
	jQuery('#a_SocialWhatsapp').click(function(){
		<?php if($this->platform == 'desktop'){ ?>
			o_Spec.height	= 768;
			o_Spec.top		= (screen.height / 2.5) - (o_Spec.height / 2);
			window.open('https://web.whatsapp.com/send?text=<?php echo urlencode($this->bitlyURL);?>', "Share with Whatsapp", 'width=' + o_Spec.width + ',height=' + o_Spec.height + ',top=' + o_Spec.top + ',left=' + o_Spec.left);
		<?php }else{ ?>
			// OPEN Whatsapp app
			window.location = 'whatsapp://send?text=<?php echo urlencode($this->bitlyURL);?>';
			
			setTimeout(function(){
				//window.location = 'https://play.google.com/store/apps/details?id=com.whatsapp';
				window.location	= 'https://api.whatsapp.com/send?text=<?php echo urlencode($this->bitlyURL);?>', "Share with Whatsapp", 'width=' + o_Spec.width + ',height=' + o_Spec.height + ',top=' + o_Spec.top + ',left=' + o_Spec.left;
			}, 25);
		<?php } ?>
	});
	jQuery('#a_SocialLine').click(function(){
		<?php if($this->platform == 'desktop'){ ?>
			window.open('https://lineit.line.me/share/ui?url=<?php echo urlencode($this->bitlyURL);?>', "Share with Line", 'width=' + o_Spec.width + ',height=' + o_Spec.height + ',top=' + o_Spec.top + ',left=' + o_Spec.left);
		<?php }else{ ?>
			window.location = 'https://social-plugins.line.me/lineit/share?url=<?php echo urlencode($this->bitlyURL);?>';
			//jQuery('div.at-share-btn-elements > a.at-icon-wrapper.at-share-btn.at-svc-lineme').trigger('click');
		<?php } ?>
	});
	jQuery('#a_SocialWeChat').click(function(){
		<?php if($this->platform == 'desktop'){ ?>
			o_Spec.width	= 300;
			o_Spec.height	= 300;
			o_Spec.top		= (screen.height / 2.5) - (o_Spec.height / 2);
			o_Spec.left		= (screen.width / 2) - (o_Spec.width / 2);
			window.open('https://chart.apis.google.com/chart?cht=qr&chs=154x154&chld=Q%7C0&chl=<?php echo urlencode($this->bitlyURL);?>', "Share with WeChat", 'width=' + o_Spec.width + ',height=' + o_Spec.height + ',top=' + o_Spec.top + ',left=' + o_Spec.left);
		<?php }else{ ?>
			jQuery(this).zboxOpen({
				text: '<div id="div_BitLyShare" class="input_textbox"><input type="textbox" class="text" value="<?php echo $this->bitlyURL;?>" readonly /></div><button id="btn_ShareWeChat">Copy URL and open WeChat</button>'
			});
		<?php } ?>
	});
	jQuery(document).on('click', '#btn_ShareWeChat', function() {
		copy_inputbox('txt_BitlyURL');
		
		$this	= jQuery(this);
		$this.html('Opening WeChat');
		
		setTimeout(function(){
			window.location = 'weixin://';
		}, 1000);
		
		setTimeout(function(){
			jQuery('.zbox_close').trigger('click');
		}, 3000);
	});
	
	function copy_inputbox(objID)
	{
		jQuery('#' + objID).prop('readonly', false);
		
		var copyText = document.getElementById(objID);
		copyText.select();
		copyText.setSelectionRange(0, 99999)
		document.execCommand("copy");
		
		jQuery('#' + objID).prop('readonly', true);
	}
})
jQuery(window).on('load', function(){
	//jQuery('#div_BackgroundComponent').height((jQuery(document.body).outerHeight() - jQuery('footer').outerHeight()) + 'px');
	jQuery('.site_container').css('background-image','url(\'<?php echo base_url();?>media/images/<?php echo $this->platform;?>/<?php echo $this->pageName;?>/background-full.jpg\')');
});
</script>