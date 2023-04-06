<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="/styles/login.css">

  </head>
  <body style="background-image: url(/images.php);">
    <div class="container">
      <div class="login-form">
        <h2>Sign up</h2>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="search-form-container">
            <form id="keywordForm" method="post" action="signupsql.php" formtarget="_blank">
                    <label for="name">Username</label>
                    <input autocomplete="off" required class="input-field" type="text" id="name" name="name"  placeholder="Username" value=""><br>
                    <label for="pass">Password</label>
                    <input autocomplete="off" required class="input-field" type="password" id="pass" name="pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 16 or more characters" placeholder="Password" value=""><br>
                <input class="btn-submit" type="submit" name="submit" value="Login">    
            </form>
            <div id="message">
  <h3>Password must contain the following:</h3>
  <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
  <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
  <p id="number" class="invalid">A <b>number</b></p>
  <p id="length" class="invalid">Minimum <b>16 characters</b></p>
</div>
</div>	
<script src="/scripts/password_validator.js"></script>
            <hr>
            <a href="/">Go Back</a> · <a href="/login.php">Login instead</a>
      </div>
    </div>
  </body>
</html>