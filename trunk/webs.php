<?php
//required includes at start
require_once('inc/top.php');

//others required includes only here
require_once('inc/session.php');
require_once('inc/classes/web.php');

$web = new web;

if (isset($_POST['web'])) {
	$web->create($_POST['web']);
	$msg = $web->printNiceLog(false);
}

if (isset($_POST['delete'])) {
	$web->deleteSelected();
	$msg = $web->printNiceLog(false);
}

if ((isset($_POST['edit'])) && (isset($_POST['id']))) {
	$web->edit($_POST['id'], $_POST['edit']);
	$msg = $web->printNiceLog(false);
}

$html['title'] = 'Webs';

//theme header
include_once('themes/'.THEME.'/header.php');
?>
			<div class="title">
				<h2>Webs</h2>
				<p><small>Manage the webs.</small></p>
			</div>
			<div class="entry">
			<p><?php echo ($msg); ?></p>
				<?php if (isset($_GET['edit'])) { ?>
				<fieldset>
					<legend>Edit</legend>
					<form action="webs.php" method="post">
						<label for="edit">Web name:</label><br><br>
						<input type="text" id="edit" name="edit" value="<?php echo($web->idToName($_GET['edit'])); ?>"/><br><br>
						<input type="hidden" name="id" value="<?php echo($_GET['edit']); ?>"/>
						<input type="submit" value="Edit"/>
					</form>
				</fieldset>
				<?php } ?>
				<fieldset>
					<legend>Create</legend>
					<form action="webs.php" method="post">
						<label for="web">Web name:</label><br><br>
						<input type="text" id="web" name="web" /><br><br>
						<input type="submit" value="Create"/>
					</form>
				</fieldset>
				<fieldset>
					<legend>Webs</legend>
					<form action="webs.php" method="post">
					<table id="table-1" summary="tables">
						<thead>
							<tr>
								<th scope="col"></th>
								<th scope="col">Web</th>
								<th scope="col">Edit</th>
							</tr>
						</thead>
						<tbody>
						<?php $web->show(); ?>
						</tbody>
					</table>
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