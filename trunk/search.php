<?php
//required includes at start
require_once('inc/top.php');

//others required includes only here
require_once('inc/session.php');
require_once('inc/functions/time.php');
require_once('inc/classes/user.php');
require_once('inc/classes/web.php');
require_once('inc/classes/subject.php');

$html['title'] = 'Search';
$html['head'] .= '<script src="themes/'.THEME.'/js/jquery.js" type="text/javascript"></script>';
$html['head'] .= '<script src="themes/'.THEME.'/js/jquery-ui-1.7.2.custom.min.js" type="text/javascript"></script>';
$html['head'] .= '<link type="text/css" href="themes/'.THEME.'/css/ui-darkness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />';

//theme header
include_once('themes/'.THEME.'/header.php');
?>
			<div class="title">
				<h2>Search</h2>
				<p><small>Search by customer, type, date, etc.</small></p>
			</div>
			<div class="entry">
				<fieldset>
					<legend>Search</legend>
					<form action="calls.php" method="get">
					
						<script type="text/javascript">
							$(function(){
								$('#date1').datepicker({ dateFormat: 'yy-mm-dd' });
								$('#date2').datepicker({ dateFormat: 'yy-mm-dd' });
							});
						</script>
						<label for="date1">Date (leave blank for any date):</label><br><br>
						Betweeen <input type="text" id="date1" name="date1" value="<?php echo date('Y-m-d');  ?>"/>
						and <input type="text" id="date2" name="date2" value="<?php echo date('Y-m-d');  ?>"/>
						<br><br> 
					
						<label for="type">Type:</label><br><br>
						<select name="type">
							<option value="">Anyone</option>
							<option value="Incoming">Incoming</option>
							<option value="Outgoing">Outgoing</option>
							<option value="Chat">Chat</option>
						</select><br><br>
						
						<label for="web">Web:</label><br><br>
						<select name="web">
							<option value="">Anyone</option>
							<?php
							$web = new web;
							$web->select();
							?>
						</select><br><br>
						
						<label for="subject">Subject:</label><br><br>
						<select name="subject">
							<option value="">Anyone</option>
							<?php
							$subject = new subject;
							$subject->select();
							?>
						</select><br><br>

						<label for="mail">E-mail (leave blank for any e-mail):</label><br><br> 
						<input type="text" id="mail" name="mail" /><br><br>

						<label for="customer">Customer (leave blank for any customer):</label><br><br>
						<input type="text" id="customer" name="customer" /><br><br>
						
						<input type="submit" value="Search" name="search">
						</form>					
				</fieldset>
			</div>
<?php
//theme footer
include_once('themes/'.THEME.'/footer.php');

//required includes at end
require_once('inc/bottom.php');
?>