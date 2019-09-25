<?php
    include('session.php');
    if(!$_SESSION['loggedIn'])
        header('Location: ../index.php');
?>
<html lang="gr">
    <head>
        <title>Ηλεκτρονική πλατφόρμα Ανοικτού Πανεπιστημίου</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel='stylesheet' href='fonts/typicons/typicons.min.css' />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
        <link rel='stylesheet' id='BNS-Corner-Logo-Style-css'  href='css/social_icons_from_Techandallcom.css' type='text/css' media='screen' />
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-animate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
        <script src="js/angular-datatables.min.js"></script>
        <script src="js/ng-file-upload.min.js"></script>
        <link rel="stylesheet" href="css/custom.css">
        
        <link rel="stylesheet" href="https://cdn.gitcdn.link/cdn/angular/bower-material/v1.1.9/angular-material.css">
        <!-- <link rel="stylesheet" href="https://material.angularjs.org/1.1.9/docs.css"> -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-aria.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-messages.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-aria.min.js"></script>
        <script src="https://cdn.gitcdn.link/cdn/angular/bower-material/v1.1.9/angular-material.js"></script>
        <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-114/svg-assets-cache.js"></script>
        
        <!-- FOR CALENDAR -->
        <script src="js/angularCalendar/moment.js"></script>
        <script src="js/angularCalendar/interact.js"></script>
        <script src="js/angularCalendar/rrule.js"></script>
        <script src="js/angularCalendar/ui-bootstrap-tpls.js"></script>
        <script src="js/angularCalendar/angular-bootstrap-calendar-tpls.js"></script>
        <link href="https://unpkg.com/angular-bootstrap-calendar/dist/css/angular-bootstrap-calendar.min.css" rel="stylesheet">
        <!-- /FOR CALENDAR -->
        <script src="js/angular-toastr.tpls.js"></script>
        <link rel="stylesheet" type="text/css" href="css/angular-toastr.css" />
        <script>
            //Scroll to Top Button
            $(window).scroll(function() {
            if ($(this).scrollTop() > 450 ) {
                $('.scrolltop:hidden').stop(true, true).fadeIn();
            } else {
                $('.scrolltop').stop(true, true).fadeOut();
            }});
            
            function topFunction() {
                $("html, body").animate({ scrollTop: 0 }, 600); 
                return false;
            }
        </script>    
        <style>
            html,body,h1,h2,h3,h4,h5 {font-family: "Open Sans", sans-serif}
            a, a:hover, a:active, a:visited, a:focus {
                text-decoration: none;
            }
            #skato {
                z-index: 1;
                overflow: visible;
            }
            #anakoinwseis:hover {
                background-color:lightgray;
            }
            .count {
                background-color: #0e5eb7;
            }
            #notific:hover, #notific:visited {
                background-color:#D65D1D;  
            }
            .w3-display-container:hover {
                background-color: gray;
            }
        </style>
    </head>
<body class="w3-theme-l5" ng-app="crudApp">
<div class='thetop'></div>
    <div ng-controller="crudController" ng-cloak>
