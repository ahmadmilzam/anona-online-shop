<!DOCTYPE html>
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en" >
<![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en" >
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <meta name="author" content="Ahmad Milzam">
    <title><?php echo $template['title']; ?></title>

    <?php
        foreach ($css as $css) {
            echo css($css);
        }
    ?>
    <script src="<?php echo base_url('assets/js/custom.modernizr.js');?>"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
</head>

<body>

    <!-- Sticky Footer -->
    <div id="wrap">

        <!-- Header -->
        <?php $this->template->load_view('partials/adminnav'); ?>
        <?php $this->template->load_view('partials/alert'); ?>
        <!-- //Header -->
        <br>
        <!-- dynamic content goes here -->
        <?php echo $template['body']; ?>
        <!-- end dynamic content -->

    </div>

    <div id="footer">

        <!-- Footer -->
        <footer class="row">
            <div class="large-12 columns">
                <span class="text-muted">Ahmad Milzam's mini project. &copy; ahmadmilzam.com 2013.</span>
            </div>
        </footer>
        <!-- //Footer -->

    </div>
    <!-- //Sticky Footer -->

    <?php
        foreach ($js as $js) {
            echo js($js);
        }
    ?>
    <script>
        $(document).foundation();
    </script>

</body>

</html>