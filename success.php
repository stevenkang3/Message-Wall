<?php session_start();
require_once('new-connection.php');

if (isset($_SESSION['message']))
{
  echo $_SESSION['message'];
}
unset($_SESSION['message']);

if (isset($_SESSION['comment']))
{
  echo $_SESSION['comment'];
}
unset($_SESSION['comment']);




?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>CodingDojo Wall</title>
  </head>

<!-- *********** style *************** -->
  <style media="screen">

body {
  background-image: url(https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTY3qKRqCiSDGFnDWwssk51-j6mjvHFc6fLe_LNqxqKSFschqRy);
}
  .container {
    width: 800px;
    margin: 0 auto;
  }
.navBar {
    width: 800px;
    background-image: url(https://s-media-cache-ak0.pinimg.com/236x/83/1d/38/831d38d98e6c67663073511b96cf47ef.jpg);
    border-bottom: 1px solid black;
  }
  h2{
    color: lightblue;
    font-family: fantasy;
    font-weight: bold;
    font-size: 35px;
    text-shadow: 2px 2px navy;
        margin-left: 45px;
  }
.greeting {
  text-align: right;
  padding-right: 30px;
  color: lightblue;
  font-family: fantasy;
  font-weight: bold;
  font-size: 20px;
  text-shadow: 1px 1px navy;
}
.mainBody {
  background-image: url(https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcRDeCc6FqX8mnEtQHxi5QMb7rl21_VWlE3k1a0jsPLN92qK_SbfBw);
  padding-left: 50px;
}

#postamessage {
  background-color: #009933;
  color: white;
  font-family: fantasy;
  padding-top: 5px;

}
.post1{
  font-family: sans-serif;
  font-weight: bold;
  color: white;
  background-image: url(http://www.joshuajmorgan.com/blog/media/blogs/all/gmail_themes/gmail_themes_ninja_10.jpg);
  width: 625px;
  height: 30px;
  padding-top: 10px;
  padding-left: 10px;
  border-radius: 50px;
}

.post {
  font-family:  monospace;
  font-weight: bold;
  color: white;
  background-image: url(http://www.joshuajmorgan.com/blog/media/blogs/all/gmail_themes/gmail_themes_ninja_10.jpg);
  width:625px;
  padding-left: 10px;
  border-radius: 10px;
  height: 50px;
}

.c_box{
  margin-left: 40px;
  background-color: lightblue;
  width: 400px;
  height: 100px;
  border-radius: 4px;
  padding-left: 10px;

}
.comment1 {

  font-family: serif;
  font-weight: bold;
  border-radius: 4px;
  padding-left: 10px;
  text-decoration: underline;
}
.comment {
  margin-left: 10px;
  font-family: monospace;
  border-radius: 4px;
  padding-left: 10px;
}
#deletemessage{

  background-color: #800000;
  color: white;
  font-family: fantasy;
    padding-top: 5px;
    margin-left: 520px;
}

#comment {
  background: #00CCFF;
  color: white;
  font-family: fantasy;
  padding-top: 5px;
  position: relative;
  bottom: 15px;
}

#deletecomment {
  background-color: #800000;
  color: white;
  font-family: fantasy;
  padding-top: 5px;
  margin-left: 50px;
}

