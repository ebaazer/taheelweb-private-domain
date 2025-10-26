<?php


$this->db->where('published', 1);
$this->db->order_by('date_added', 'desc');
$gallery = $this->db->get('frontend_gallery', $per_page, $this->uri->segment(3))->result_array();


?>


<section class="slice--offset parallax-section parallax-section-xl b-xs-bottom custom-page-head"
         style="background-image: url('<?php echo base_url('assets/frontend/' . $theme . '/images/img-15.jpg'); ?>');">
    <div class="container">
        <div class="row py-3">
            <div class="col-lg-12">
                <h1 class="heading text-uppercase c-white">
                    <?php echo $page_title; ?>
                </h1>

                <span class="clearfix"></span>

                <div class="">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            <?php echo $page_title; ?>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo site_url('home'); ?>">
                                <?php echo $this->lang->line('home'); ?>
                            </a>
                        </li>                        
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="slice sct-color-1">
    <div class="container">
        <div dir="rtl" class="row masonry">
            <?php foreach ($gallery as $row) { ?>
                <div class="masonry-item col-sm-6 col-md-4">
                    <div class="block block--style-3">
                        <div class="block-image relative">
                            <div class="">
                                <a href="<?php echo base_url(); ?>home/blog_details/<?php echo $row['frontend_gallery_id']; ?>">
                                    <img src="<?php echo base_url('uploads/gallery_cover/' . $row['photo']); ?>">                                
                                </a>
                            </div>
                        </div>
                        <div class="block-body">
                            <h3 class="heading heading-5 strong-500">
                                <a href="<?php echo base_url(); ?>home/blog_details/<?php echo $row['frontend_blog_id']; ?>" 
                                <?php echo $row['title']; ?>
                            </a>
                        </h3>
                        <p>
                            <?php echo substr($row['short_description'], 0, 150); ?>...
                        </p>
                    </div>
                    <div class="block-footer b-xs-top">
                        <div class="row align-items-center">
                            <div class="col-6 text-right">
                                <a href="<?php echo base_url(); ?>home/blog_details/<?php echo $row['frontend_blog_id']; ?>" 
                                   class="link link-sm link--style-2">
                                    <i class="fa fa-long-arrow-left"></i> <?php echo $this->lang->line('read_more'); ?>
                                </a>
                            </div>                            
                            <div class="col-6">
                                <ul class="inline-links inline-links--style-3">
                                    <li>
                                        <i class="fa fa-calendar"></i> <?php echo date('d M, Y', $row['timestamp']); ?>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="row justify-content-center pt-5">
        <?php echo $this->pagination->create_links(); ?>
    </div>
</div>
</section>