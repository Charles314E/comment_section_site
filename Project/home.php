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
   <h2>Who am I?</h2>
   <!-- Circular image of Irene's face. -->
   <img src='image/irene-face.png' alt='Irene Photo' class='desktop' style='width: 12.5%; left: 43.75%'/>
   <img src='image/irene-face.png' alt='Irene Photo' class='mobile' style='width: 25%; left: 37.5%'/>
   <p style='text-align: center'><strong>My name is Irene Au.</strong></p>
   
   <p style='text-align: center'>Most designers naturally want to join a company where the design of the product is already strong, believing it reflects the value the
   company places on design and how well designers are set up to succeed. I am an Operating Partner at Khosla Ventures, where I work with
   portfolio companies to make their design great. My dedication is to raising the strategic value of design and user research through better
   methods, practices, processes, leadership and quality.</p>
   
   <!-- In desktop, there are two images side by side. In mobile, there's only one. -->
   <div class='inline desktop' style='width: 25%; left: 20%'>
    <img src='image/irene-conference2.jpg' alt='Irene Talking Onstage'/>
   </div>
   <div class='inline desktop' style='width: 25%; left: 25%'>
    <img src='image/irene-conference.jpg' alt='Irene Talking'/>
   </div>
   <img src='image/irene-conference-big.jpg' alt='Irene Talking' class='mobile' style='width: 90%; left: 5%'/>
   <p style='text-align: center'>I am international, travelling around the world to speak at conferences many times a month. I talk on UX design, integration between 
   technology and design, and many other aspects of interface design.</p>
   
   <!-- This image resizes depending on whether you use desktop or mobile. -->
   <img src='image/irene-yoga.jpg' alt='Yoga' class='desktop' style='width: 60%; left: 20%'/>
   <img src='image/irene-yoga.jpg' alt='Yoga' class='mobile' style='width: 80%; left: 10%'/>
   <p style='text-align: center'>I am also a yoga instructor. I hold classes every Tuesday, emphasising physical fitness and health to allow my students to learn to grow 
   and succeed not only in their careers, but also in life as well.</p>
   
   <!-- Icons for external links to Irene's other profiles. -->
   <a href="https://twitter.com/ireneau" title='Twitter'><div class='inline icon' style='left: calc(20% - 64px)'>
    <img src='image/logo-twitter.png' alt='Twitter' class='icon'/>
   </div></a>
   <a href="https://www.linkedin.com/in/ireneau" title='LinkedIn'><div class='inline icon' style='left: calc(45% - 96px)'>
    <img src='image/logo-linkedin.png' alt='LinkedIn' class='icon'/>
   </div></a>
   <a href="https://www.khoslaventures.com/team/irene-au" title='Khosla Adventures'><div class='inline icon' style='left: calc(70% - 128px)'>
    <img src='image/logo-link.png' alt='Khosla Adventures' class='icon'/>
   </div></a>
   <p style='text-align: center'>My links are shown above. You can see when my functions and classes run on the ‘Calendars’ tab, or if you’re on mobile, you can click on the ‘Events’ tab. To 
   contact me using my social media or the site’s in-built forum, you can access the ‘Contact’ tab.</p>
  </div>
 </body>
</html>