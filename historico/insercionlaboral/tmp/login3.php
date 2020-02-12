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

            $sql = "SELECT username, password FROM users WHERE username = ?";

            if($stmt = $mysqli->prepare($sql)){

		echo "dselect";
                // Bind variables to the prepared statement as parameters

                $stmt->bind_param("s", $param_username);

                

                // Set parameters

                $param_username = $username;

                

                // Attempt to execute the prepared statement

                if($stmt->execute()){
                    // Store result
                    $stmt->store_result();

                    // Check if username exists, if yes then verify password
                    if($stmt->num_rows == 1){                    

                        // Bind result variables

                        $stmt->bind_result($username, $hashed_password);

                        if($stmt->fetch()){

                            #if(password_verify($password, $hashed_password)){
                            if(md5($password)== $hashed_password){

                                /* Password is correct, so start a new session and

                                save the username to the session */

                                session_start();

                                $_SESSION['username'] = $username;      

                                header("location: mostrar_alumnos4.php");

                            } else{

                                // Display an error message if password is not valid

                                $password_err = 'Clave incorrecta';

                            }

                        }

                    } else{

                        // Display an error message if username doesn't exist

                        $username_err = 'No exite una cuenta para este usuario';

                    }

                } else{

                    echo "Oops! Algo falló, prueba otra vez más tarde";

                }

            }
            

            // Close statement

            $stmt->close();

        }
        // Close connection
        $mysqli->close();
    }
    ?>
    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceso encuestas insercion laboral FP</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper{ 
width:450px;
padding: 28px;
    padding-top: 28px;
margin: auto;
padding-top: 120px;		
	}
input[type=text], input[type=password] {
    width: 450px;
    padding: 1px 10px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

@media screen and (max-width : 600px) {
            .wrapper{

width: 100%;
} 
input[type=text], input[type=password] {
    width: 100%;
}
}
        </style>

    </head>

    <body>

        <div class="wrapper">

            <h2>Acceso encuestas insercion laboral FP</h2>

            <p>Introduce usuario y contrasena (el mismo que en la<a href='http://fpcualifica.tk:81/fct/insercionlaboral' target='blank'> aplicacion de FCTs</a></p>

            <form action="" method="post">

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

                    <input type="submit" class="btn btn-primary" value="Acceder">

                </div>


            </form>

        </div>    

    </body>

    </html>


