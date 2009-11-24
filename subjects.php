<?php
//required includes at start
require_once('inc/top.php');

//others required includes only here
require_once('inc/session.php');
require_once('inc/classes/subject.php');

$subject = new subject;

if (isset($_POST['subject'])) {
	$subject->create($_POST['subject']);
	$msg = $subject->printNiceLog(false);
}

if (isset($_POST['delete'])) {
	$subject->deleteSelected();
	$msg = $subject->printNiceLog(false);
}

if ((isset($_POST['edit'])) && (isset($_POST['id']))) {
	$subject->edit($_POST['id'], $_POST['edit']);
	$msg = $subject->printNiceLog(false);
}

$html['title'] = 'Subjects';

//theme header
include_once('themes/'.THEME.'/header.php');
?>
			<div class="title">
				<h2>Subjects</h2>
				<p><small>Manage the subjects.</small></p>
			</div>
			<div class="entry">
			<p><?php echo ($msg); ?></p>
				<?php if (isset($_GET['edit'])) { ?>
				<fieldset>
					<legend>Edit</legend>
					<form action="subjects.php" method="post">
						<label for="edit">Subject name:</label><br><br>
						<input type="text" id="edit" name="edit" value="<?php echo($subject->idToName($_GET['edit'])); ?>"/><br><br>
						<input type="hidden" name="id" value="<?php echo($_GET['edit']); ?>"/>
						<input type="submit" value="Edit"/>
					</form>
				</fieldset>
				<?php } ?>
				<fieldset>
					<legend>Create</legend>
					<form action="subjects.php" method="post">
						<label for="subject">Subject name:</label><br><br>
						<input type="text" id="subject" name="subject" /><br><br>
						<input type="submit" value="Create"/>
					</form>
				</fieldset>
				<fieldset>
					<legend>Subjects</legend>
					<form action="subjects.php" method="post">
					<table id="table-1" summary="tables">
						<thead>
							<tr>
								<th scope="col"></th>
								<th scope="col">Subject</th>
								<th scope="col">Edit</th>
							</tr>
						</thead>
						<tbody>
						<?php $subject->show(); ?>
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