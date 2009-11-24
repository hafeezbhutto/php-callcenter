<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Login</title>
<meta name="keywords" content="" />
<meta name="description" content="" />

<style type="text/css">
#logo {
	margin: auto;
	text-align: center;
}
</style>

</head>
<body>

<div style="margin-top:20px;margin-bottom:20px;margin-left:auto;margin-right: auto;width:300px;font-family: Arial,Helvetica,sans-serif;">
<div id="logo">
	<h1><img src="<?php echo ('themes/'.THEME); ?>/images/logo.gif"/></h1>
</div>

	<form action="login.php" method="post">
	<fieldset>
		<legend>Login</legend>
		<?php echo ($msg); ?>
		<div class="instructions">Enter your user and your password.</div><br>

		<span class="oneField">
			<label for="user">Username:</label><br>
			<input id="user" name="user" value="" size="" type="text">
			<span class="reqMark">*</span><br>
		</span>

		<span class="oneField">
			<label for="password">Password:</label><br>
			<input id="password" name="password" value="" size="" type="password">
			<span class="reqMark">*</span><br>
		</span>
		<br>
		<span class="oneField">
			<input id="rememberme" name="rememberme" value="yes" type="checkbox">
			<label for="rememberme"> Remember me</label>
		</span>		
		
		<br><br>
		<input value="Login!" class="required" type="submit">
	</fieldset>
	</form>
</div>
</body>
</html>