<?php 
	  
	// start session.
	session_start(); 

	if (!isset($_SESSION['user_name'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: ../login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['user_name']);
		unset($_SESSION['user_id']);
		unset($_SESSION['role_id']);
		unset($_SESSION['user_name']);
		unset($_SESSION['full_name']);
		unset($_SESSION['success']);
		header("location: ../login.php");

		return;
	}

	// Connect to database.
	include("connect.php");
?>