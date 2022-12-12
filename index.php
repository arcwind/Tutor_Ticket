<?php
	require_once "config.php";
	session_start();
   
   // Check if the user is already logged in, if yes then redirect him to welcome page
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: tutor_tickets.php");
    exit;
	}
	//
	$username = $password = "";
	$username_err = $password_err = $login_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT user_id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
						
                        if($password == $hashed_password){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            $_SESSION['authorized'] = TRUE;
                            // Redirect user to welcome page
                            header("location: tutor_tickets.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($db);
}
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <title>Tutor Tickets</title>
    <link rel="stylesheet" href="css/styles.css">
<link rel="icon" href="img/favicon-16x16.png" type="image/png">
</head>

<body>
        <header>
			<p><a class="homebtn" href="/">TTHQ</a></p>
        </header>

        <main>
			<nav class="crum c2">
			<a class="navsprite cs" title="Tutor Ticket Login" href="index.php"></a> > <span>Tutor Tickets</span>
			</nav>

			<div>
			
			   <section class="tabulous">
			
				<form name"Login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
						<input type="text" name="username" placeholder="Username"  <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?> required><br />
						<input type="password" name="password" placeholder="Password" <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?> required><br />
						
						<?php 
						if(!empty($login_err)){
							echo '<div class="red bold">' . $login_err . '</div>';
						}?>
			
				   <button type="submit" name="Submit">Login</button>
				</form>
				</section>
			</div>
        </main>
</body>
</html>

