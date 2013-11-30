<header class="modal-header">
    <h3>Forgot Password Form</h3>
    <p>Please enter your Email so we can send you an email to reset your password.</p>
</header>

<div class="modal-body">
	<?php echo form_open("admin/forgot_password" , array('role'=>'form'));?>

		<?php $this->load->view('templates/partials/alert'); ?>

		<div class="row">
			<div class="small-3 columns">
			  <label for="right-label" class="right inline">Email</label>
			</div>
			<div class="small-9 columns">
			  <input type="email" name="email" id="right-label" placeholder="Enter yout email" required>
			</div>
		</div>

		<div class="row">
			<div class="small-9 small-offset-3 columns ">
				<input type="submit" name="submit" value="Submit" class="button radius">
				<?php echo anchor('admin/login', 'Login', 'class="button radius"'); ?>
			</div>
		</div>

	<?php echo form_close(); ?>
</div>

<footer class="modal-footer">
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
    <p>
        <small>&copy; 2013 My Awesome CMS</small>
    <p>
</footer>