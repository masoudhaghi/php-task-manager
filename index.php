<?php
include_once 'main.php';
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<!--
=====================================================================
======= Designed and Developed by Masoud Haghi ======================
=====================================================================
    __  ___                           __   __  __            __    _ 
   /  |/  /___ __________  __  ______/ /  / / / /___ _____ _/ /_  (_)
  / /|_/ / __ `/ ___/ __ \/ / / / __  /  / /_/ / __ `/ __ `/ __ \/ / 
 / /  / / /_/ (__  ) /_/ / /_/ / /_/ /  / __  / /_/ / /_/ / / / / /  
/_/  /_/\__,_/____/\____/\__,_/\__,_/  /_/ /_/\__,_/\__, /_/ /_/_/   
                                                   /____/             
                                                                   
=====================================================================
============================================= Masoud Haghi ==========
=====================================================================
-->
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
<title>Task Manager</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="description" content="" />
<meta name="keywords" content="" /> 
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="mobileoptimized" content="1" />
<meta http-equiv="cache-control" content="no-transform" />
<meta name="mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
</head>

<body>
<nav class="navbar navbar-dark bg-inverse" role="navigation" id="nav" style="border-radius:0;">
	<div class="container">
		<a href="index.php" class="navbar-brand pull-right" title="Task Manager">Task Manager</a>
	</div>
</nav>
<br />

<?php
if (isset($_GET['page']) && $_GET['page'] != "") {
	if (is_file("pages/". $_GET['page'] .".php")) {
		require_once("pages/". $_GET['page'] .".php");
	} else {
		require_once("pages/home.php");
	}
} else {
	require_once("pages/home.php");
}
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/js/bootstrap.min.js" integrity="sha384-ux8v3A6CPtOTqOzMKiuo3d/DomGaaClxFYdCu2HPMBEkf6x2xiDyJ7gkXU0MWwaD" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.5.3/jquery.timeago.min.js"></script>
<script src="https://use.fontawesome.com/8c58f400ad.js"></script>
<style>
.clickable {
	cursor:pointer;
}
</style>
<script>
$(document).ready(function() {
	$.ajaxSetup({ cache: false });
	$("time").timeago();
	// clickable
	$(".clickable").bind("click", function() {
		var href = $(this).attr("data-href");
		location.href = href;
	});
});
</script>
</body>

</html>