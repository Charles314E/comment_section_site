<?php
    //Assign the list the class 'days', for styling.
    $class = "days";
    //This menu doesn't navigate to anywhere.
    $links = null;
    //This menu is only visible on desktop.
    $menu_desktop = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $menu_mobile = null;
    //Fetch the code for creating a horizontal menu.
    include("menu.php");
?>