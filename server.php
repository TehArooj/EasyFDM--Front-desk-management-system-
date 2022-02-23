<?php 
	session_start();

	// variable declaration
	$user_name = "";
	$full_name="";
	$email    = "";
	$errors = array(); 
	$_SESSION['success'] = "";

	// Connect with database.
	include("connect.php");
	
	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$full_name=mysqli_real_escape_string($db,$_POST['full_name']);
		$user_name = mysqli_real_escape_string($db, $_POST['user_name']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($full_name)) { array_push($errors, "Full Name is required"); }
		if (empty($user_name)) { array_push($errors, "user_name is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO app_user (role_id,full_name,user_name, email, password,active,created_by,created_on,updated_by,updated_on) 
					  VALUES(3, '$full_name','$user_name', '$email', '$password',1,1,now(),1,now())";
			$pass = mysqli_query($db, $query);

			$newid = 0;
			$query = "SELECT USER_ID FROM app_user where email = '$email'";
			$row = mysqli_query($db, $query);
			$obj = mysqli_fetch_object($row);
			$newid = $obj->USER_ID;

			$query = "INSERT INTO guest (NAME, EMAIL, ACTIVE, CREATED_BY, CREATED_ON, UPDATED_BY, UPDATED_ON) 
					  VALUES('$full_name', '$email', 1, $newid, now(), $newid,now() )";		  
        	$pass = mysqli_query($db, $query);

			header('location:  ../EasyFDM/login.php?signup=1');
		}

	}

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($email)) {
			array_push($errors, "Email is required*");
		}
		if (empty($password)) {
			array_push($errors, "Password is required*");
		}

		if (count($errors) == 0) {
			$password = md5($password);

			$query = "SELECT USER_ID, ROLE_ID, USER_NAME, FULL_NAME, ACTIVE, EMAIL FROM app_user WHERE ( upper(email) =upper('$email')) AND upper(password) = upper('$password') AND ACTIVE = 1";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
				$obj = mysqli_fetch_object($results);
				$_SESSION['user_id'] = $obj->USER_ID;
				$_SESSION['role_id'] = $obj->ROLE_ID;
				$_SESSION['user_name'] = $obj->USER_NAME;
				$_SESSION['full_name'] = $obj->FULL_NAME;
				$_SESSION['success'] = "You are now logged in";

				if ($obj->ROLE_ID == 3) {
					header('location:  ../EasyFDM/customer/index.php');
				}
				else {
					header('location:  ../EasyFDM/admin/index.php');
				}
			} else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}
?>