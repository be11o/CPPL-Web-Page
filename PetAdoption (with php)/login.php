<?php
//This script will handle login
session_start();

// check if the user is already logged in
//if(isset($_SESSION['username']))
//{
//    header("location: register.html");
//    exit;
//}
require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: adopt.html");   
                        }
                    }
                }
    }
}    

}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pet Adoption Site</title>
</head>

<body background="pets.png">
<div style="background-color:bisque">
  <p style="text-align:center" ><img src="pts.png" ; width="250" height="150"></p>
</div> 
<br>
	<center>
		<h2>Log In</h2>
		<div class="container">
		<form action="" method="post">
	    <label for="uname">
	    	<font face = "Lato" size= "4.5">
	    	<b>Username</b>
	    </label>
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <input type="text" placeholder="Enter Username" name="username" required>
	    <br><br>
	    <label for="psw"><b>Password</b></label>
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <input type="password" placeholder="Enter Password" name="password" required >
	    <br><br>
	    <button type="submit" >Submit</button>
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    Haven't Registered? <a href="register.html">Register Now </a>
		</form>
	  </div>
	</center>

<br><br><br><br><br><br><br><br><br><br><br>
<br><br>
<div style="background-color:rgb(228, 255, 192);"  float:left;>
      <p > <iframe  src="about.html" height="300" width=100% ></iframe>     </p> 
    </div>
<p style="text-align:center; font-size:15px">Designed by - Chrisanne Rebello 201096   </p>
</body>
</html>
