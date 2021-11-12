<?php
    //Assign the list the class 'navigation', for styling.
    $class = "navigation";
    //This menu navigates to three pages.
    $links = array("home.php", "calendar.php", "comment.php");
    //This menu is visible on all devices.
    $menu_desktop = array("Who is Irene Au?", "Calendars", "Contact Irene");
    $menu_mobile = array("About", "Events", "Contact");
    //Fetch the code for creating a horizontal menu.
    include("menu.php");
?>