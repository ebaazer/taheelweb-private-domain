<section class="parallax-section45">
    <div class="section-overlay yellow-2 bg-opacity-9">
        <div class="container sec-tpadding-2 sec-bpadding-2" style=" padding: 40px;">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h4 class=" love-ya-like-a-sister">
                        
                        لقد انتهت صلاحية حسابك
                        
                        <br />
                        <br />
                        
                        نأسف لاعلامكم أننا سنضظر لتعليق العمل لهذا الحساب
                    </h4>
                    
                    <div class="title-line-4 align-center" style=" margin: 0 auto 20px auto"></div>

                    <h4 class=" love-ya-like-a-sister">
                        سنبقى نحتفظ ببيانتك حتى 

                        <br />
                        <?php
                        $expiration_date = $this->db->get_where('settings', array('type' => 'expiration_date'))->row()->description;
                        $curdate = date('Y-m-d');

                        echo date('Y-m-d', strtotime($expiration_date. ' + 30 days'));                    
                        ?>
                        
                    </h4>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="cloud-pattren2"></div>
    </div>
</section>
<!--end section-->
<div class="clearfix"></div>

<section>
    <div class="container">
        <div class="divider-line solid light"></div>
        <div class="row sec-padding">

            <div class="col-md-4 bmargin">
            </div>

            <div class="col-md-4 bmargin">
                <a class="full-btn-1 bg-color-3" href="https://www.taheelweb.com/">
                    <?php echo $this->lang->line('subscription_renewal'); ?>
                </a>
            </div>

            <div class="col-md-4 bmargin">
            </div>

        </div>
    </div>
</section>
<!--end section-->
<div class="clearfix"></div>