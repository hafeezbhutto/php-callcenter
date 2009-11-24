<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo ($html['title']); ?></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="<?php echo ('themes/'.THEME); ?>/css/default.css" rel="stylesheet" type="text/css" media="screen" />
<?php echo ($html['head']); ?>
</head>
<body>
<!-- start header -->
<div id="header">
	<div id="logo">
		<h1><img src="<?php echo ('themes/'.THEME); ?>/images/inline_logo.png"/></h1>
		<p>Call-Center</p>
	</div>
	<div id="menu">
		<ul>
			<li><a href="users.php?id=<?php echo ($_SESSION['users']['id']); ?>">[<?php echo ($_SESSION['users']['user']); ?>]</a></li>
			<li class="current_page_item"><a href="index.php">Dashboard</a></li>
			<li><a href="create.php">Create Call</a></li>
			<li class="last"><a href="logout.php">Logout</a></li>
		</ul>
	</div>
</div>
<!-- end header -->

<!-- start page -->
<div id="page">
	<!-- start sidebar -->
	<div id="sidebar">
		<ul>	
			<li id="search" style="background: none;">
				<form id="searchform" method="get" action="edit.php">
					<div>
						<input type="text" name="id" id="s" size="15" />
						<br />
						<input type="submit" value="Call ID" />
					</div>
				</form>
			</li>
			<li>
				<h2>Last Calls</h2>
				<ul>
					<?php
					require_once('inc/classes/call.php');
					$call = new call;
					$call->lastCalls();
					?>
				</ul>
			</li>
			<li>
				<h2>Last Customers</h2>
				<ul>
					<?php
					require_once('inc/classes/customer.php');
					$customer = new customer;
					$customer->lastCustomers();
					?>
				</ul>
			</li>

		</ul>
	</div>
	<!-- end sidebar -->
	
	<!-- start content -->
	<div id="content">
		<div class="post">