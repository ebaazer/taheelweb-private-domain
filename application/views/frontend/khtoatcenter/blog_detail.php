<section class="sec-tpadding-2 section-light">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="col-md-12 nopadding">
                    <div class="blog1-post-holder">
                        <div class="image-holder">
                            
                            <div class="owl-item1" style="width: 100%;">
                                <div class="item">
                                    <img src="<?php echo $folder; ?>blog_images/<?php echo $blog->photo; ?>" alt="" class="img-responsive" style="width: 100%; height: auto;">
                                </div>
                            </div>
                            
                        </div>

                        <div class="text-box-inner">
                            <h1>
                                <?php echo $blog->title; ?>
                            </h1>

                            <div class="container sct-inner">
                                <ul class="inline-links inline-links--style-1 mt-4" style=" padding-right: 0px;">
                                    <li>
                                        <i class="fa fa-calendar"></i>
                                        <?php echo $blog->timestamp; ?>
                                    </li>
                                    <li>
                                        <?php
                                        //$user = $this->frontend_model->get_user_from_type_id($blog->posted_by);
                                        ?>
                                        <i class="fa fa-user"></i>
                                        فريق عمل 
                                        <?php echo $center_name; ?>
                                        <br />
                                        تحت اشراف أ.عماد الهندي
                                    </li>
                                </ul>
                            </div>

                            <hr />

                            <?php echo $blog->blog_post; ?>

                            <div class="clearfix"></div>

                            <!--
                            <div class="clearfix"></div>
                            <br>
                            <div class="blog1-post-info-box">
                                <div class="text-box border padding-3">
                                    <div class="iconbox-medium left round overflow-hidden">
                                        <img src="./320.jpg" alt="" class="img-responsive"></div>
                                    <div class="text-box-right more-padding-2">
                                        <h5 class="uppercase dosis less-mar2">الاسم</h5>
                                        <div class="blog1-post-info"> <span>التاريخ والوقت</span></div>
                                        <p class="paddtop1">الرد</p>
                                        <br>
                                        <a class="btn btn-border yellow-green btn-small-2 " href="">الرد على التعليق</a> </div>
                                </div>
                            </div>
                            -->

                            <div class="clearfix"></div>

                            <hr />
                            <!-- <a class="loadmore-but" href="#">Load more Comments</a> -->

                            <div class="smart-forms bmargin">

                                <h4 class=" dosis uppercase">
                                    اضف تعليق
                                </h4>

                                <form method="post" action="" id="smart-form" novalidate="novalidate">
                                    <div>
                                        <div class="section">
                                            <label class="field prepend-icon">
                                                <input type="text" name="sendername" id="sendername" class="gui-input" placeholder="Enter name">
                                                <span class="field-icon"><i class="fa fa-user"></i></span> </label>
                                        </div>

                                        <div class="section">
                                            <label class="field prepend-icon">
                                                <input type="email" name="emailaddress" id="emailaddress" class="gui-input" placeholder="Email address">
                                                <span class="field-icon"><i class="fa fa-envelope"></i></span> </label>
                                        </div>

                                        <div class="section">
                                            <label class="field prepend-icon">
                                                <input type="text" name="sendersubject" id="sendersubject" class="gui-input" placeholder="Enter subjec">
                                                <span class="field-icon"><i class="fa fa-lightbulb-o"></i></span> </label>
                                        </div>

                                        <div class="section">
                                            <label class="field prepend-icon">
                                                <textarea class="gui-textarea" id="sendermessage" name="sendermessage" placeholder="Enter message"></textarea>
                                                <span class="field-icon"><i class="fa fa-comments"></i></span>
                                                <span class="input-hint">
                                                    <strong>تنبيه:</strong> 
                                                    يرجى إدخال ما بين 80 إلى 300 حرفًا.
                                                </span>
                                            </label>
                                        </div>

                                        <div class="result"></div>

                                    </div>

                                    <div class="form-footer">
                                        <button type="submit" data-btntext-sending="Sending..." class="button btn-primary yellow-green">ارسال</button>
                                        <button type="reset" class="button"> تفريغ الحقول </button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div> 

            </div>

            <div class="col-md-4">
                <div class="col-md-12 nopadding">
                    <div class="blog1-sidebar-box">
                        <div class="image-holder"><img src="./303.jpg" alt="" class="img-responsive"></div>
                        <div class="text-box-inner">
                            <h5 class="uppercase dosis">
                                <?php
                                echo $center_name;
                                ?>
                            </h5>
                            <p style="text-align: justify;">
                                يسعى المركز إلى تحقيق أهداف سامية تخدم الأشخاص من ذوي صعوبات التعلم وأسرهم والمجتمع بأكمله، وذلك من خلال مجموعة من الأدوات والوسائل والدورات والأنشطة والمؤتمرات وورش العمل التي يشرف عليها أمهر الكوادر المتخصصة في المجال التعليمي والتربوي والتربوي والعلاجي وأكثرهم احترافية
                            </p>
                            <br>
                            <div class="clearfix"></div>
                            <ul class="blog1-social-icons">
                                <li><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://www.instagram.com/Khtoat.rak"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!--
                <div class="col-md-12 nopadding">
                    <div class="blog1-sidebar-box">
                        <div class="text-box-inner">
                            <h5 class="uppercase dosis">Search</h5>
                            <div class="clearfix"></div>
                            <input class="blog1-sidebar-serch_input" type="search" placeholder="Email Address">
                            <input name="" value="Submit" class="blog1-sidebar-serch-submit" type="submit">
                        </div>
                    </div>
                </div>
                -->

                <div class="col-md-12 nopadding">
                    <div class="blog1-sidebar-box">
                        <div class="text-box-inner">
                            <h5 class="uppercase dosis">
                                التصنيفات
                            </h5>
                            <div class="clearfix"></div>
                            <ul class="category-links">
                                <li><a href="#">تعديل السلوك</a></li>
                                <li><a href="#">تحليل السلوك التطبيقي</a></li>
                                <li><a href="#">اضطراب طيف التوحد</a></li>
                                <li><a href="#">صعوبات تعلم</a></li>
                                <li><a href="#">تربية خاصة</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--end sidebar box-->

                <div class="col-md-12 nopadding">
                    <div class="blog1-sidebar-box">
                        <div class="text-box-inner">
                            <h5 class="uppercase dosis">
                                الاكثر قراءة
                            </h5>

                            <div class="clearfix"></div>

                            <?php
                            $this->db->select("a.*");
                            $this->db->from("frontend_blog a");
                            $this->db->where("a.published", 1);
                            $this->db->where("a.active", 1);
                            $this->db->order_by('rand()');
                            $this->db->limit(4); // إضافة حد لعدد النتائج
                            $frontend_blog_array = $this->db->get()->result_array();

                            foreach ($frontend_blog_array as $frontend_blog_array_row) {
                                ?>  

                                <div class="blog1-sidebar-posts">
                                    <div class="image-left"><img src="./304.jpg" alt=""></div>
                                    <div class="text-box-right">
                                        <h6 class="less-mar3 uppercase dosis nopadding">
                                            <a href="#">
                                                <?php echo $frontend_blog_array_row['title']; ?>
                                            </a>
                                        </h6>
                                        <p>
                                            <?php echo substr($frontend_blog_array_row['short_description'], 0, 150); ?>
                                        </p>

                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>



                <!--
                <div class="col-md-12 nopadding">
                    <div class="blog1-sidebar-box">
                        <div class="text-box-inner">
                            
                            <h5 class="uppercase dosis">
                                العنوان
                            </h5>
                            
                            <div class="clearfix"></div>
                            
                            <ul id="basicuse" class="thumbs">
                                <li>
                                    <a href="./0262026e0c_b.jpg">
                                        <img src="./0262026e0c_s.jpg" alt="6">
                                    </a>
                                </li>
                                <li>
                                    <a href="./70bf6940eb_b.jpg">
                                        <img src="./70bf6940eb_s.jpg" alt="5">
                                    </a>
                                </li>
                                <li>
                                    <a href="./855c5044e9_b.jpg">
                                        <img src="./855c5044e9_s.jpg" alt="4">
                                    </a>
                                </li>
                                <li>
                                    <a href="./41e25ca0fd_b.jpg">
                                        <img src="./41e25ca0fd_s.jpg" alt="3">
                                    </a>
                                </li>
                                <li>
                                    <a href="./29f0ae19cc_b.jpg">
                                        <img src="./29f0ae19cc_s.jpg" alt="2">
                                    </a>
                                </li>
                                <li>
                                    <a href="./01227fe614_b.jpg">
                                        <img src="./01227fe614_s.jpg" alt="1">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                -->

                <div class="col-md-12 nopadding">
                    <div class="blog1-sidebar-box">
                        <div class="text-box-inner">
                            <h5 class="uppercase dosis">
                                الوسوم
                            </h5>
                            <div class="clearfix"></div>
                            <ul class="tags">
                                <li><a href="#">مراكز ذوي الإعاقة</a></li>
                                <li><a href="#">إرشاد أسري</a></li>
                                <li><a href="#">تعليم التوحد</a></li>
                                <li><a href="#">دعم الأسر</a></li>
                                <li><a href="#">التربية الخاصة</a></li>
                                <li><a href="#">تمكين ذوي الاحتياجات الخاصة</a></li>
                                <li><a href="#">خدمات التوحد</a></li>
                                <li><a href="#">رعاية ذوي الإعاقة</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!--
                <div class="col-md-12 nopadding">
                    <div class="blog1-sidebar-box">
                        <div class="text-box-inner">
                            <h5 class="uppercase dosis">النشرة الاخبارية</h5>
                            <div class="clearfix"></div>
                            <input class="blog1-sidebar-serch_input" type="search" placeholder="Email Address">
                            <input name="" value="Submit" class="blog1-sidebar-serch-submit" type="submit">
                        </div>
                    </div>
                </div>
                -->

                <!--
                <div class="col-md-12 nopadding">
                    <div class="blog1-sidebar-box">
                        <div class="text-box-inner">
                            <h5 class="uppercase dosis">Featured Works</h5>
                            <div class="clearfix"></div>
                            <ul class="sidebar-works">
                                <li><a href="#"><img src="./307.jpg" alt=""></a></li>
                                <li><a href="#"><img src="./308.jpg" alt=""></a></li>
                                <li class="last"><a><img src="./309.jpg" alt=""></a></li>
                                <li><a href="#"><img src="./310.jpg" alt=""></a></li>
                                <li><a href="#"><img src="./311.jpg" alt=""></a></li>
                                <li class="last"><a href="#"><img src="./312.jpg" alt=""></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                --> 

            </div>

        </div>
    </div>
</section>
<div class="clearfix"></div>