<!-- Navbar -->
<div class="w3-top" style="z-index:3">
 <div class="w3-bar w3-theme-d2 w3-left-align w3-large" id="skato">
  <!-- <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a> -->
     <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-theme-d4" > <!-- <img src="../img/EAPlogowhite.png" style="height:26px;width:26px"> -->ΕΛΛΗΝΙΚΟ ΑΝΟΙΚΤΟ ΠΑΝΕΠΙΣΤΗΜΙΟ</a>
     <ul class="nav navbar-nav w3-dropdown-hover" id="notific">  
         <li class="dropdown " id="notific">
             <a href="#" class="dropdown-toggle " data-toggle="dropdown" id="notific"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <i class="fa fa-bell"></i></a>
             <ul class="dropdown-menu w3-dropdown-content" style="border:1px solid #0e5eb7; width:300px;background-color:#f7f7f7;padding:0" id="notific"><li style="padding: 9px 9px 10px 9px; font-weight:bold; font-size:105%; background-color: #0e5eb7; color:white">  <i class="fa fa-exclamation-circle"></i> &ensp;ΝΕΕΣ ΑΝΑΚΟΙΝΩΣΕΙΣ</li><li id="anakoinwseis" ng-repeat="notification in notifications" style="color:black; padding: 9px 9px 5px 9px; border-top:1px solid lightgray" ng-mouseover="notificationsSeen()">Μάθημα: &nbsp;<label style="font-weight:bold; color:black">{{notification.mathima}}</label><br>Θέμα: &nbsp;<label>{{notification.thema}}</label><label style="float:right">{{notification.imerominia}}</label></li><li ng-show="!uparxeiEidopoihsh" style="color:black; padding: 9px 9px 8px 9px; text-align:center">Δεν υπάρχει κάτι νέο!</li></ul>
         </li>
     </ul>

     <div class="w3-dropdown-hover w3-right">
        <button class=" w3-button w3-padding-large" title="Ο λογαριασμός μου"><i class="fa fa-chevron-down"> &ensp;</i><?php echo $_SESSION['onoma'] . ' ' . $_SESSION['epwnumo'] ; ?> &ensp;<img src="../material/students/avatars/<?php echo $_SESSION['avatar']; ?>.png" class="w3-circle" style="height:26px;width:26px" alt="Avatar">
        </button>
        <div class="w3-dropdown-content w3-bar-block w3-border">
            <a href="studentPersonalization/indexPersonalization.php" class="w3-bar-item w3-button" id="aposundesi"><i class="fa fa-cog"></i> &ensp;Ρυθμίσεις</a>
            <a href="logout.php" class="w3-bar-item w3-button" id="aposundesi"><i class="fa fa-power-off"></i> &ensp;Αποσύνδεση</a>
        </div>
    </div>
 </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 1</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 2</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">Link 3</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">My Profile</a>
