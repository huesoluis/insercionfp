<?php 
require_once 'php/config.php';
    // Define variables and initialize with empty values

    $username = $password = "";
    $username_err = $password_err = "";
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Check if username is empty

        if(empty(trim($_POST["username"]))){

            $username_err = 'Please enter username.';

        } else{

            $username = trim($_POST["username"]);

        }

        

        // Check if password is empty

        if(empty(trim($_POST['password']))){

            $password_err = 'Please enter your password.';

        } else{

            $password = trim($_POST['password']);

        }

        

        // Validate credentials

        if(empty($username_err) && empty($password_err)){

            // Prepare a select statement

            $sql = "SELECT username, password FROM users WHERE username =?";

            if($stmt = $mysqli->prepare($sql)){

		echo "dselect";
                // Bind variables to the prepared statement as parameters

		}
		else{
		
		echo "no hay stmt".$mysqli->error;
		}
	}
}
    ?>

     

    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <title>Login</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

        <style type="text/css">


            .wrapper{ width: 350px; padding: 20px; 
	width: 350px;
padding: 28px;
    padding-top: 28px;
margin: auto;
padding-top: 120px;		
	}

        </style>

    </head>

    <body>

        <div class="wrapper">

            <h2>Login</h2>

            <p>Please fill in your credentials to login.</p>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

                    <label>Username</label>

                    <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">

                    <span class="help-block"><?php echo $username_err; ?></span>

                </div>    

                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                    <label>Password</label>

                    <input type="password" name="password" class="form-control">

                    <span class="help-block"><?php echo $password_err; ?></span>

                </div>

                <div class="form-group">

                    <input type="submit" class="btn btn-primary" value="Login">

                </div>


            </form>

        </div>    

    </body>

    </html>


