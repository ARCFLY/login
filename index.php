<?php
    include('dbconnect.php');
    $error = array();

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $cpassword = mysqli_real_escape_string($connection, $_POST['cpassword']);

    // hooson baigaa talbariig shalgah
    if(!empty($name) && !empty($email) && !empty($password) && !empty($cpassword)){
        // email helbertei bichigdsen esehiig shalgah
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error['email_type_wrong'] = "Email buruu bn";
        }
        // repeat password taarj bga esehiig shalgah
        if($password !== $cpassword){
            $error['password_not_match'] = "Password taarahgui bn";
        }

        $query = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($connection, $query);

        // ogodliin sand mail davhtsaj baigaa esehiig shalgah
        if(mysqli_num_rows($res) > 0){
            $error['email_exist'] = 'Ene mail deer ali hediin burtgel uussen bn';
        }

        // aldaa baihgui tohioldold ogodliin san ruu ogogdloo oruulah
        if(count($error) === 0){
            $insert_data = "insert into users(username, email, password) values('$name', '$email', '$password');";
            $id_insert = mysqli_query($connection, $insert_data);
            if($id_insert){
                // ogogdol orson tohioldold welcome.php ruu shiljih
                header('location: welcome.php');
            } else {
                $error['insert_data_error'] = "Database error";
            }
        }

    } else {
        $error['empty'] = "Hooson talbar uldeej bolohgui!";
    }
}
    // aldaanuudiig hevlej haruulah
    if(count($error) >= 1){
        foreach($error as $showerror){
            echo $showerror . '<br>';
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Weekly Coding Challenge #1: Sign in/up Form</h2>
<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="#">
			<h1>Create Account</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>or use your email for registration</span>
			<input type="text" placeholder="Name" />
			<input type="email" placeholder="Email" />
			<input type="password" placeholder="Password" />
			<button>Sign Up</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="#">
			<h1>Sign in</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>or use your account</span>
			<input type="email" placeholder="Email" />
			<input type="password" placeholder="Password" />
			<a href="#">Forgot your password?</a>
			<button>Sign In</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start journey with us</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>

<script src="js.js"></script>
</body>
</html>