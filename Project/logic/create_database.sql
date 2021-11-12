--* Remove the comment below to reset the database, but remember to comment it out again, otherwise the database will reset every time you 
--* reload any page on the site.
-- DROP DATABASE ireneAu;

-- If the database doesn't exist, create it.
CREATE DATABASE IF NOT EXISTS ireneAu;


USE ireneAu;

-- Create the necessary tables if they don't exist.
CREATE TABLE IF NOT EXISTS T_COMMENTS( id int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(64), description varchar(5096), postDate datetime(0), parent int );
CREATE TABLE IF NOT EXISTS T_EVENTS( id int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar (128), eventType ENUM('Yoga', 'Conference'), eventDate date, startTime time, endTime time, description varchar(5096));

-- Create the default records for yoga classes.
INSERT IGNORE INTO T_EVENTS VALUES (1, "Pilates Class", "Yoga", "2019-12-10", "18:00", "19:00", "This is a regular pilates class. Stretching will continue for ten minutes, and we will be focusing the rest of the class on core strength and breathing.");
INSERT IGNORE INTO T_EVENTS VALUES (2, "Fitness Class", "Yoga", "2019-12-17", "18:00", "19:00", "We will be focusing on physical stamina in this class. Stretches will continue for fifteen minutes, and after this, we will be attempting a series of bleep tests.");
INSERT IGNORE INTO T_EVENTS VALUES (3, "No Class Today", "Yoga", "2019-12-24", NULL, NULL, "As I need to travel to Tokyo for a design conference today, there shall be no regularly scheduled class today. Best wishes, and enjoy the new year.");
INSERT IGNORE INTO T_EVENTS VALUES (4, "New Year's Eve", "Yoga", "2019-12-31", NULL, NULL, "As it is the end of the year, there shall be no regularly scheduled class today. Best wishes, and enjoy the new year.");
-- Create the default records for conference events.
INSERT IGNORE INTO T_EVENTS VALUES (5, "UX design in extreme environments", "Conference", "2019-12-12", "09:00", "11:00", "Held in the CCT conference centre at Canary Wharf, I will be talking about how we can best incorporate UX design into extreme conditions, such as in engineering in space, and in the deep oceans.");
INSERT IGNORE INTO T_EVENTS VALUES (6, "HCI for the elderly", "Conference", "2019-12-19", "13:00", "15:00", "Held in the Cavendish conference centre in London, the main focus of this conference is how designing for the elderly and the physically impaired can present challenges that must be understood if we wish to cater to the needs of all people in our communities.");
INSERT IGNORE INTO T_EVENTS VALUES (7, "Incorporating procedural scripting into HCI", "Conference", "2019-12-24", "17:00", "19:00", "Held in the Tokyo Shinagawa conference centre, this conference will detail how procedural scripting, both client-side and server-side, can be used to improve dynamic HCI.");
-- Create the default records for a three-comment thread.
INSERT IGNORE INTO T_COMMENTS VALUES (1, "Daniel", "Hello Irene.<br><br>I was curious about the design of this website. It is very stark and blocky, with no colour and a lacking amount of contrast. I was wondering if it could be changed, as it may be difficult to understand for someone with visual impairments like me.", CURRENT_TIMESTAMP(), NULL);
INSERT IGNORE INTO T_COMMENTS VALUES (2, "Charles Knight", "That does appear to be an issue. Perhaps the link navigation buttons could be improved with colour. Currently, the buttons darken when clicked, which could make them difficult to see with a dark background. Maybe instead, we could incorporate buttons that change colour and brighten when hovered over and clicked.", CURRENT_TIMESTAMP(), 1);
INSERT IGNORE INTO T_COMMENTS VALUES (3, "Daniel", "I feel that would be a good change. Thank you.", CURRENT_DATE(), 2);