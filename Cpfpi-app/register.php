<?php
// Include config file
//require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cpfpi register page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Cpfpi crm" name="description">
    <meta content="Cpfpi crm" name="author">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
  
    <link rel="preconnect" href="https://fonts.gstatic.com">
   
</head>
<body>
  <div class="register-page">
    <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        
                      <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-3">
                                        <h5 class="text-primary account-text">Create an account</h5>
                                        
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                      </div>
                               
                            
                       
                        <div class="card-body pt-0">
                            <div class="text-center">
                                <a href="/">
                                    <div class="avatar-md profile-user-wid mb-2">
                                       
                                            <img src="images/CPFPI- Logo.png" alt=""  class="img-fluid">
                                       
                                    </div>
                                </a>
                            </div>  
                            <div class="p-2">
                                <form class="needs-validation" novalidate="" action="/">
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">First Name</label>
                                        <input type="email" class="form-control" id="useremail" placeholder="Enter First Name" required="">
                                        <div class="invalid-feedback">
                                            Please Enter First Name
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">Last  Name</label>
                                        <input type="email" class="form-control" id="useremail" placeholder="Enter Last Name" required="">
                                        <div class="invalid-feedback">
                                            Please Enter Last Name
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="useremail" placeholder="Enter email" required="">
                                        <div class="invalid-feedback">
                                            Please Enter Email
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Enter username" required="">
                                        <div class="invalid-feedback">
                                            Please Enter Username
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="userpassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="userpassword" placeholder="Enter password" required="">
                                        <div class="invalid-feedback">
                                            Please Enter Password
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userpassword" class="form-label">Confirm Password </label>
                                        <input type="password" class="form-control" id="userpassword" placeholder="Enter password (Confirm)" required="">
                                        <div class="invalid-feedback">
                                            Please Enter Confirm Password
                                        </div>
                                    </div>
                                    <div class="mt-4 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                                    </div>

                                  
                                    
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>Already have an account ? <a href="login.php" class="fw-medium text-primary"> Login</a> </p>
                           
                        </div>
                    </div>

                </div>
            </div>
    </div>
  </div>  
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</html>