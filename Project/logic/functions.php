<?php
    //Set the session if it isn 't already set.
    if (!isset($_SESSION)) {
        session_start();
    }
    //Turn a natural number into an ordinal.
    function ordinal(int $i) {
        if ($i > 0) {
            switch ($i) {
                case 1: $suffix = "st"; break;
                case 2: $suffix = "nd"; break;
                case 3: $suffix = "rd"; break;
                default: $suffix = "th"; break;
            }
            return $i . $suffix;
        }
        return null;
    }
    //This recursive function draws the a post, then checks to see if it has any children and calls itself again to draw them.
    function draw_post($conn, $row, $colour, $depth) {
        //Obtain all the information from the SQL query.
        $id = $row['id'];
        $name = $row['name'];
        $description = $row['description'];
        $datetime = $row['postDate'];
        $parent = $row['parent'];
        $indent = "";
        $reference_link = "";
        //If the post is a child, indent it and create the parent's reference tag.
        if ($parent) {
            $indent = "indented";
            $result2 = mysqli_query($conn, "SELECT name FROM T_COMMENTS WHERE id = " . $parent);
            $reference = "@" . mysqli_fetch_assoc($result2)['name'] . "#" . $parent;
            $reference_link = "<a href='#$parent' title='Jump to parent comment " . $reference. "'>" . $reference . "</a> ";
        }
        
        //Draw the post's divider box, adding in the relevant poster information, a divider and then the description.
        echo "<div id='$id' class='indented $colour comment' style='left: " . (64 * $depth) . "px; width: calc(100% - " . ((80 * $depth) + 16) . "px)'>";
        echo "<strong>$name</strong> <span class='desktop'>$datetime </span> <em>No. $id</em><a class='reply symbol' title='Reply to @" . $name . "#" . $id . "' href='?reply_comment_$id' onclick='return submitComment()'>Reply</a>";
        echo "<hr>";
        if ($description) {
            echo $reference_link . $description;
        }
        else {
            echo "<br>";
        };
        echo "</div>";
        //Flip the colour.
        switch ($colour) {
            case 'black': $colour = 'white'; break;
            case 'white': $colour = 'black'; break;
        }
        //Find all children of the current post.
        $result = mysqli_query($conn, "SELECT * FROM T_COMMENTS WHERE parent = $id");
        //If there are, loop through all of them and make them draw themselves. This will recurse until there are no more child posts.
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $colour = draw_post($conn, $row, $colour, $depth + 1);
            }
        }
        //If the user has clicked to reply to this comment, send it as a function.
        if (isset($_GET["reply_comment_" . $id])) {
            echo "<script type='text/javascript'>",
                 "replyToComment(" . $id . ", '" . $name . "');",
                 "</script>";
        }
        //Return the post's current colour, flipped.
        switch ($colour) {
            case 'black': $colour = 'white'; break;
            case 'white': $colour = 'black'; break;
        }
        return $colour;
    }
    //Save each active session in a cookie.
    function save_session() {
        if (isset($_SESSION))
        {
            foreach ($_SESSION as $id => $value) {
                $_COOKIE['S_' . $id] = $value;
            }
            return true;
        }
        else {
            return false;
        }
    }
    //Load each stored session.
    function load_session() {
        foreach ($_COOKIE as $id => $value) {
            if (substr($id, 0, 2) == "S_") {
                $new_id = explode("S_", $id, 2)[0];
                $_SESSION[$new_id] = $value;
            }
        }
    }
    //Reload or redirect a page, taking id and href values as well.
    function refresh_page($resource = null) {
        save_session();
        //If the user specified a URL, redirect them to that location, else reload the current page.
        if (isset($resource)) {
            //If the user specified a tag end (id or href), append it to the current URL. Then, reload the page.
            if (in_array($resource[0], array("#", "?"))) {
                $resource = preg_split("/[?#]/", $_SERVER["REQUEST_URI"], 2)[0] . $resource;
            }
            header("Refresh: 0.1; url=$resource");
        }
        else {
            $resource = preg_split("/[?#]/", $_SERVER["REQUEST_URI"], 2)[0];
            header("Refresh: 0.1; url=$resource");
        }
        //Terminate the script.
        exit();
    }
    //Set all fields of a cookie to empty, then delete it. Alternative to unset.
    function unset_cookie($name) {
        $date = time() - 3600;
        if (isset($_COOKIE[$name])) {
            setcookie($name, "", $date);
            unset($_COOKIE[$name]);
        }
    }
    //This function stores the details of the form into the database, assigning the new post a timestamp indicating the time of creation.
    function post_comment($conn, $name, $description, $parent) {
        //Obtain the current time.
        $time = date("Y-m-d H:i:s");
        //Change the parent to a string if it isn't already.
        if ($parent == null) {
            $parent = 'NULL';
        }
        //Store the comment and obtain its ID.
        $result = mysqli_query($conn, "INSERT INTO T_COMMENTS (name, description, postDate, parent) VALUES ('$name', '$description', '$time', $parent)") or die(mysqli_error($conn));
        $result = mysqli_query($conn, "SELECT id FROM T_COMMENTS ORDER BY id DESC") or die(mysqli_error($conn));
        //Unset all cookies.
        unset_cookie($_COOKIE['COMMENT_NAME']);
        unset_cookie($_COOKIE['COMMENT_CONTENT']);
        unset_cookie($_COOKIE['COMMENT_PARENT']);
        //Refresh the page and jump to the new comment.
        $id = mysqli_fetch_assoc($result)['id'];
        refresh_page("#" . $id);
    }
?>