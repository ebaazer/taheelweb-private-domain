
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/hasta/js/universal/jquery.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/hasta/js/bootstrap/bootstrap.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/hasta/js/jFlickrFeed/jflickrfeed.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/hasta/js/jFlickrFeed/jquery.cycle.all.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/hasta/js/masterslider/jquery.easing.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/hasta/js/masterslider/masterslider.min.js"></script> 
<script type="text/javascript">
    (function ($) {
        "use strict";
        var slider = new MasterSlider();
        // adds Arrows navigation control to the slider.
        slider.control('arrows');
        slider.control('bullets');

        slider.setup('masterslider', {
            width: 1600, // slider standard width
            height: 660, // slider standard height
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
<script>
    $('#basicuse').jflickrfeed({
        limit: 6,
        qstrings: {
            id: '133294431@N08'
        },
        itemTemplate:
                '<li>' +
                '<a href="{{image_b}}"><img src="{{image_s}}" alt="{{title}}" /></a>' +
                '</li>'
    });
</script> 


<script src="<?php echo base_url(); ?>assets/frontend/hasta/js/owl-carousel/owl.carousel.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/hasta/js/owl-carousel/custom.js"></script> 





<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/hasta/js/smart-forms/jquery.form.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/hasta/js/smart-forms/jquery.validate.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/hasta/js/smart-forms/additional-methods.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/hasta/js/smart-forms/smart-form.js"></script>





<script src="<?php echo base_url(); ?>assets/frontend/hasta/js/mainmenu/customeUI.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/hasta/js/cubeportfolio/jquery.cubeportfolio.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/hasta/js/cubeportfolio/main.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/hasta/js/scrolltotop/totop.js"></script> 
<script src="<?php echo base_url(); ?>assets/frontend/hasta/js/mainmenu/jquery.sticky.js"></script> 

<script src="<?php echo base_url(); ?>assets/frontend/hasta/js/scripts/functions.js" type="text/javascript"></script>