
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/universal/jquery.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/bootstrap/bootstrap.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/masterslider/jquery.easing.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/masterslider/masterslider.min.js"></script> 
<script type="text/javascript">
    (function ($) {
        "use strict";
        var slider = new MasterSlider();
        // adds Arrows navigation control to the slider.
        slider.control('arrows');
        slider.control('bullets');

        slider.setup('masterslider', {
            width: 1600, // slider standard width
            height: 630, // slider standard height
            space: 0,
            speed: 45,
            layout: 'fullwidth',
            loop: true,
            preload: 0,
            autoplay: true,
            view: "parallaxMask"
        });

    })(jQuery);
</script> 
<script type="text/javascript">
    (function ($) {
        "use strict";
        var slider = new MasterSlider();

        slider.setup('masterslider2', {
            width: 570, // slider standard width
            height: 300, // slider standard height
            space: 0,
            speed: 27,
            layout: 'boxed',
            loop: true,
            preload: 0,
            autoplay: true,
            view: "basic",
        });
    })(jQuery);
</script> 
<script src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/mainmenu/customeUI.js"></script>  
<script src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/owl-carousel/owl.carousel.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/owl-carousel/custom.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/tabs/smk-accordion.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/tabs/custom.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/scrolltotop/totop.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/mainmenu/jquery.sticky.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/style-swicher/style-swicher.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/style-swicher/custom.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/smart-forms/jquery.form.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/smart-forms/jquery.validate.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/smart-forms/additional-methods.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/smart-forms/smart-form.js"></script> 
<script src="js/scripts/functions.js" type="text/javascript"></script>