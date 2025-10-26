<style>
    .picture-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        justify-items: center;
        grid-gap: 10px;
        grid-row-gap: 0px;
    }

    .grid-box img {

        height: 250px;
        width: 250px;
        border-radius: 50px;
    }

    .grid-box-large {
        grid-column: span 2;
        grid-row: span 2;
    }

    .grid-box-large img {
        width: 100%;
    }
</style>

<?php
$gallery_info = $this->frontend_model->get_gallery_info_by_id($gallery_id);

//$this->db->where('frontend_gallery_id', $row['frontend_gallery_id']);
//$this->db->order_by('frontend_gallery_image_id', 'DESC');
//$query = $this->db->get('frontend_gallery_image', $per_page, $this->uri->segment(4));
//$images = $query->result_array();
?>
<div class="single-album-area page-content-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="single-album-wrapper">
                    <div class="album-header" style="text-align: right;">
                        <h1 class="album-title">
                            <?php echo $gallery_info->title; ?>
                        </h1>
                        <span class="album-meta">
                            <?php echo $gallery_info->date_added; ?>
                        </span>
                        <p class="album-description">
                            <?php echo $gallery_info->description; ?>
                        </p>
                        <hr>
                    </div>

                    <div class="picture-grid" style="text-align: center; direction: rtl;">
                        <?php
                        //$map = directory_map($folder . '/gallery_images/' . $gallery_id);
                        $dir = '/mnt/taheelweb_volume/uploads/'. $this->session->userdata('client_id') .'/gallery_images/' . $gallery_id;
                        $map = scandir($dir);
                        
                        foreach ($map as $map_row => $value):

                            $type_file = explode(".", $value);

                            if ($type_file[1] == 'jpg' || $type_file[1] == 'png' || $type_file[1] == 'gif') {
                                ?>
                                <a href="<?php echo $folder; ?>/gallery_images/<?php echo $gallery_id; ?>/<?php echo $value; ?>"
                                   target="_blank">
                                    <div class="grid-box"><img
                                            style="padding: 12px; border-radius: 50px;"
                                            src="<?php echo $folder; ?>/gallery_images/<?php echo $gallery_id; ?>/<?php echo $value; ?>" />
                                    </div>
                                </a>

                                <?php
                            }
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="album-grid-pagination">
                    <nav aria-label="pagination">
                        <?php //echo $this->pagination->create_links();  ?>
                    </nav>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>