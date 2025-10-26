<?php
$this->db->where('active', 1);
$this->db->where('published', 1);
$this->db->order_by('timestamp', 'desc');
$blogs = $this->db->get('frontend_blog', $per_page, $this->uri->segment(3))->result_array();
?>

<div class="clearfix"></div>

<section>
    <div class="header-inner two">
        <div class="inner text-center">
            <h4 class="title text-white uppercase">
                <?php echo $page_title; ?>
            </h4>
            <h5 class="text-white uppercase">
                محتوى تعليمي ملهم لأصحاب الهمم
            </h5>
        </div>
        <div class="overlay bg-opacity-5"></div>
        <img src="images/header-img.jpg" alt="" class="img-responsive"/> </div>
</section>
<!-- end header inner -->
<div class="clearfix"></div>

<section class="sec-padding">
    <div class="container">
        <div class="row">

            <div class="clearfix"></div>

            <?php foreach ($blogs as $row) { ?>


                <div class="col-md-6 col-sm-12 col-xs-12 bmargin">
                    <img src="<?php echo $folder; ?>blog_images/<?php echo $row['photo']; ?>" style="max-width: 450px;"  alt="" class="img-responsive"/>
                    <div class="col-md-12 no-gutter">
                        <div class="text-box padding-top-5">
                            <h3 class=" raleway">
                                <a href="<?php echo base_url(); ?>home/blog_detail/<?php echo $row['encrypt_thread']; ?>">
                                    <?php echo $row['title']; ?>
                                </a>
                            </h3>
                            <div class="blog-post-info">
                                <span>
                                    <i class="fa fa-calendar"></i>
                                    <?php echo $row['timestamp']; ?>
                                </span>
                                <span>
                                    <i class="fa fa-user"></i>
                                    فريق عمل مركز خطوات لصعوبات التعلم
                                </span>
                            </div>
                            <br/>
                            
                                                        <p>
                                <?php echo $row['short_description']; ?>...
                            </p>
                            <div class="divider-line solid light"></div>
                            <br/>




                        </div>
                    </div>
                </div>

            <?php } ?>

            <div class="clearfix"></div>
            <div class="col-divider-margin-5"></div>


            <div class="row justify-content-center pt-5">
                <?php echo $this->pagination->create_links(); ?>
            </div>


        </div>
    </div>
</section>
<!--end section-->
<div class="clearfix"></div>
