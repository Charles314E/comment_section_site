<?php
    //Start collecting and storing header information.
    ob_start();
?>
<html>
 <head>
  <?php
   //Obtain the CSS stylings and head information for the website.
   require("include/meta.html");
  ?>
 </head>
 <body>
  <?php
    //Fetch the code for the title divider and navigation menu.
    include("include/title.php");
  ?>
  <!-- Javascript functionality. Without it, you can't post comments, but you can still read them. -->
  <script>
    //Function taken from https://www.w3schools.com/js/js_cookies.asp
    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
              c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
              return c.substring(name.length, c.length);
            }
        }
        return "";
    }
    //This function stores the information in the comment form, allowing it to persist and be dealt with after the page reloads.
	function submitComment() {
        var name = document.forms["comment_form"]["comment_name"].value;
	    var content = document.getElementById("comment_description").value;
        content = content.replace(/\r?\n/g, '<br>');
	    document.cookie = "COMMENT_NAME=" + name;
	    document.cookie = "COMMENT_CONTENT=" + content;
    }
    //This function removes the reply tag.
    function removeReply() {
        submitComment();
        window.location.href = '?remove_reply';
    }
    //This function is called if the user clicks to reply to a comment.
    function replyToComment(id, name) {
        submitComment();
        //Store the fact the user is replying to a comment.
        document.cookie = "COMMENT_PARENT=" + id;
        //Create the reply tag, and allow the user to delete it by clicking on it.
        var reply = document.createElement("BUTTON"); 
        reply.innerHTML = "@" + name + "#" + id;
        reply.classList.add("reply_tag");
        reply.onclick = function() {
            removeReply();
        }
        //Append it to the comment form.
        document.getElementById("comment_box").append(reply);
        document.getElementById("comment_description").setAttribute("style", "padding-left: " + (reply.offsetWidth + 8) + "px")
        document.forms["comment_form"]["comment_name"].value = getCookie("COMMENT_NAME");
        document.getElementById("comment_description").value = getCookie("COMMENT_CONTENT");
    }
  </script>
  <!-- Create the comment form to allow the user to enter their own comment. -->
  <div id='comment_box' class='black comment_form'>
   <!-- Subtitle -->
   <h2 class='desktop'>Write your Comment</h2>
   <form name='comment_form' class='comment' method="post" action='?post_comment'>
	<input type='text' name='comment_name' placeholder='Type your name...' class='comment' required></input>
    <input type='submit' value='Post Comment' onclick='return submitComment()'></input>
    <textarea id='comment_description' form='comment_form' placeholder='What do you want to post?' class='comment' required></textarea>
   </form>
  </div>
  <?php
    //Select all comments that have no parent. These are the ones that aren't replies.
    $result = mysqli_query($conn, "SELECT * FROM T_COMMENTS WHERE parent IS NULL");
    //If there are results, draw all posts found in the query.
    if ($result) {
        $colour = 'white';
        $depth = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $colour = draw_post($conn, $row, $colour, $depth);
            switch ($colour) {
                case 'black': $colour = 'white'; break;
                case 'white': $colour = 'black'; break;
            }
        }
    }
    //If the browser detects you have clicked the 'Post Comment' button, post the comment, with a parent if applicable.
    if (isset($_GET["post_comment"])) {
        if (isset($_COOKIE['COMMENT_PARENT'])) {
            post_comment($conn, $_COOKIE['COMMENT_NAME'], $_COOKIE['COMMENT_CONTENT'], $_COOKIE['COMMENT_PARENT']);
        }
        else {
            post_comment($conn, $_COOKIE['COMMENT_NAME'], $_COOKIE['COMMENT_CONTENT'], null);
        }
    }
    //If the browser still remembers you replied to a comment, remove that data if it's no longer needed.
    if (isset($_COOKIE['COMMENT_PARENT'])) {
        if (isset($_GET["remove_reply"]) || !$result) {
            unset_cookie($_COOKIE["COMMENT_PARENT"]);
            refresh_page();
        }
    }
  ?>
 </body>
</html>
<?php
  //Close the MySQL connection and release all header information.
  mysqli_close($conn);
  ob_flush();
?>