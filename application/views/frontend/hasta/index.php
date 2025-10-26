<?php
if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    $source = $_SERVER['HTTP_X_FORWARDED_HOST'];
} else {
    $source = $_SERVER['HTTP_HOST'];
}
$client_id = explode(".", $source)[0];
$this->session->set_userdata('client_id', $client_id);

//$expiration_date = $this->db->get_where('settings', array('type' => 'expiration_date'))->row()->description;
//$curdate = date('Y-m-d');

$theme = $this->frontend_model->get_frontend_settings('theme');
$center_name = $this->frontend_model->get_frontend_settings('center_name');

$this->db->select('type, description');
$this->db->from('settings');
$this->db->where_in('type', ['website_status', 'system_name', 'system_email', 'center_type', 'client_id', 'expiration_date']);
$query = $this->db->get();

$settings = [];
foreach ($query->result() as $row) {
    $settings[$row->type] = $row->description;
}

$website_status = $settings['website_status'];
$system_name = $settings['system_name'];
$system_email = $settings['system_email'];
$center_type = $settings['center_type'];
$country_center = $settings['country_center'];
$client_id = $settings['client_id'];
$expiration_date = $settings['expiration_date'];
$curdate = date('Y-m-d');

$topbar_color = $this->db->get_where('frontend_settings', array('type' => 'topbar_color'))->row()->description;

//$client_id = $this->session->userdata('client_id');
//$client_id = "afac";
?>

<!doctype html>
<!--[if IE 7 ]>    <html lang="en-gb" class="isie ie7 oldie no-js"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en-gb" class="isie ie8 oldie no-js"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en-gb" class="isie ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<!--<![endif]-->
<!--<![endif]-->

<html lang="en">
    <head>
        <title><?php echo $page_title; ?> | <?php echo $center_name; ?></title>

        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
            WebFont.load({
                google: {
                    "families": [
                        "Tajawal:300,400,500,700,800,900",
                        "Poppins:300,400,500,600,700",
                        "Roboto:300,400,500,600,700"]},
                active: function () {
                    sessionStorage.fonts = true;
                }});
        </script>        

        <?php
        include 'metas.php';
        include 'stylesheets.php';
        ?>

        <style>
            .topbar.red-3 {
                background-color: <?php echo $topbar_color; ?>;
            }
        </style>



        <?php
        if ($client_id == 'hopecenterae') {
            ?>
            <style>
                .section-overlay.pink-2 {
                    background-color: rgb(3 23 172 / 13%);
                }
            </style>
            <?php
            $img_name = "480.png";
             $margin_img = 'margin-top: -70px;';
        } else {
            $img_name = "470.png";
            $margin_img = '';
        }
        ?>

    </head>

    <body>

        <script type="text/javascript">
            var baseurl = '<?php echo base_url(); ?>';
        </script>

        <?php
        if ($client_id == 'afac') {
            if ($page_name == 'booking_plan_step_1' || $page_name == 'booking_plan_step_2') {
                include $page_name . '.php';
            } else {
                ?>
                <div class="site_wrapper">

                    <?php
                    if ($expiration_date > $curdate) {
                        include 'navigation.php';
                    }
                    ?>            

                    <div class="clearfix"></div>

                    <?php include $page_name . '.php'; ?>

                    <?php
                    if ($expiration_date > $curdate) {
                        include 'footer.php';
                    } else {
                        
                    }
                    ?>        
                    <?php
                }
            } else {
                ?>

                <div class="site_wrapper">

                    <?php
                    if ($expiration_date > $curdate) {
                        include 'navigation.php';
                    }
                    ?>            

                    <div class="clearfix"></div>

                    <?php include $page_name . '.php'; ?>

                    <?php
                    if ($expiration_date > $curdate) {
                        include 'footer.php';
                    } else {
                        
                    }
                    ?>        


                <?php } ?>

                <!--end section-->
                <div class="clearfix"></div>

                <a href="javascript:;" class="scrollup dark"></a>

            </div>
            <!-- end site wraper --> 

            <!-- ============ JS FILES ============ --> 

            <?php include 'javascripts.php'; ?>

    </body>
</html>
