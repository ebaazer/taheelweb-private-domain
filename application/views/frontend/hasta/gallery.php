<?php
$this->db->where('published', 1);
$this->db->where('active', 1);
$this->db->order_by('timestamp', 'desc');
$gallery = $this->db->get('frontend_gallery', $per_page, $this->uri->segment(3))->result_array();
?>

<section class="slice sct-color-1" style="padding-top: 30px;">
    <div class="container">
        <div dir="rtl" class="row masonry">
            <?php foreach ($gallery as $row) { ?>
                <div class="masonry-item col-sm-6 col-md-4">
                    <div class="block block--style-3">
                        <div class="block-image relative">
                            <div class="">
                                <a href="<?php echo base_url(); ?>home/gallery_view/<?php echo $row['encrypt_thread']; ?>">
                                    <img style="max-width: 260px; min-width : 260px;"
                                         src="<?php echo $folder.'/gallery_cover/'. $row['photo']; ?>">
                                </a>
                            </div>
                        </div>
                        <div class="block-body">
                            <h3 class="heading heading-5 strong-500">
                                <a href="<?php echo base_url(); ?>home/gallery_view/<?php echo $row['encrypt_thread']; ?>">
                                    <?php echo $row['title']; ?>
                                </a>
                            </h3>
                            <p>
                                <?php echo substr($row['description'], 0, 150); ?>...
                            </p>
                        </div>
                        <div class="block-footer b-xs-top">
                            <div class="row align-items-center">
                                <div class="col-6 text-right">
                                    <a href="<?php echo base_url(); ?>home/gallery_view/<?php echo $row['encrypt_thread']; ?>"
                                       class="link link-sm link--style-2">
                                        <i class="fa fa-long-arrow-left"></i> <?php echo $this->lang->line('read_more'); ?>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <ul class="inline-links inline-links--style-3">
                                        <li>
                                            <i class="fa fa-calendar"></i>
                                            <?php
                                            $exp_date = explode(" ", $row['date_added']);
                                            echo $exp_date[0];
                                            ?>
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
            <?php //echo $this->pagination->create_links(); 
            ?>
        </div>
    </div>
</section>