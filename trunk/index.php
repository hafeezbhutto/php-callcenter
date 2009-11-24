<?php
//required includes at start
require_once('inc/top.php');

//others required includes only here
require_once('inc/session.php');
require_once('inc/classes/user.php');

$html['title'] = 'Dashboard';
$html['head'] = '
<style type="text/css">
div.img
{
  margin: 2px;
  border: 1px solid #ccc;
  height: auto;
  width: auto;
  float: left;
  text-align: center;
}	
div.img img
{
  display: inline;
  margin: 3px;
  border: 1px solid #ffffff;
}
div.desc
{
  text-align: center;
  font-weight: normal;
  width: 120px;
  margin: 2px;
}
</style>
';
//theme header
include_once('themes/'.THEME.'/header.php');
?>
			<div class="title">
				<h2>Welcome to the Dashboard!</h2>
				<p><small></small></p>
			</div>
			<div class="entry">
				<!--<p><strong>Packend</strong>, a free, opensource backend solution</p>-->
			<div class="img">
				<a href="create.php"><img src="<?php echo ('themes/'.THEME); ?>/images/create.png" alt="Create Call"/></a>
				<div class="desc"><a href="create.php">Create Call</a></div>
			</div>
			<div class="img">
				<a href="calls.php"><img src="<?php echo ('themes/'.THEME); ?>/images/calls.png" alt="Calls"/></a>
				<div class="desc"><a href="calls.php">Calls</a></div>
			</div>
			<div class="img">
				<a href="customers.php"><img src="<?php echo ('themes/'.THEME); ?>/images/customers.png" alt="Customers"/></a>
				<div class="desc"><a href="customers.php">Customers</a></div>
			</div>
			<div class="img">
				<a href="webs.php"><img src="<?php echo ('themes/'.THEME); ?>/images/webs.png" alt="Webs"/></a>
				<div class="desc"><a href="webs.php">Webs</a></div>
			</div>
			<div class="img">
				<a href="subjects.php"><img src="<?php echo ('themes/'.THEME); ?>/images/subjects.png" alt="Subjects"/></a>
				<div class="desc"><a href="subjects.php">Subjects</a></div>
			</div>
			
			<div class="img">
				<a href="search.php"><img src="<?php echo ('themes/'.THEME); ?>/images/search.png" alt="Search"/></a>
				<div class="desc"><a href="search.php">Search</a></div>
			</div>
			
			<!--
			<div class="img">
				<a href="users.php"><img src="<?php echo ('themes/'.THEME); ?>/images/users.png" alt="Users"/></a>
				<div class="desc"><a href="users.php">Users</a></div>
			</div>

			<div class="img">
				<a href="options.php"><img src="<?php echo ('themes/'.THEME); ?>/images/options.png" alt="Options"/></a>
				<div class="desc"><a href="options.php">Options</a></div>
			</div>-->	
			</div>
<?php
//theme footer
include_once('themes/'.THEME.'/footer.php');

//required includes at end
require_once('inc/bottom.php');
?>