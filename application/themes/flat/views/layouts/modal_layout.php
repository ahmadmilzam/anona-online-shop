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
    <link rel="shortcut icon" href="<?php echo base_url('favicon.ico'); ?>" type="image/x-icon">
    <?php
        foreach ($css as $css) {
            echo css($css);
        }
    ?>
</head>
<body>

    <div class="modal">
        <?php $this->template->load_view('partials/alert'); ?>
        <div class="modal-dialog">
            <div class="modal-content">

                <?php echo $template['body']; ?>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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