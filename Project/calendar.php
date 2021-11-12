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
  <div class='black'>
   <!-- Subtitle -->
   <h2>When are my Events?</h2>
   <?php
    //For each both yoga classes and conferences, arrange their calendars the same way.
    $eventTypes = array(array('Yoga Classes', 'Yoga'), array('Design Conferences', 'Conference'));
    foreach ($eventTypes as $eventType) {
        echo "<hr>";
        //State the event type and the month.
        echo "<h3>" . $eventType[0] . " for " . date('F') . " " . date('Y') . "</h3>";
        //Fetch the code for the days of the week headers.
        include("include/days.php");
        echo "<hr>";
        //Query the database to find all the month's relevant events.
        $result = mysqli_query($conn, "SELECT * FROM T_EVENTS WHERE eventType = '" . $eventType[1] . "' AND MONTH(eventDate) = " . date('m'));
        //Compile all of them into a list and assign them values based on their dates in the month.
        $events = array();
        $eventDates = array();
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $i = date('d', strtotime($row['eventDate']));
                array_push($eventDates, $i);
                array_push($events, $row);
            }
        }
        //Create an unordered list containing all of the calendar entries. This will only display on desktop systems.
        echo "<ul class='calendar desktop'>";
        //Push the first day of the month to when it would actually occur in the week.
        $days_before_month = array_search(date('l', strtotime(date("Y") . "-" . date('m') . "-01")), $menu_desktop);
        //Loop through all days in the month. If there is an event on a day, display it and give it a tooltip.
        for ($i = -$days_before_month; $i < cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')); $i += 1) {
            if ($i >= 0) {
                echo "<li><div class='black has-tooltip'>";
                echo ordinal($i + 1) . "<br>";
                if (in_array($i + 1, $eventDates)) {
                    $row = $events[array_search($i + 1, $eventDates)];
                    echo $row['name'];
                    echo "<div class='tooltip white'><strong>" . $row['name'] . ":</strong> " . $row['description'] . "</div>";
                }
            }
            else {
                echo "<li><div class='transparent'>";
            }
            echo "</div></li>";
        }
        echo "</ul>";
        //For mobile, only create the list if there is a result to display.
        if ($result) {
            echo "<ul class='calendar mobile'>";
            for ($i = 0; $i < sizeof($events); $i += 1) {
                //Obtain all of the attributes of the event being displayed.
                $row = $events[$i];
                $date = strtotime($row['eventDate']);
                $time = "";
                //If the start and end time are specified, write them.
                if ($row['startTime'] && $row['endTime']) {
                    $startTime = date('H', strtotime($row['startTime'])) . ":" . date('i', strtotime($row['startTime']));
                    $endTime = date('H', strtotime($row['endTime'])) . ":" . date('i', strtotime($row['endTime']));
                    $time = " (" . $startTime . "-" . $endTime . ")";
                }
                $day_of_the_week = date('l', $date);
                $name = $row['name'];
                $description = $row['description'];
                //Display the box containing the entry.
                echo "<li><div class='black'>";
                echo $day_of_the_week . " " . ordinal(date("d", $date)) . $time . " - " . $name;
                echo "<hr>";
                echo $description;
                echo "</div></li>";
            }
            //End the list.
            echo "</ul>";
        }
    }
   ?>
  </div>
 </body>
</html>