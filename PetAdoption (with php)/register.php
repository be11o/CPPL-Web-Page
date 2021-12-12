<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
//if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
//    $password_err = "Passwords should match";
//}


// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err))
{
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        // Set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html>
<head>

<style>
	.mybox a{
		  position: absolute;
		  		padding-top: 0%;
                  bottom: 30px;
                  left: 50px;
		}
	.mybox2 a{
		  position: absolute;
                  bottom: 30px;
                  left: 450px;
		}
	.mybox3 a{
		position: absolute;
                  bottom: 30px;
                  left: 850px;

	}
	.mybox4{
		position: absolute;
                  bottom: 30px;
                  left: 1250px;
	}
	fieldset{background-color: aliceblue;}
</style>
	<title>Register Form</title>
</head>
<body>
	<div style="background-color: bisque;">
  <p style="text-align:center" ><img src="pts.png" ; width="250" height="150"></p>
</div> 
<left>

<form action="" method="post">
	<fieldset>
    <legend><b>PERSONAL INFORMATION :</b></legend>
<table>
<tr>
<td><b>Username:</b></td>
<td>
&nbsp;&nbsp;&nbsp;
<input type="text" name="username"
placeholder="Enter username here" required>
</td>
</tr>
<tr>
<td><b>Password:</b></td>
<td>
&nbsp;&nbsp;&nbsp;
<input type="password" name="password"
placeholder="Enter password here" required>
</td>
</tr>
<tr>
<td><b>Email:</b></td>
<td>
&nbsp;&nbsp;&nbsp;
<input type="email" name="mail" 
placeholder="Enter email here" required>
</td>
</tr>
<!--<tr>

<td><b>Gender:</b></td>
<td>
&nbsp;&nbsp;&nbsp;
<input type="radio" name="gender" required>Male
<input type="radio" name="gender" required>Female
<input type="radio" name="gender" required>Other
</td>
</tr>-->
<tr>
<td><b>Phone:</b></td>
<td>
&nbsp;&nbsp;&nbsp;
<select>
<option selected>+91</option>
<option>+44</option>
<option>+34</option>
<option>+27</option>
<option>+65</option>
</select>
<input type="number" name="phone" placeholder="*********" maxlength="9" required>
</td>
</tr>
<tr>
<td>
<input type ="submit" value="SIGN UP">
</td>
</tr>

</tr>
</left>
</table>
</fieldset>
</form>
<h2 style="color: #6151e2;">What pet should you get? Take our Quizzes and find out!</h2>
<h3 style="color: #6151e2;">Tap on the image of the respective animal to answer the quiz</h3>
<div class = "mybox">
		<a href="https://www.purina.co.uk/find-a-pet/cat-breeds/breed-selector">
		<img src="catty.jpg" alt="Bringing a dog home"
		width="200" height="200">
		</a>
</div>
<div class = "mybox2">
		<a href="https://dogtime.com/quiz/dog-breed-selector">
		<img src="dogo.jpg" alt="catty"
		width="200" height="200">
	</a>
</div>
<div class = "mybox3">
		<a href="https://www.hgtv.com/outdoors/landscaping-and-hardscaping/chicken-breeds-ideal-for-backyard-pets-and-eggs-pictures">
		<img src="chicky.jpg" alt="Bringing a dog home"
		width="200" height="200">
	</a>
</div>
<div class = "mybox4">
		<a href="https://www.proprofs.com/quiz-school/story.php?title=what-hamster-is-right-me">
		<img src="hamm.jpg" alt="Bringing a dog home"
		width="200" height="200">
		</a>
	</div>
</a>
</body>
</html>
