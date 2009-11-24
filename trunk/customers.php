<?php
//required includes at start
require_once('inc/top.php');

//others required includes only here
require_once('inc/session.php');
require_once('inc/classes/customer.php');
require_once('inc/classes/country.php');

$customer = new customer;

if (isset($_POST['delete'])) {
	$customer->deleteSelected();
	$msg = $customer->printNiceLog(false);
}

if ((isset($_POST['edit'])) && (isset($_POST['id']))) {
	$customer->edit($_POST['id'], $_POST['name'], $_POST['mail'], $_POST['city'], $_POST['country'], $_POST['phone']);
	$msg = $customer->printNiceLog(false);
}

if (isset($_POST['create'])) {
	$customer->create($_POST['name'], $_POST['mail'], $_POST['city'], $_POST['country'], $_POST['phone']);
	$msg = $customer->printNiceLog(false);
}

$html['title'] = 'Customers';
$html['head'] = '<script src="themes/'.THEME.'/js/jquery.js" type="text/javascript"></script>';

//theme header
include_once('themes/'.THEME.'/header.php');
?>					<script type="text/javascript">
						$(document).ready(function() {
							 $('#create').hide();
						});
					</script>
			<div class="title">
				<h2>Customers</h2>
				<p><small>Manage the customers.</small></p>
			</div>
			<div class="entry">
			<p><?php echo ($msg); ?></p>
				<?php if ((isset($_GET['edit'])) && ($customer->validId($_GET['edit']))) {
					$info = $customer->getInfo($_GET['edit']);
				?>
				<fieldset>
					<legend>Edit</legend>
					<form action="customers.php" method="post">
						<label for="mail">E-mail:</label><br><br>
						<input type="text" id="mail" name="mail" value="<?php echo ($info['mail']); ?>"/><br><br>
						<label for="name">Full Name:</label><br><br>
						<input type="text" id="name" name="name" value="<?php echo ($info['name']); ?>"/><br><br>
						<label for="city">City:</label><br><br>
						<input type="text" id="city" name="city" value="<?php echo ($info['city']); ?>"/><br><br>
						<label for="country">Country:</label><br><br>
						<select name="country">
						<?php
						$country = new country;
						$country->select($info['country']);
						?>
						</select><br><br>
						<label for="phone">Phone:</label><br><br>
						<input type="text" id="phone" name="phone" value="<?php echo ($info['phone']); ?>"/><br><br>
						<input type="hidden" name="id" value="<?php echo($_GET['edit']); ?>"/>
						<input type="submit" value="Edit" name="edit"/>
					</form>
				</fieldset>
				<?php
				} else {
					echo ($customer->printNiceLog(false));
				}
				?>			
				<fieldset>
					<legend><a href="#" onclick="javascript:$('#create').toggle('slow');">Create</a></legend>
					<div id="create">
					<form action="customers.php" method="post">
						<label for="mail">E-mail:</label><br><br>
						<input type="text" id="mail" name="mail"/><br><br>
						<label for="name">Full Name:</label><br><br>
						<input type="text" id="name" name="name"/><br><br>
						<label for="city">City:</label><br><br>
						<input type="text" id="city" name="city"/><br><br>
						<label for="country">Country:</label><br><br>
						<select name="country">
						<?php
						$country = new country;
						$country->select();
						?>
						</select><br><br>
						<label for="phone">Phone:</label><br><br>
						<input type="text" id="phone" name="phone" value=""/><br><br>
						<input type="submit" value="Create" name="create"/>
					</form>
					</div>
				</fieldset>
				<fieldset>
					<legend>Customers</legend>
					<form action="customers.php" method="post">
					<table id="table-1" summary="tables">
						<thead>
							<tr>
								<th scope="col"></th>
								<th scope="col">Name</th>
								<th scope="col">E-Mail</th>
								<th scope="col">City</th>
								<th scope="col">Country</th>
								<th scope="col">Phone</th>
								<th scope="col">Edit</th>
							</tr>
						</thead>
						<tbody>
						<?php $customer->show($_GET['p']); ?>
						</tbody>
					</table>
					<p align="right">Pages: <?php $call->printPages($_GET['p']); ?></p>
					<input type="submit" value="Delete Selected"/>
					</form>
				</fieldset>
			</div>
<?php
//theme footer
include_once('themes/'.THEME.'/footer.php');

//required includes at end
require_once('inc/bottom.php');
?>