</div>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px" ng-init="getEggegramenaMathimata(); getNotifications()">    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
      <!-- Profile -->
      <div class="w3-card w3-round w3-white">
        <div class="w3-container">
         <p class="w3-center" style="padding-top:5%"><img src="../img/EAPlogoblue.png" style="height:12%;width:90%"></p>
         <h4 style="padding-top:3%" class="w3-center">Online Πλατφόρμα</h4>
         <hr>
         <p style="padding-top:2%"><i class="fa fa-id-card fa-fw w3-margin-right w3-text-theme"></i> <?php echo $_SESSION['onoma'] . ' ' . $_SESSION['epwnumo'] ; ?> </p>
         <p style="padding-top:2%"><i class="fa fa-pencil-square-o fa-fw w3-margin-right w3-text-theme"></i> <?php echo $_SESSION['programma']; ?> Επίπεδο </p>
         <p style="padding-top:2%"><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> <?php echo $_SESSION['poli']; ?>, Ελλάδα</p>
         <p style="padding-top:2%"><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> {{imerominiaGennisis}} </p>
        </div>
      </div>
      <br>
      <div class="w3-card w3-round w3-white">
        <!-- Accordion -->
        <div id='cssmenu'>
            <ul>
                <li><a href='javascript:void(0)'></a></li>
                <li class='active'><a href='#!home'><span><i class="typcn typcn-home-outline" style="font-size:160%"></i> &nbsp;&nbsp;Αρχική οθόνη</span></a></li>
                <li class='has-sub'><a href='javascript:void(0)'><span><i class="typcn typcn-mortar-board" style="font-size:160%"></i> &nbsp;&nbsp;Τα μαθήματα μου</span></a>
                    <ul>
                        <li ng-repeat="mathima in EggegramenaMathimata" ><a href='#!course/{{mathima}}/{{userID}}'><span style="margin-left:23px">{{mathima}}</span></a></li>
                    </ul>
                </li>
                <li><a href='#!assignment/{{userID}}'><span><i class="typcn typcn-document-text" style="font-size:160%"></i> &nbsp;&nbsp;Ανοιχτές εργασίες</span></a></li>
                <!-- <li><a href='#'><span><i class="typcn typcn-calendar-outline" style="font-size:160%"></i> &nbsp;&nbsp;Εβδομαδιαίο πρόγραμμα</span></a></li> -->
                <li class='last'><a href='#!contact'><span><i class="typcn typcn-messages" style="font-size:160%"></i> &nbsp;&nbsp;Επικοινώνησε μαζί μας</span></a></li>
            </ul>
          </div>
        </div>
      <br>
      
      <!-- Interests --> 
      <div class="w3-card w3-round w3-white w3-hide-small">
        <div class="w3-container">
          <h4 style="padding-top:5%; color:#071C33" class="w3-center">Βρες μας στα social media</h4><hr style="margin-top:-1%">
            <div class="social-icons">
                <ul>
                    <li class="twitter" style="background-color: #f0f0f0; border: 1px solid gray">
                        <a href="https://twitter.com/eapuni" target="_blank">Twitter</a>
                    </li>

                    <li class="facebook" style="background-color: #f0f0f0; border: 1px solid gray">
                        <a href="https://www.facebook.com/eapuni/" target="_blank">Facebook</a>
                    </li>

                    <li class="youtube" style="background-color: #f0f0f0; border: 1px solid gray">
                        <a href="https://www.youtube.com/c/%CE%95%CE%BB%CE%BB%CE%B7%CE%BD%CE%B9%CE%BA%CF%8C%CE%91%CE%BD%CE%BF%CE%B9%CE%BA%CF%84%CF%8C%CE%A0%CE%B1%CE%BD%CE%B5%CF%80%CE%B9%CF%83%CF%84%CE%AE%CE%BC%CE%B9%CE%BF%CE%95%CE%91%CE%A0" target="_blank">YouTube</a>
                    </li>

                    <li class="googleplus" style="background-color: #f0f0f0; border: 1px solid gray">
                        <a href="https://plus.google.com/+%CE%95%CE%BB%CE%BB%CE%B7%CE%BD%CE%B9%CE%BA%CF%8C%CE%91%CE%BD%CE%BF%CE%B9%CE%BA%CF%84%CF%8C%CE%A0%CE%B1%CE%BD%CE%B5%CF%80%CE%B9%CF%83%CF%84%CE%AE%CE%BC%CE%B9%CE%BF%CE%95%CE%91%CE%A0" target="_blank">Google +r</a>
                    </li>
                    <li class="linkedin" style="background-color: #f0f0f0; border: 1px solid gray">
                        <a href="https://www.linkedin.com/school/hellenic-open-university/" target="_blank">LinkedIN</a>
                    </li>
                </ul>
            </div>
        </div><br>
      </div>
      <br>

      <!-- Alert Box -->
      <div class="w3-container w3-display-container w3-round  w3-border w3-theme-border w3-margin-bottom w3-hide-small" style="background-color:#f2f2f2">
        <div onclick="this.parentElement.style.display='none'" class="w3-button w3-display-topright kleisimo" style="background-color:lightgray">
          <i class="fa fa-remove"></i>
        </div>
        <p style="margin-top:1em"><strong><i class="fa fa-unlock"></i> &nbsp;Τελευταία είσοδος στο σύστημα:</strong></p>
        <p><i class="fa fa-clock-o"></i> &nbsp;{{lastLogin}}<br></p>
          
 
      </div>
        
    <!-- End Left Column -->
    </div>
      <!-- Start angular show -->
<div ng-view class="reveal-animation">

    <!-- End angular show -->
</div>
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>
<br>
    </div>
<!-- Footer -->
<footer class="w3-container w3-theme-d5">
  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
</footer>
 <div class="scrolltop" onclick="topFunction()">
     <a href="javascript:void(0)" style="text-decoration:none;background: url('http://game20.gr/wp-content/themes/game20v2/img/pagination-arrows-next.png') no-repeat right -53px;cursor:inherit;display:block;width:50px;height:50px;margin-top:15px;margin-left:9px;-ms-transform: rotate(-90deg);-webkit-transform: rotate(-90deg);transform: rotate(-90deg);">
     </a>
</div>

<!-- <script src="js/jquery.min.js"></script> -->
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!-- <script src="js/bootstrap.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/scriptsIndex.js"></script>

</body>
</html> 
