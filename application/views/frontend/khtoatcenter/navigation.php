<!--
<div class="topbar light topbar-padding" style=" background-color: #45cdcb; font-weight: bold; color: #FFF;">
    <div class="container" >
        <center>
            "موقعنا تحت التطوير حاليًا لتحسين تجربتكم. شكرًا لصبركم وكونوا على تواصل معنا للمزيد من التحديثات!"
        </center>
    </div>
</div>
-->

<div class="clearfix"></div>

<div class="topbar light topbar-padding">
    <div class="container">
        <div class="row justify-content-start">
            <div class=" col-3" >
                <div class="topbar-right-items two" style=" width: 30% !important;">
                    <ul class="toplist toppadding pull-left paddtop1">
                        <li class="rightl">
                            <i class="fa fa-map-marker"></i>
                        </li>
                        <li style="direction: ltr !important;">
                            خلف مطبخ خالد حرية - طريق خزام
                            <br />
                            رأس الخيمة - الإمارات العربية المتحدة
                        </li>
                    </ul>
                </div>
            </div>

            <div class=" col-3" >
                <div class="topbar-left-items two" style=" width: 26% !important;">
                    <ul class="toplist toppadding pull-left paddtop1">
                        <li class="rightl">
                            <i class="fa fa-phone"></i>
                        </li>
                        <li style="direction: ltr !important;">
                            (واتس اب) 0509915853
                        </li>
                        <br />
                        <li class="rightl">
                            <i class="fa fa-phone"></i>
                        </li>
                        <li style="direction: ltr !important;">
                            072221500
                        </li>
                    </ul>
                </div>
            </div>

            <div class=" col-4" >
                <div class="topbar-right-items two pull-right" style=" width: 44% !important;">
                    <ul class="toplist toppadding">
                        <li class="rightl">
                            <i class="fa fa-calendar"></i>
                        </li>
                        <li>
                            من السبت إلى الخميس
                            - 8am الى 10pm
                            <br />
                            الجمعة مغلق
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>home/booking" class=" btn btn-blue less-top-bottom-padding btn-round btn-small-2">
                                احجز موعد الآن
                            </a>
                        </li>

                        <li>
                            <a onclick="getLocationAndOpenMaps()" style="margin-top: 5px;" class=" btn btn-orange less-top-bottom-padding btn-round btn-small-2">
                                &nbsp;  google maps
                            </a>

                            <script>
                                function getLocationAndOpenMaps() {
                                    if (navigator.geolocation) {
                                        navigator.geolocation.getCurrentPosition(function (position) {
                                            var userLat = position.coords.latitude;
                                            var userLng = position.coords.longitude;
                                            var destination = "25.7650021,55.9309117"; // إحداثيات مركز خطوات
                                            var googleMapsUrl = `https://www.google.com/maps/dir/${userLat},${userLng}/${destination}`;
                                            window.open(googleMapsUrl, "_blank");
                                        }, function (error) {
                                            alert("تعذر الحصول على موقعك. الرجاء تمكين الموقع والمحاولة مرة أخرى.");
                                        });
                                    } else {
                                        alert("المتصفح لا يدعم تحديد الموقع الجغرافي.");
                                    }
                                }
                            </script>

                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="clearfix"></div>

<div id="header">
    <div class="container">
        <div class="navbar blue navbar-default yamm">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target="#navbar-collapse-grid" class="navbar-toggle two three"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                <a href="index.html" class="navbar-brand less-top-padding">
                    <?php
                    $folder = "https://ft.taheelweb.com/uploads/khtoatcenter/";
                    $u_logo = "0902de6754902769d0f2772b3e9699af1254a2a5863cf56a.jpg";
                    ?>
                    <img style=" width: 55px;" src="<?php echo $folder; ?>/logo/<?php echo $u_logo; ?>" alt=""/>
                </a>
            </div>
            <div id="navbar-collapse-grid" class="navbar-collapse collapse pull-right">
                <ul class="nav blue navbar-nav">
                    <li>
                        <a href="<?php echo base_url(); ?>home" class="dropdown-toggle active">
                            <?php echo $this->lang->line('home'); ?>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>home/about_us" class="dropdown-toggle">
                            <?php echo $this->lang->line('about'); ?>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>home/gallery" class="dropdown-toggle">
                            <?php echo $this->lang->line('gallery'); ?>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>home/blog" class="dropdown-toggle">
                            <?php echo $this->lang->line('blog'); ?>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>home/booking" class="dropdown-toggle">
                            <?php echo $this->lang->line('Booking'); ?>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>home/contact_us" class="dropdown-toggle">
                            <?php echo $this->lang->line('contact'); ?>
                        </a>
                    </li>

                    <li>
                        <a href="https://khtoatcenter.taheelweb.com/login" class="dropdown-toggle">
                            <?php echo $this->lang->line('login'); ?>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>