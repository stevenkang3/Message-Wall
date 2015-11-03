<?php session_start();
require_once('new-connection.php');


if(isset($_POST['action']) && $_POST['action'] == "register")
{
  $_SESSION['first_name'] = $_POST['first_name'];
  $_SESSION['errors'] = array();
  if(empty($_POST['first_name']))
  {
    $_SESSION['errors'][] = "First name is required.";
  }
  if(empty($_POST['last_name']))
  {
    $_SESSION['errors'][] = "Last Name is required.";
  }
  if(empty($_POST['email']))
  {
    $_SESSION['errors'][] = "Email is required.";
  }
  if(empty($_POST['password']))
  {
    $_SESSION['errors'][] = "Password is required.";
  }
  if(strlen($_POST['password'])< 6)
  {
    $_SESSION['errors'][] = "Password must be at least 6 characters";
  }
  if (preg_match('#[0-9]#', $_POST['first_name']) || preg_match('#[0-9]#', $_POST['last_name']))
  {
      $_SESSION['errors'][] = "Your name can not contain numbers";
  }
  if ($_POST['password'] !== $_POST['confirm'])
  {
    $_SESSION['errors'][] = "Passwords do not match.";
  }
  if(count($_SESSION['errors']) > 0 )
  {
    header('location: index.php');
    die();
  }
  else
  {
        $email = ($_POST['email']);
        $password = ($_POST['password']);
        $encrypted_password = md5($password);
        $query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at)
                VALUES('{$_POST['first_name']}', '{$_POST['last_name']}','{$email}','{$encrypted_password}',NOW(), NOW())";
          if(run_mysql_query($query))
          {
              $_SESSION['message'] = "User successfully created";
              header('Location: index.php');
              die();
          }
          else
          {
          $_SESSION['errors'][] = "Registration unsuccessful";
          header('Location: index.php');
          die();
          }
  }
}



if(isset($_POST['login']) && $_POST['login'] == "login")
{
  login_user($_POST);
}

function login_user($post)
{
  $password = md5($_POST['passwords']);
  $email = ($_POST['emails']);
  $query = "SELECT * FROM users WHERE users.password = '{$password}'
            AND users.email ='{$email}'";
  $user = fetch($query);
  if(count($user)>0)
  {
    $_SESSION['user'] = $user;
    $_SESSION['user_id'] = $user[0]['id'];
    $_SESSION['first_name'] = $user[0]['first_name'];
    $_SESSION['email'] = $user[0]['email'];
    $_SESSION['password'] = $user[0]['password'];
    $_SESSION['logged_in'] = true;
    header('location: success.php');
    die();
  }
  else
  {
    $_SESSION['errors'][]= "Couldn't log in";
    header('location: index.php');
    die();
  }
}

//restart **************
    if(isset($_POST['restart']))
    {
      session_destroy();
      header('Location: index.php');
      exit();
    }
//log off**************
    if(isset($_POST['logoff']) && $_POST['logoff'] == "logoff")
    {
      session_destroy();
      header('Location: index.php');
      exit();
    }

//posting**************
if(isset($_POST['postamessage']) && ($_POST['postamessage']) != null)
{
  $query1 = "INSERT INTO messages (message, created_at, updated_at, users_id)
          VALUES('{$_POST['postamessage']}',NOW(), NOW(), '{$_SESSION['user_id']}')";
        if(run_mysql_query($query1))
        {
            $_SESSION['message'] = "Post successfully created";
            // $_SESSION['message_id'] = $message[0]['id'];
            header('Location: success.php');
            die();
        }
        else
        {
          $_SESSION['message'] = "Must write a message";
            header('Location: success.php');
            die();
        }
}


//comment ***************



if(isset($_POST['comments']) && (!empty($_POST['comments'])))
{
  $query = "INSERT INTO comments (comment, created_at, updated_at, messages_id, users_id)
          VALUES('{$_POST['comments']}',NOW(), NOW(), '{$_POST['message_id']}', '{$_SESSION['user_id']}')";
          if(run_mysql_query($query))
          {
            $_SESSION['comment'] = "Commented successfully";
            header('Location: success.php');
            die();
          }
          else
          {
          $_SESSION['comment'] = "Didn't comment";
          header('Location: success.php');
          die();
          }
}
// else
// {
//     $_SESSION['comment'] = "Must write a comment";
//     header('Location: success.php');
//     die();
// }
// if(isset($_POST['action']) && $_POST['action'] =="d_comment"]']))





// DELETE COMMENTS ***************
if(isset($_POST['action']) && $_POST['action'] == "d_comment")
  {
  $comment_id = ($_POST['delete_comment']);
  $d_comment = "DELETE FROM comments WHERE comments.id = $comment_id";
  if(run_mysql_query($d_comment))
  {
      header('Location: success.php');
      $_SESSION['comment'] = "Deleted Comment";
      die();
  }
}
//
 // DELETE MESSAGE*************
 if(isset($_POST['action']) && $_POST['action'] == "delete")
   {
   $delete_id = ($_POST['delete_message']);
   $delete = "DELETE FROM messages WHERE messages.id = $delete_id";
   if(run_mysql_query($delete))
   {
       header('Location: success.php');
       $_SESSION['comment'] = "Deleted Message";
       die();
   }
 }

?>
