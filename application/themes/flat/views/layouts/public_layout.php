<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php echo $template['title']; ?></title>
        <script src="<?php echo base_url('assets/js/modernizr.js') ;?>"></script>
        <!-- //load stylesheet -->
        <?php $this->carabiner->display('main_css'); ?>
        <?php $this->carabiner->display('local_css'); ?>

        <!-- //load stylesheet -->
        <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    </head>
    <body>

        <!-- Head -->
        <?php echo $this->template->load_view('partials/public_navbar'); ?>
        <?php echo $this->template->load_view('partials/public_header'); ?>
        <?php echo $this->template->load_view('partials/public_subnav'); ?>
        <!-- //Head -->

        <!-- Body -->
        <?php echo $template['body']; ?>
        <!-- //Body -->

        <!-- Tail -->
        <?php echo $this->template->load_view('partials/public_footer'); ?>
        <!-- //Tail -->

        <!-- //load script -->
        <?php $this->carabiner->display('main_js'); ?>
        <?php $this->carabiner->display('local_js'); ?>
        <!-- //load script -->
    </body>
</html>