h3 {
  padding-top: 25px;
  font-family: fantasy;
  font-weight: bold;
  text-shadow: 1px 1px navy;
  font-size: 20px;
  color: lightblue;
  margin-left: 250px;
}


  </style>

  <body>



    <div class="container">
      <div class="navBar">
        <h2>CodingDojo Wall</h2>
        <?= "<p class='greeting'>Welcome ".($_SESSION['first_name'])."</p>"; ?>
        <form class="greeting" action="process.php" method="post">
          <input type="hidden" name="logoff" value="logoff">
            <input class="greeting" type="submit" value="log off">
        </form>

      </div>

      <div class="mainBody">
        <h3>Post a Message</h3>
        <form class="postmessage" action="process.php" method="post">
        <input type="hidden" name="actions" value="posts">
        <textarea name="postamessage" rows="8" cols="100"></textarea>
      <br><input id="postamessage" type="submit" value="Post a message">
      </form><br><br>




        <?php
        $query = "SELECT users.id as users_id, first_name, last_name, messages.message, messages.created_at, messages.id as mid
        FROM users LEFT JOIN messages ON users.id = messages.users_id ORDER BY messages.created_at DESC";
        $allmessages = fetch($query);

        $query1 = "SELECT comment, comments.users_id, first_name, last_name, messages_id as mid, comments.id AS comment_id, comments.created_at
                  FROM comments
                  LEFT JOIN users ON comments.users_id = users.id ORDER BY comments.created_at DESC";
                  $allcomments = fetch($query1);
        // var_dump($allmessages);
        // die();
        foreach($allmessages as $message)
        {
          if ($message['mid'] != null && $message['created_at'] != null)
          {
          $date_added = date('F d, Y', strtotime($message['created_at']));
          echo "<p class='post1'>".($message['first_name'])." ".($message['last_name'])." - ".($date_added)."</p>";
          echo "<p class='post'>".($message['message'])."</p><br>";
          // echo "<p>".($message['mid'])."</p><br>";
          if ($message['users_id'] ==  $_SESSION['user_id'])
          {
          ?>
          <form class="deletemessage" action="process.php" method="post">
          <input type="hidden" name="delete_message" value="<?= $message['mid']?>">
          <input type="hidden" name="action" value="delete">
          <input id ="deletemessage" type="submit" value="Delete Message">
          </form>
          <?php
          }
          }
                    foreach($allcomments as $comment)
                    {
                      if($comment['mid'] == $message['mid'])
                      {
                      $comment_date = date('F d, Y', strtotime($comment['created_at']));
                      // echo "<p>".$comment['comment_id']." ".$_SESSION['user_id']."</p>";
                      echo "<div class='c_box'><p class='comment1'>".($comment['first_name'])." ".($comment['last_name'])." - ".($comment_date)."</p>";
                      echo "<p class='comment'>".($comment['comment'])."</p></div>";
                      if ($comment['users_id'] ==  $_SESSION['user_id'])
                      {
                      ?>
                      <form class="deletecomment" action="process.php" method="post">
                      <input type="hidden" name="delete_comment" value="<?= $comment['comment_id']?>">
                      <input type="hidden" name="action" value="d_comment">
                      <input id="deletecomment" type="submit" value="Delete Comment">
                      </form>
                      <br>
                      <?php
                      }

                    }
                    }

          ?>

          <form class="" action="process.php" method="post">
          <input type="hidden" name="message_id" value="<?= $message['mid'];?>">
          <textarea id="commentarea" name="comments" rows="3" cols="70"></textarea>
          <input id="comment" type="submit" value="Comment">
          </form>
          <?php }
         ?>


        <?php
        // $display_message_query = "SELECT * FROM author ORDER BY created_on DESC";
        // $quote = fetch($display_author_query);
        //
        // if (isset($_SESSION['post_message']))
        //   {
        //     foreach($quote as $quote)
        //     {
        //       $date_added = date('g:ia F d, Y', strtotime($quote['created_on']));
        //     }
        //     foreach($_SESSION['post_message'] as $message)
        //     {
        //        echo "<p>".$_SESSION['first_name']." "$_SESSION['last_name']."- ""</p>"
        //        echo "<p class='error'>- ".($message)."</p>";
        //       unset($_SESSION['post_message']);
        //     }
        // }
        // if(isset($_POST['post']) && $_POST['post'] == "post")
        // {
        //   echo "<p>". $SESSION_['posts']."</p>";
        // }




          // $_SESSION['post_message'] = array();
          // $_SESSION['post_message'][] = $_POST['postamessage'];
          // $post = $_POST['postamessages'];

        // if(isset($_POST['actions']))
        // {
        // $user = fetch("SELECT * FROM users");
        // foreach($user as $row)
        // {
        //   var_dump($row);
        // }
        // }
      // $id = fetch("SELECT * FROM messages");
      // foreach($id as $row){
      // $_SESSION['id'] = $row['id'];
      // // echo $_SESSION['id'];
      // }
      //
      // $user = fetch("SELECT * FROM users");
      // foreach($user as $row){
      // var_dump($row['first_name']);
      // var_dump($user);
      // }
      // var_dump($_SESSION['user']);
      // echo $_SESSION['user_id'];
      // echo $_SESSION['email'];
      // echo $_SESSION['first_name'];
      // echo $_SESSION['password'];



        ?>



      </div>
    </div>
  </body>
</html>
