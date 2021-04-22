<script>
jQuery(document).ready(function(){
    setTimeout(function(){
        // SHOW prize
        // jQuery(this).zboxOpen({
        //     text: jQuery('#div_PopupPrize').html(),//jQuery('<div>').append(jQuery('#div_PopupPrize').clone()).html(),
        //     callback: function(){
                
        //     }
        // });
        init_sharethis();
        jQuery('body').append('<a href="javascript:void(0)" class="zbox_share_button facebook st-custom-button" data-network="facebook"></a>');
    }, 1000)
});
</script>