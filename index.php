<?php session_start();?>
<?php
require_once('new-connection.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registration</title>
  </head>
  <style media="screen">

  body{
  background-image: url(http://previews.123rf.com/images/slobelix/slobelix0609/slobelix060900007/527383-fighters-vector-tiger-sign-in-background-Stock-Vector-ninja.jpg);
  }
  .container {
    margin: 0 auto;
    text-align: center;
    width : 400px;
    height: 600px;
    border: 1px solid black;

  }
  h2 {
    color:lightblue;
  }
  .error {
    color: red;
    font-weight: bold;
    font-family: monospace;
  }
  .success {
    color: lightgreen;
    font-weight: bold;
    font-family: sans-serif;
  }
  </style>


  <body>
    <div class="container">

      <br>
    <h2>CodingDojo Wall</h2>

    <h3>Register as a New Member</h3>

<?php
        if(isset($_SESSION['errors']))
        {
          foreach($_SESSION['errors'] as $error){
             echo "<p class='error'>- ".($error)."</p>";
            unset($_SESSION['errors']);
          }
          echo "<br>";
        }

        if(isset($_SESSION['message']))
        {
          echo "<p class='success'>".($_SESSION['message'])."</p>";
        }
?>
    <br>
    <form action="process.php" method="post">
    <input type="hidden" name="action" value="register">
    <label for="">  Email: </label>
    <input type="email" name="email" placeholder="John123@abc.com"><br><br>
    <label for="">  First Name: </label>
    <input type="text" name="first_name" value=""><br><br>
    <label for="">  Last Name: </label>
    <input type="text" name="last_name" value=""><br><br>
    <label for="">  Password: </label>
    <input type="password" name="password" placeholder="6 or more characters"><br><br>
    <label for="">  Confirm PW: </label>
    <input type="password" name="confirm" placeholder="confirm password"><br><br>
    <input type="submit" value="SUBMIT">
  </form>​<br><br>

    <h2>EXISTING MEMBER</h2>
    <form action="process.php" method="post">
    <input type="hidden" name="login" value="login">
    <label>Email: </label>
    <input type="email" name="emails"><br><br>
    <label>Password:</label>
    <input type="password" name="passwords">
    <input type="submit" value="LOGIN">
  </form><br>

  <div class="restart">​
    <form id="restart-form" action="process.php" method="post">​
      <input type="hidden" name="restart" value="restart_form" />​
      <input type="submit" value="Start Over">​
    </form>
    </div>


  </div>
  </body>
</html>
