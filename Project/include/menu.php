<?php
//Set the format types as either desktop or mobile, and call the previously created list of button names.
$formats = array(array("desktop", $menu_desktop), array("mobile", $menu_mobile));
//Figure out exactly how much space each segment of the list will take up, as a fraction of the whole. Dividers are thinner than buttons.
$button_space = 78.25;
$divider_space = 7;
$length = sizeof($formats[0][1]);
$button_size = "(" . $button_space . "% / " . $length . ") - " . (12 / $length) . "px";
$divider_size = "(" . $divider_space . "% * " . (3 / $length) .")";
$menu_offset = (100 - $divider_space - $button_space) / 4;
$pixel_offset = -20;
//Correct an offset error.
if ($length < 5) {
    $pixel_offset = 12;
}
//For each of the formats, draw the list slightly differently.
foreach ($formats as $format) {
    //Check if the list can be displayed in this format.
    if (!is_null($format[1])) {
        //Create the unordered list.
        echo "<ul class='" . $format[0] . " " . $class . " menu', style='left: calc(" . $menu_offset  . "% + " . $pixel_offset . "px)'>";
        for ($i = 0; $i < sizeof($format[1]) - 1; $i += 1) {
            //If there are no links, do not create them.
            $box = "<div class='button'><span>" . $format[1][$i] . "</span></div>";
            if ($links == null) {
                echo "<li style='width: calc(" . $button_size . ")'>" . $box . "</li>";
            }
            else {
                echo "<li style='width: calc(" . $button_size . ")'><a href='" . $links[$i] . "'>" . $box . "</a></li>";
            }
            //If the dividers can be fully drawn, draw them.
            $divider = "";
            if ($format[0] == 'desktop' && (3 / $length) > 0.5) {
                $divider = "()";
            }
            echo "<li style='width: calc(" . $divider_size . ")'><div>" . $divider . "</div></li>";
        }
        //Draw the final button, making sure the dividers don't run off the list.
        $box = "<div class='button'><span>" . $format[1][$i] . "</span></div>";
        if ($links == null) {
            echo "<li style='width: calc(" . $button_size . ")'>" . $box . "</li>";
        }
        else {
            echo "<li style='width: calc(" . $button_size . ")'><a href='" . $links[$i] . "'>" . $box . "</a></li>";
        }
        //End the list.
        echo "</ul>";
    }
}
?>