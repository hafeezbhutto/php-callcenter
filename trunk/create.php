<?php
//required includes at start
require_once('inc/top.php');

//others required includes only here
require_once('inc/session.php');
require_once('inc/functions/time.php');
require_once('inc/classes/call.php');
require_once('inc/classes/customer.php');
require_once('inc/classes/web.php');
require_once('inc/classes/subject.php');
require_once('inc/classes/country.php');

if (isset($_POST['create'])) {
	$call = new call;
	$customer = new customer;
	
	$duration = ($_POST['minutes'] * 60) + $_POST['seconds'];
	
	if ($customer->exists($_POST['mail'], false)) {
		$call->create($_SESSION['users']['id'], $_POST['type'], $_POST['web'], $_POST['subject'], $duration, $_POST['comments'], $customer->MailToId($_POST['mail']));
	} else {
		$customer->create($_POST['name'], $_POST['mail'], $_POST['city'], $_POST['country'], $_POST['phone']);
		$call->create($_SESSION['users']['id'], $_POST['type'], $_POST['web'], $_POST['subject'], $duration, $_POST['comments'], $customer->MailToId($_POST['mail']));
	}
	
	$msg = $call->printNiceLog(false);
}

$html['title'] = 'Create';
$html['head'] = '<script src="themes/'.THEME.'/js/jquery.js" type="text/javascript"></script>';

//theme header
include_once('themes/'.THEME.'/header.php');
?>
			<div class="title">
				<h2>Create</h2>
				<p><small>Here you can create new calls.</small></p>
			</div>
			<div class="entry">
				<fieldset>
					<legend>Create</legend>
					<?php echo ($msg); ?>
					<form action="create.php" method="post">
						<label for="type">Type:</label><br><br>
						<select name="type">
							<option value="Incoming">Incoming</option>
							<option value="Outgoing">Outgoing</option>
							<option value="Chat">Chat</option>
						</select><br><br>
						
						<label for="web">Web:</label><br><br>
						<select name="web">
							<?php
							$web = new web;
							$web->select();
							?>
						</select><br><br>
						
						<label for="subject">Subject:</label><br><br>
						<select name="subject">
							<?php
							$subject = new subject;
							$subject->select();
							?>
						</select><br><br>
						
						<label for="duration">Duration:</label><br><br>
						<select name="minutes">
							<?php
							printTime();
							?>									
						</select>:
						<select name="seconds">
							<?php
							printTime();
							?>						
						</select> (minutes:seconds)
						<br><br>
						
						<label for="comments">Comments:</label><br><br>
						<textarea id="comments" type="text" name="comments"></textarea><br><br>

						<label for="mail">E-mail:</label><br><br>
						<input type="text" id="mail" name="mail" /> <input type="button" value="Check" onclick="checkMail(mail.value)"/><br><br>
						
						<script type="text/javascript">
						$(document).ready(function() {
							 $('#customer').hide();
							 //$('#button').hide();
						});
						
						function checkMail(mail) {
							if ($('#mail').val() == ""){
								alert('Empty mail');
								return 0;
							}
							
							$('#customer').hide();
							$.ajax({
							  type: "POST",
							  url: "mail.php",
							  //cache: false,
							  data: "mail=" + mail,
							  success: function(html){
								if (html == 'Invalid mail') {
									$('#customer').show('slow');
									$('#button').html('<input type="submit" value="Create" name="create"/>');
									$("#results").hide();
								}
								else {
									$("#results").show('slow');
									$("#button").html('<input type="submit" value="Create" name="create"/>');
									$("#results").html('<b>Valid mail, you can proceed to add this call.</b>');
								}
							  }
							});
						}
						</script>
						<div id="results"></div>
						<div id="customer">
							<fieldset>
							<p><b>The customer mail is new, so you may proceed to create the new customer also:</b></p>
							<label for="name">Full Name:</label><br><br>
							<input type="text" id="name" name="name" /><br><br>
							<label for="city">City:</label><br><br>
							<input type="text" id="city" name="city" /><br><br>
							<label for="country">Country:</label><br><br>
							<select name="country">
							<?php
							$country = new country;
							$country->select();
							?>
							</select><br><br>
							<label for="phone">Phone:</label><br><br>
							<input type="text" id="phone" name="phone" /><br><br>
							</fieldset>
						</div>
						<br><br>
						<div id="button"></div>
					</form>
					
				</fieldset>
			</div>
<?php
//theme footer
include_once('themes/'.THEME.'/footer.php');

//required includes at end
require_once('inc/bottom.php');
?>