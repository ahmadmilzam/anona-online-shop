<?php if ($this->session->flashdata('message')):?>
    <div data-alert class="alert-box success radius">
        <a href="#" class="close">&times;</a>
        <h5>Well done!</h5>
        <ul class="alert-message">
            <?php echo $this->session->flashdata('message');?>
        </ul>
    </div>
<?php endif;?>

<?php if ($this->session->flashdata('error')):?>
    <div data-alert class="alert-box alert radius">
        <a href="#" class="close">&times;</a>
        <h5>Oh snap! You got an error!</h5>
        <ul class="alert-message">
            <?php echo $this->session->flashdata('error');?>
        </ul>
    </div>
<?php endif;?>

<?php if ($this->session->flashdata('info')):?>
    <div data-alert class="alert-box radius">
        <a href="#" class="close">&times;</a>
        <h5>Heads up!</h5>
        <ul class="alert-message">
            <?php echo $this->session->flashdata('info');?>
        </ul>
    </div>
<?php endif;?>

<?php if(function_exists('validation_errors') && validation_errors() != ''): ?>
    <div data-alert class="alert-box alert radius">
        <a href="#" class="close">&times;</a>
        <h5>Oh snap! You got an error!</h5>
        <ul class="alert-message">
            <?php echo validation_errors();?>
        </ul>
    </div>
<?php endif;?>

<?php if(function_exists('display_errors') && display_errors() != ''): ?>
    <div data-alert class="alert-box alert radius">
        <a href="#" class="close">&times;</a>
        <h5>Oh snap! You got an error!</h5>
        <ul class="alert-message">
            <?php echo display_errors();?>
        </ul>
    </div>
<?php endif;?>