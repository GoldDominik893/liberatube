<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="/styles/login.css">
  </head>
  <body style="background-image: url(/images.php);">
    <div class="container">
      <div class="login-form">
        <h2>Login</h2>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <form id="keywordForm" method="post" action="loginsql.php" formtarget="_blank">
                    <label for="name">Username</label>
                    <input required class="input-field" type="text" id="name" name="name"  placeholder="Username" value=""><br>
                    <label for="pass">Password</label>
                    <input required class="input-field" type="password" id="pass" name="pass" placeholder="Password" value=""><br>
                    <input type="submit" value="Login">    
            </form>
            <hr>
            <a href="/">Go Back</a> · <a href="/signup.php">Create an account</a>
      </div>
    </div>
  </body>
</html>