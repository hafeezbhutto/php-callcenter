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

$call = new call;
$info = $call->getInfo($_GET['id']);

$customer = new customer;
$info2 = $customer->getInfo($info['customer']);

if (isset($_POST['edit'])) {
	$duration = ($_POST['minutes'] * 60) + $_POST['seconds'];
	
	if ($customer->exists($_POST['mail'], false)) {
		$call->edit($_POST['id'], $_SESSION['users']['id'], $_POST['type'], $_POST['web'], $_POST['subject'], $duration, $_POST['comments'], $customer->MailToId($_POST['mail']));
	} else {
		$customer->create($_POST['name'], $_POST['mail'], $_POST['city'], $_POST['country'], $_POST['phone']);
		$call->edit($_POST['id'], $_SESSION['users']['id'], $_POST['type'], $_POST['web'], $_POST['subject'], $duration, $_POST['comments'], $customer->MailToId($_POST['mail']));
	}
	
	$msg = $call->printNiceLog(false);
	
	$_GET['id'] = $_POST['id'];
	$info = $call->getInfo($_GET['id']);
	$info2 = $customer->getInfo($info['customer']);
}

$html['title'] = 'Edit';
$html['head'] = '<script src="themes/'.THEME.'/js/jquery.js" type="text/javascript"></script>';

//theme header
include_once('themes/'.THEME.'/header.php');
?>
			<div class="title">
				<h2>Edit</h2>
				<p><small>Here you can edit the calls.</small></p>
			</div>
			<div class="entry">
			<?php echo ($msg); ?>
				<fieldset>
					<legend>Edit</legend>
					
					<?php if ($call->validId($_GET['id'])) {?>
					<form action="edit.php" method="post">
						<input type="hidden" name="id" value="<?php echo($_GET['id']); ?>"/>
						<label for="date">Date: <br><br><?php echo ($info['date']); ?></label><br><br>
						<label for="type">Type:</label><br><br>
						<select name="type">
							<option value="Incoming" <?php if ($info['type'] == 'Incoming') echo('selected'); ?> >Incoming</option>
							<option value="Outgoing" <?php if ($info['type'] == 'Outgoing') echo('selected'); ?>>Outgoing</option>
							<option value="Chat" <?php if ($info['type'] == 'Chat') echo('selected'); ?>>Chat</option>
						</select><br><br>
						
						<label for="web">Web:</label><br><br>
						<select name="web">
							<?php
							$web = new web;
							$web->select($info['web']);
							?>
						</select><br><br>
						
						<label for="subject">Subject:</label><br><br>
						<select name="subject">
							<?php
							$subject = new subject;
							$subject->select($info['subject']);
							?>
						</select><br><br>
						
						<label for="duration">Duration:</label><br><br>
						<select name="minutes">
							<?php
							$minutes = (int)($info['duration'] / 60);
							printTime($minutes);
							?>						
						</select>:
						<select name="seconds">
							<?php
							$seconds = (int) ($info['duration'] % 60);
							printTime($seconds);
							?>						
						</select> (minutes:seconds)
						<br><br>
						
						<label for="comments">Comments:</label><br><br>
						<textarea id="comments" type="text" name="comments"><?php echo ($info['comments']); ?></textarea><br><br>

						<label for="mail">E-mail:</label><br><br>
						<input type="text" id="mail" name="mail" value="<?php echo ($info2['mail']); ?>"/> <input type="button" value="Check" onclick="checkMail(mail.value)"/><br><br>
						
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
									$('#button').html('<input type="submit" value="Edit" name="edit"/>');
									$("#results").hide();
								}
								else {
									$("#results").show('slow');
									$("#button").html('<input type="submit" value="Edit" name="edit"/>');
									$("#results").html('<b>Valid mail, you can proceed to edit this call.</b>');
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
					<?php
					} else {
						echo ($call->printNiceLog(false));
					} 
					?>
				</fieldset>
			</div>
<?php
//theme footer
include_once('themes/'.THEME.'/footer.php');

//required includes at end
require_once('inc/bottom.php');
?>