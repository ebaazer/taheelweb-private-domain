<?php
include 'masterslider_text.php';
?>
<div class="master-slider ms-skin-default" id="masterslider" style="direction: ltr;"> 

    <!-- slide 1 -->
    <div class="ms-slide slide-1" data-delay="9">

        <img src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/masterslider/blank.gif" 
             data-src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/images/sliders/1.png" alt=""/>

        <img src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/masterslider/blank.gif" 
             data-src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/images/sliders/img1.png" alt=""
             style="left: 230px; top: 60px;"
             class="ms-layer"
             data-type="image"
             data-delay="500"
             data-duration="2500"
             data-ease="easeOutExpo"
             data-effect="scalefrom(1.1,1.1,30,0)"
             />
        <h3 class="ms-layer text48"
            style="top: 230px; right:230px;"
            data-type="text"
            data-delay="1000"
            data-ease="easeOutExpo"
            data-duration="1230"
            data-effect="scale(1.5,1.6)"> 
                <?php echo $text_01; ?>
        </h3>

        <h3 class="ms-layer text49"
            style="top: 300px; right:230px;"
            data-type="text"
            data-delay="1500"
            data-ease="easeOutExpo"
            data-duration="1230"
            data-effect="scale(1.5,1.6)">
                <?php echo $text_02; ?>
            <br />
            <?php echo $text_03; ?>
            <br />
            <?php echo $text_04; ?>
        </h3>

        <a class="ms-layer sbut21"
           href="home/masterslider_article/article_1"
           style="right: 230px; top: 380px;"
           data-type="text"
           data-delay="2000"
           data-ease="easeOutExpo"
           data-duration="1200"
           data-effect="scale(1.5,1.6)"> اقرأ المزيد </a> 

    </div>
    <!-- end slide 1 -->

    <!-- slide 2 -->
    <div class="ms-slide slide-1" data-delay="9">

        <img src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/masterslider/blank.gif" 
             data-src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/images/sliders/2.png" alt=""/>

        <img src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/masterslider/blank.gif" 
             data-src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/images/sliders/img3.png" alt=""
             style="left: 550px; top: 60px;"
             class="ms-layer"
             data-type="image"
             data-delay="500"
             data-duration="2500"
             data-ease="easeOutExpo"
             data-effect="scalefrom(1.1,1.1,30,0)"
             />

        <img src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/masterslider/blank.gif" 
             data-src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/images/sliders/img2.png" alt=""
             style="left: 230px; top: 20px;"
             class="ms-layer"
             data-type="image"
             data-delay="1000"
             data-duration="2500"
             data-ease="easeOutExpo"
             data-effect="scalefrom(1.1,1.1,30,0)"
             />

        <h3 class="ms-layer text48"
            style="top: 230px; right:230px;"
            data-type="text"
            data-delay="1500"
            data-ease="easeOutExpo"
            data-duration="1230"
            data-effect="scale(1.5,1.6)"> 
            <?php echo $text_08; ?>
        </h3>

        <h3 class="ms-layer text49"
            style="top: 300px; right:230px;"
            data-type="text"
            data-delay="2000"
            data-ease="easeOutExpo"
            data-duration="1230"
            data-effect="scale(1.5,1.6)"> 
            <?php echo $text_09; ?>
            <br />
         <?php echo $text_07; ?>  
        </h3>

        <!--
        <a class="ms-layer sbut21"
           style="right: 230px; top: 380px;"
           data-type="text"
           data-delay="2500"
           data-ease="easeOutExpo"
           data-duration="1200"
           data-effect="scale(1.5,1.6)"> اقرأ المزيد </a> 
        -->

    </div>
    <!-- end slide 2 -->

    <!-- slide 3 -->
    <div class="ms-slide slide-3" data-delay="9">

        <img src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/js/blank.gif" 
             data-src="<?php echo base_url(); ?>assets/frontend/khtoatcenter/images/sliders/3.png" alt=""/>

        <h3 class="ms-layer text48 text-center no-border"
            style="top: 230px; color: #000000;"
            data-type="text"
            data-delay="1500"
            data-ease="easeOutExpo"
            data-duration="1230"
            data-effect="scale(1.5,1.6)">
                <?php echo $text_05; ?>
        </h3>

        <h3 class="ms-layer text49 text-center"
            style="top: 300px; color: #000000;"
            data-type="text"
            data-delay="2000"
            data-ease="easeOutExpo"
            data-duration="1230"
            data-effect="scale(1.5,1.6)">
                <?php echo $text_06; ?>
        </h3>

        <a class="ms-layer sbut21"
           href="home/masterslider_article/article_3"
           style="left: 730px; top: 380px;"
           data-type="text"
           data-delay="2500"
           data-ease="easeOutExpo"
           data-duration="1200"
           data-effect="scale(1.5,1.6)"> اقرأ المزيد </a>
    </div>
    <!-- end slide 3 --> 

</div>