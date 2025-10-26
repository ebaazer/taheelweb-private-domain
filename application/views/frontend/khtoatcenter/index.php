<?php
if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    $source = $_SERVER['HTTP_X_FORWARDED_HOST'];
} else {
    $source = $_SERVER['HTTP_HOST'];
}
$client_id = explode(".", $source)[0];
$this->session->set_userdata('client_id', $client_id);

$folder = 'https://ft.taheelweb.com/uploads/' . $this->session->userdata('client_id');

$expiration_date = $this->db->get_where('settings', array('type' => 'expiration_date'))->row()->description;
$curdate = date('Y-m-d');

$theme = $this->frontend_model->get_frontend_settings('theme');
$center_name = $this->frontend_model->get_frontend_settings('center_name');

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

<html lang="en" dir="rtl">
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

    </head>

    <body>

        <script type="text/javascript">
            var baseurl = '<?php echo base_url(); ?>';
        </script>

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
            }
            ?>        

            <!--end section-->
            <div class="clearfix"></div>

            <a href="javascript:;" class="scrollup blue"></a>

        </div>
        <!-- end site wraper --> 

        <!-- ============ JS FILES ============ --> 

        <?php include 'javascripts.php'; ?>

    </body>
</html>