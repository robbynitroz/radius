<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>

		<link type="text/css" rel="stylesheet" href='/assets/css/bootstrap.min.css'/>
		<link type="text/css" rel="stylesheet" href="/assets/css/custom.css">
		<title>Edit defaults</title>

		<script src="/assets/js/jquery-1.10.2.js"></script>
		<script src="/assets/js/bootstrap.min.js"></script>

		<style>
			@import url(http://fonts.googleapis.com/css?family=Roboto);

			/****** LOGIN MODAL ******/
			.loginmodal-container {
				padding: 30px;
				max-width: 350px;
				width: 100% !important;
				background-color: #F7F7F7;
				margin: 0 auto;
				border-radius: 2px;
				box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
				overflow: hidden;
				font-family: roboto;
			}

			.loginmodal-container h1 {
				text-align: center;
				font-size: 1.8em;
				font-family: roboto;
			}

			.loginmodal-container input[type=submit] {
				width: 100%;
				display: block;
				margin-bottom: 10px;
				position: relative;
			}

			.loginmodal-container input[type=text], input[type=password] {
				height: 44px;
				font-size: 16px;
				width: 100%;
				margin-bottom: 10px;
				-webkit-appearance: none;
				background: #fff;
				border: 1px solid #d9d9d9;
				border-top: 1px solid #c0c0c0;
				/* border-radius: 2px; */
				padding: 0 8px;
				box-sizing: border-box;
				-moz-box-sizing: border-box;
			}

			.loginmodal-container input[type=text]:hover, input[type=password]:hover {
				border: 1px solid #b9b9b9;
				border-top: 1px solid #a0a0a0;
				-moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
				-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
				box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
			}

			.loginmodal {
				text-align: center;
				font-size: 14px;
				font-family: 'Arial', sans-serif;
				font-weight: 700;
				height: 36px;
				padding: 0 8px;
				/* border-radius: 3px; */
				/* -webkit-user-select: none;
				  user-select: none; */
			}

			.loginmodal-submit {
				/* border: 1px solid #3079ed; */
				border: 0px;
				color: #fff;
				text-shadow: 0 1px rgba(0,0,0,0.1);
				background-color: #4d90fe;
				padding: 17px 0px;
				font-family: roboto;
				font-size: 14px;
				/* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
			}

			.loginmodal-submit:hover {
				/* border: 1px solid #2f5bb7; */
				border: 0px;
				text-shadow: 0 1px rgba(0,0,0,0.3);
				background-color: #357ae8;
				/* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
			}

			.loginmodal-container a {
				text-decoration: none;
				color: #666;
				font-weight: 400;
				text-align: center;
				display: inline-block;
				opacity: 0.6;
				transition: opacity ease 0.5s;
			}

			.login-help{
				font-size: 12px;
			}
		</style>

	</head>
	<body>

		<div style="outline: 0;" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="loginmodal-container">
					<h1>Login to Your Account</h1><br>
					<form method='POST'>
						<input type="text"     name="user"  placeholder="Username">
						<input type="password" name="pass"  placeholder="Password">
						<input type="submit"   name="login" class="login loginmodal-submit" value="Login">
					</form>
					<?php
//						if( !empty($this->session->flashdata('change_pass_success'))) {
//							echo '<div class="alert alert-success">
//								<strong>Success! </strong> Password successfully changed</div>';
//						}
//
//						if( !empty($this->session->flashdata('wrong_credentials'))) {
//							echo '<div class="alert alert-danger">
//								<strong>Warning! </strong> Wrong Username or Password.</div>';
//						}
					?>
				</div>
			</div>
		</div>

	</body>
</html>