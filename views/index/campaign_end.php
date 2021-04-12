<style>
	.site_container {
		background-color: transparent;
		box-shadow: none;
		height: auto !important;
	}
	html.float_bottom_footer body footer {
		margin-top: 0;
		position: relative;
	}
	footer {
		margin-top: 0 !important;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-12 p-0">
			<a id="a_ReturnToHomePage" href="<?php echo $this->a_HomeLink[strtolower($this->geoCountryCode)];?>"></a>
		</div>
	</div>
</div>
<script>
jQuery(window).on('load', function(){
	jQuery('.site_container').css('background-image','url(\'<?php echo base_url();?>media/images/<?php echo $this->platform;?>/<?php echo $this->pageName;?>/background-full.jpg\')');
});
</script>