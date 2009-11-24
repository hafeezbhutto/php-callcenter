<?php
//required includes at start
require_once('inc/top.php');

//others required includes only here
require_once('inc/session.php');
require_once('inc/classes/call.php');

$call = new call;
if (isset($_POST['delete']))
	$call->deleteSelected();
$msg = $call->printNiceLog(false);

$html['title'] = 'Calls';
//theme header
include_once('themes/'.THEME.'/header.php');
?>
			<div class="title">
				<h2>Calls</h2>
				<p><small>All the calls.</small></p>
			</div>
			<div class="entry">
				<fieldset>
					<legend>Calls</legend>
					<?php echo ($msg); ?>
					<form action="calls.php" method="post">

					<table id="table-1" summary="tables">
						<thead>
							<tr>
								<th scope="col"></th>
								<th scope="col">ID</th>
								<th scope="col">Operator</th>
								<th scope="col">Web</th>
								<th scope="col">Subject</th>
								<th scope="col">Duration</th>
								<th scope="col">Customer</th>
								<th scope="col">Date</th>
								<th scope="col">Edit</th>
							</tr>
						</thead>
						<tbody>
						<?php $call->show($_GET['p']); ?>
						</tbody>
					</table>
					<p style="margin-left:50px;">References: <font color="red">Incoming</font>, <font color="green">Outgoing</font>, <font color="blue">Chat</font></p>
					<p align="right">Pages: <?php $call->printPages($_GET['p']); ?></p>
					<input type="button" onclick="document.location='create.php'" value="Create"/>
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