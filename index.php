<?php

require('./model/database.php');

global $db;
$message='';

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

$action = filter_input(INPUT_POST, 'action');

if(strcmp($action,"login")==0){
  $query = 'SELECT email,pass FROM user
              WHERE email = :email';
$statement = $db->prepare($query);
$statement->bindValue(":email", $email);
$statement->execute();
$user = $statement->fetch();
$statement->closeCursor();
if(strcmp($user["email"],$email)==0 && strcmp($user["pass"], $password)==0){
    $message='';
    #include './home/home.php';
    header("Location: http://localhost/book_apps/guitar_shop/home/home.php");
}else{
    $message='The email address or password combination doesnt exist';
}
}else if((strcmp($action,"register")==0)){

        $firstname = filter_input(INPUT_POST, 'firstName');
        $lastname = filter_input(INPUT_POST, 'lastName');
    
        $query = 'INSERT INTO user
                 (firstname, lastname, email, pass)
              VALUES
                 (:firstname, :lastname, :email, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstname', $firstname);
    $statement->bindValue(':lastname', $lastname);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $statement->closeCursor();
    $message='Registered Successfully';
    #header("Location: http://localhost/book_apps/ch05_guitar_shop/");
}else{
  $message='';
}

?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Sign-Up/Login Form</title>
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">


      <link rel="stylesheet" href="css/style.css">


</head>

<body>
<center><span style="text-align: center;"><h3><?php echo $message; ?><h3></span>
  <div class="form">
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Sign Up</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
      </ul>

      <div class="tab-content">
        <div id="signup">
        <h1>Welcome to Guitar Shop</h1>
          <h1>Sign Up for Free</h1>

          <form action="" method="post">
             <input type="hidden" name="action" value="register">
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name="firstName"/>
            </div>

            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off" name="lastName"/>
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off"  name="email"/>
          </div>

          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name="password"/>
          </div>

          <button type="submit" class="button button-block" name="submit" />Get Started</button>

          </form>

        </div>

        <div id="login">
          <h1>Welcome To Guitar Shop!</h1>

          <form action="" method="post">
            <input type="hidden" name="action" value="login">
            <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name="email" />
          </div>

          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name="password"/>
          </div>

          <p class="forgot"><a href="forgot_password.php">Forgot Password?</a></p>

          <button class="button button-block" type="submit" name="submit" />Log In</button>

          </form>

        </div>

      </div><!-- tab-content -->

</div> <!-- /form -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>
