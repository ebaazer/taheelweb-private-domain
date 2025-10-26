<section class="slice--offset parallax-section parallax-section-xl b-xs-bottom custom-page-head" 
         style="background-image: url('<?php echo base_url('assets/frontend/' . $theme . '/images/dep.jpg'); ?>');">
    <div class="container">
        <div class="row py-3">
            <div class="col-lg-12">
                <h1 class="heading text-uppercase c-white">
                    <?php echo $department->name; ?>
                </h1>

                <span class="clearfix"></span>

                <div class="">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            <?php echo $department->name; ?>
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


<section class="slice--offset sct-color-1 pt-4 pb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="sidebar sidebar--style-2 department-sidebar">
                    <div class="sidebar-object">
                        <ul class="categories categories--style-2">
                            <?php foreach ($departments as $row) { ?>
                                <li class="<?php echo ($row['department_id'] == $department->department_id) ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url(); ?>home/department/<?php echo $row['department_id']; ?>">
                                        <?php echo $row['name']; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="appointment-btn">
                        </div>
                    </div>
                    <div class="sidebar-object text-center">
                        <p class="mb-1"><?php echo $this->lang->line('emergency_contact'); ?></p>
                        <h3>
                            <?php echo $this->frontend_model->get_frontend_settings('emergency_contact'); ?>
                        </h3>
                    </div>

                </div>
            </div>

            <div class="col-lg-9">
                <div class="block block-post">
                    <div class="block-body block-post-body b-xs-bottom mb-5 pb-5">
                        <p><?php echo $department->description; ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<section class="slice-sm sct-color-2 b-xs-top b-xs-bottom appointment-cta">
    <div class="container">
        <div class="px-4">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-9">
                        <div class="text-center text-lg-left">
                            <h1 class="heading heading-4 text-normal strong-500 c-white">
                                <?php echo $this->lang->line(''); ?>
                            </h1>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="py-4 text-center text-lg-right">
                            <a href="<?php echo base_url(); ?>home/contact_us" 
                               class="btn btn-styled btn-base-1 btn-outline btn-icon-left">
                                <i class="fa fa-send-o"></i><?php echo $this->lang->line('contact_us'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>