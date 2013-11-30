<header class="modal-header">
    <h3>Login Form</h3>
    <p>Please log in with your credentials.</p>
</header>

<div class="modal-body">
	<?php echo form_open("admin/login" , array('class'=>'custom','role'=>'form'));?>

		<div class="row">
			<div class="small-3 columns">
			  <label for="right-label" class="right inline">Email</label>
			</div>
			<div class="small-9 columns">
			  <input type="email" name="email" id="right-label" placeholder="Enter yout email" required>
			</div>
		</div>

		<div class="row">
			<div class="small-3 columns">
			  <label for="right-label" class="right inline">Password</label>
			</div>
			<div class="small-9 columns">
			  <input type="password" name="password" id="right-label" placeholder="Enter yout password" required>
			</div>
		</div>

		<div class="row">
			<div class="small-9 small-offset-3 columns ">
				<label class="checkbox">
					<?php echo form_checkbox('Remember me', '1', FALSE, 'id="remember"');?>
					<span>Remember me</span>
				</label>
			</div>
		</div>

		<br>

		<div class="row">
			<div class="small-9 small-offset-3 columns ">
				<input type="submit" name="submit" value="Login" class="button radius">
				<?php echo anchor('admin/forgot_password', 'Forgot Password', 'class="button radius"'); ?>
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