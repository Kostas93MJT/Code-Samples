<html lang="gr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>ΕΛΛΗΝΙΚΟ ΑΝΟΙΚΤΟ ΠΑΝΕΠΙΣΤΗΜΙΟ</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Lato:700%7CMontserrat:400,600" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->  
        <script>
            function do_login()
            {
                var user=$("#uname").val();
                var pass=$("#psw").val();

                $.ajax ({
                    type:'post',
                    url:'do_login.php',
                    data:{
                        do_login:"do_login",
                        username:user,
                        password:pass
                    },
                    success:function(response) {
                        if(response=="success_professor")
                            window.location.href="professorPlatform/index.php";
                        else if(response=="success_student") 
                            window.location.href="studentPlatform/index.php";
                        else
                        {
                            document.getElementById("txtHint").innerHTML = "<font color='red'>*Το Όνομα Χρήστη ή ο Κωδικός Πρόσβασης είναι λανθασμένα</font>";
                            $('#txtHint').fadeIn("slow");
                            setTimeout(function() { 
                                $('#txtHint').fadeOut("slow"); 
                            }, 4000);
   
                        }
                    }
                });
                return false;
            }
        </script>
    </head>
	<body>

		<!-- Header -->
		<header id="header" class="transparent-nav">
			<div class="container">

				<div class="navbar-header">
					<!-- Logo -->
					<div >
						<a class="logo" href="index.php">
							<img src="./img/EAPlogo.png" alt="logo" height="50" width="150">
						</a>
					</div>
					<!-- /Logo -->

					<!-- Mobile toggle -->
					<button class="navbar-toggle">
						<span></span>
					</button>
					<!-- /Mobile toggle -->
				</div>

				<!-- Navigation -->
				<nav id="nav">
					<ul class="main-menu nav navbar-nav navbar-right">
						<li><a href="index.html">ΑΡΧΙΚΗ</a></li>
						<li><a href="#about">ΠΛΗΡΟΦΟΡΙΕΣ</a></li>
						<li><a href="#courses">ΜΑΘΗΜΑΤΑ</a></li>
						<li><a href="contact.html">ΕΠΙΚΟΙΝΩΝΙΑ</a></li>
					</ul>
				</nav>
				<!-- /Navigation -->

			</div>
		</header>
		<!-- /Header -->
        
        <!-- Popup login window -->
        <div id="id01" class="modal" style="overflow-y: hidden;">
            <form class="modal-content animate" action="do_login.php" onsubmit="return do_login();" method="post">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Κλείσιμο">&times;</span>
                </div>
                <div class="container2">
                    <label for="uname"><b>Όνομα Χρήστη </b></label>
                    <input type="text" placeholder="&#xf007; &nbsp; Όνομα Χρήστη" name="uname" id="uname" required><br/>
                    <label for="psw"><b>Κωδικός Πρόσβασης</b></label>
                    <input type="password" placeholder="&#xf023; &nbsp; Κωδικός Χρήστη" name="psw" id="psw" required><br/>
                    <p id="txtHint" hidden></p>
                    <button type="submit" id="login_button" name="login">ΕΙΣΟΔΟΣ</button>
                </div>
                <div class="container2" style="background-color:#f1f1f1">
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Ακύρωση</button>
                    <span class="psw">Ξεχάσατε το <a href="contact.html">Κωδικό Πρόσβασης;</a></span>
                </div>
            </form>
        </div>
        <!-- /Popup login window -->
        
		<!-- Home -->
		<div id="home" class="hero-area">

			<!-- Backgound Image -->
			<div class="bg-image bg-parallax overlay" style="background-image:url(./img/home-background.jpg)"></div>
			<!-- /Backgound Image -->

			<div class="home-wrapper">
				<div class="container">
					<div class="row">
						<div class="col-md-8">
							<h1 class="white-text">ΕΛΛΗΝΙΚΟ ΑΝΟΙΚΤΟ ΠΑΝΕΠΙΣΤΗΜΙΟ</h1>
							<p class="lead white-text">Η μόρφωση είναι δικαίωμα όλων. Εξατομικευμένη εκπαίδευση για όλους, πρόσβαση από παντού.</p>
                            <p class="lead white-text">Είστε ήδη μέλος;</p>
							<a class="main-button icon-button" onclick="document.getElementById('id01').style.display='block'" href="javascript:void(0)">Είσοδος στο σύστημα</a>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!-- /Home -->

		<!-- About -->
		<div id="about" class="section">
            
			<!-- container -->
			<div class="container">

				<!-- row -->
				<div class="row">

					<div class="col-md-6">
						<div class="section-header">
							<h2>Καλωσορίσατε στο Ελληνικό Ανοικτό Πανεπιστήμιο!</h2>
							<p class="lead">Πρόσβαση στη γνώση για όλους και όλες χωρίς δεσμεύσεις χρόνου ή χώρου, με εξατομικευμένη βοήθεια για τον κάθε έναν ξεχωριστά </p>
						</div>

						<!-- feature -->
						<div class="feature">
							<i class="feature-icon fa fa-flask"></i>
							<div class="feature-content">
								<h4>Online Μαθήματα </h4>
								<p>Παρακολουθήστε τα μαθήματα που σας ενδιαφέρουν από την άνεση του σπιτιού σας.</p>
							</div>
						</div>
						<!-- /feature -->

						<!-- feature -->
						<div class="feature">
							<i class="feature-icon fa fa-users"></i>
							<div class="feature-content">
								<h4>Άρτια εκπαιδευμένο προσωπικό</h4>
								<p>Οι άνθρωποι που επιλέξαμε να δουλεύουν για εμάς είναι ηγέτες στο αντικείμενο τους, με πάθος για διδασκαλία. </p>
							</div>
						</div>
						<!-- /feature -->

						<!-- feature -->
						<div class="feature">
							<i class="feature-icon fa fa-comments"></i>
							<div class="feature-content">
								<h4>Ενεργή κοινότητα</h4>
								<p>Μέσω εξατομικευμένων υπηρεσιών, έχετε τη δυνατότητα να συνομιλήσετε με άτομα που έχουν τα ίδια ενδιαφέροντα με εσάς. </p>
							</div>
						</div>
						<!-- /feature -->

					</div>

					<div class="col-md-6">
						<div class="about-img">
							<img src="./img/WorkFromHome.png" alt="">
						</div>
					</div>

				</div>
				<!-- row -->

			</div>
			<!-- container -->
		</div>
		<!-- /About -->

		<!-- Courses -->
		<div id="courses" class="section">

			<!-- container -->
			<div class="container">

				<!-- row -->
				<div class="row">
					<div class="section-header text-center">
						<h2>Μαθήματα </h2>
						<p class="lead">Επιλέξτε από μια πληθώρα μαθημάτων όπως</p>
					</div>
				</div>
				<!-- /row -->

				<!-- courses -->
				<div id="courses-wrapper">

					<!-- row -->
					<div class="row">

						<!-- single course -->
						<div class="col-md-3 col-sm-6 col-xs-6">
							<div class="course">
								<a class="course-img">
									<img src="./img/course01.jpg" alt="">
									
								</a>
								<a class="course-title">Marketing και νέες τεχνολογίες</a>
								<div class="course-details">
									<span class="course-category">Business</span>
									
								</div>
							</div>
						</div>
						<!-- /single course -->

						<!-- single course -->
						<div class="col-md-3 col-sm-6 col-xs-6">
							<div class="course">
								<a class="course-img">
									<img src="./img/course02.jpg" alt="">
									
								</a>
								<a class="course-title">Εισαγωγή στη C++ </a>
								<div class="course-details">
									<span class="course-category">Programming</span>
									
								</div>
							</div>
						</div>
						<!-- /single course -->

						<!-- single course -->
						<div class="col-md-3 col-sm-6 col-xs-6">
							<div class="course">
								<a class="course-img">
									<img src="./img/course03.jpg" alt="">
									
								</a>
								<a class="course-title" > Αρχιτεκτονικό Σχέδιο</a>
								<div class="course-details">
									<span class="course-category">Engineering</span>
									
								</div>
							</div>
						</div>
						<!-- /single course -->

						<div class="col-md-3 col-sm-6 col-xs-6">
							<div class="course">
								<a class="course-img">
									<img src="./img/course04.jpg" alt="">
									
								</a>
								<a class="course-title">Εισαγωγή στην HTML</a>
								<div class="course-details">
									<span class="course-category">Web Development</span>
									
								</div>
							</div>
						</div>
						<!-- /single course -->

					</div>
					<!-- /row -->	
				</div>
				<!-- /courses -->
			</div>
			<!-- container -->

		</div>
		<!-- /Courses -->

		<!-- Call To Action -->
		<div id="cta" class="section">

			<!-- Backgound Image -->
			<div class="bg-image bg-parallax overlay" style="background-image:url(./img/cta1-background.jpg)"></div>
			<!-- /Backgound Image -->

			<!-- container -->
			<div class="container">

				<!-- row -->
				<div class="row">

					<div class="col-md-6">
						<h2 class="white-text">Θες να αποκτήσεις ίδιες εργασιακές δυνατότητες με όλους;</h2>
						<p class="lead white-text">Ποτέ δεν είναι αργά για μάθηση. Φτιάξε το ατομικό σου πρόγραμμα εκπαίδευσης σήμερα κιόλας</p>
					</div>

				</div>
				<!-- /row -->

			</div>
			<!-- /container -->

		</div>
		<!-- /Call To Action -->

		<!-- Why us -->
		<div id="why-us" class="section">

			<!-- container -->
			<div class="container">

				<!-- row -->
				<div class="row">
					<div class="section-header text-center">
						<h2>Γιατί Ελληνικό Ανοικό Πανεπιστήμιο</h2>
					</div>

					<!-- feature -->
					<div class="col-md-4">
						<div class="feature">
							<i class="feature-icon fa fa-check"></i>
							<div class="feature-content">
								<h4>Πρόσβαση από παντού</h4>
								<p>Μπορείς να έχεις πρόσβαση σε όλη τη πληροφορία που σε ενδιαφέρει με ένα κλικ</p>
							</div>
						</div>
					</div>
					<!-- /feature -->

					<!-- feature -->
					<div class="col-md-4">
						<div class="feature">
							<i class="feature-icon fa fa-check"></i>
							<div class="feature-content">
								<h4>Εξατομικευμένες προτάσεις</h4>
								<p>Με τον προηγμένο αλγόριθμο που ενσωματώνει η πλατφόρμα, θα λάβετε προτάσεις οι οποίες είναι μοναδικές για εσάς</p>
							</div>
						</div>
					</div>
					<!-- /feature -->

					<!-- feature -->
					<div class="col-md-4">
						<div class="feature">
							<i class="feature-icon fa fa-check"></i>
							<div class="feature-content">
								<h4>Μαζί γινόμαστε πιο δυνατοί</h4>
								<p>Ανακαλύψτε άτομα που έχουν τα ίδια ενδιαφέροντα και απορίες με εσάς και συνομιλήστε μαζί τους</p>
							</div>
						</div>
					</div>
					<!-- /feature -->

				</div>
				<!-- /row -->

				<hr class="section-hr">

				<!-- row -->
				<div class="row">

					<div class="col-md-6">
						<h3>Μηνιαίες συναντήσεις με καθηγητές</h3>
						<p class="lead">Επιπλέον διαλέξεις και ημερίδες από καλεσμένους κάθε ειδικότητας</p>
						<p>Δεν είστε μόνοι σε αυτή σας την προσπάθεια. Οι συναντήσεις με τους καθηγητές αποσκοπούν στο να επιλυθούν οι όποιες δυσκολίες αντιμετωπίσετε και στη δημιουργία γεφυρών μεταξύ μαθητή-καθηγητή για αίσθημα πραγματικής επικοινωνίας. Σε συνδυασμό με τον προηγμένο αλγόριθμο που ενσωματώνει η πλατφόρμα, ο καθηγητής γνωρίζει εκ των προτέρων σε ποιούς τομείς θα πρέπει να επικεντρωθεί αποκλειστικά για εσάς </p>
					</div>

					<div class="col-md-5 col-md-offset-1">
						<a class="about-video" href="https://www.youtube.com/watch?v=e6qKDRZhwQo">
							<img src="./img/about-video.png" alt="">
							<i class="play-icon fa fa-play"></i>
						</a>
					</div>

				</div>
				<!-- /row -->

			</div>
			<!-- /container -->

		</div>
		<!-- /Why us -->

		<!-- Contact CTA -->
		<div id="contact-cta" class="section">

			<!-- Backgound Image -->
			<div class="bg-image bg-parallax overlay" style="background-image:url(./img/cta2-background.jpg)"></div>
			<!-- Backgound Image -->

			<!-- container -->
			<div class="container">

				<!-- row -->
				<div class="row">

					<div class="col-md-8 col-md-offset-2 text-center">
						<h2 class="white-text">Επικοινωνήστε μαζί μας</h2>
						<p class="lead white-text">Είμαστε εδώ για να λύσουμε όλες σας τις απορίες</p>
						<a class="main-button icon-button" href="contact.html">Επικοινωνήστε μαζί μας</a>
					</div>

				</div>
				<!-- /row -->

			</div>
			<!-- /container -->

		</div>
		<!-- /Contact CTA -->

		<!-- Footer -->
		<footer id="footer" class="section">

			<!-- container -->
			<div class="container">

				<!-- row -->
				<div class="row">

					<!-- footer logo -->
					<div class="col-md-6">
						<div class="footer-logo">
							<a href="index.php">
								<img src="./img/EAPlogoblue.png" alt="logo" height="70" width="200">
							</a>
						</div>
					</div>
					<!-- footer logo -->

					<!-- footer nav -->
					<div class="col-md-6">
						<ul class="footer-nav">
							<li><a href="index.php">ΑΡΧΙΚΗ</a></li>
							<li><a href="#about">ΠΛΗΡΟΦΟΡΙΕΣ</a></li>
							<li><a href="#courses">ΜΑΘΗΜΑΤΑ</a></li>
							<li><a href="contact.html">ΕΠΙΚΟΙΝΩΝΙΑ</a></li>
						</ul>
					</div>
					<!-- /footer nav -->

				</div>
				<!-- /row -->

				<!-- row -->
				<div id="bottom-footer" class="row">

					<!-- social -->
					<div class="col-md-4 col-md-push-8">
					
					</div>
					<!-- /social -->

					<!-- copyright -->
					<div class="col-md-8 col-md-pull-4">
						<div class="footer-copyright">
							<span>&copy; Copyright 2018. All Rights Reserved. | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com">Colorlib</a></span>
						</div>
					</div>
					<!-- /copyright -->

				</div>
				<!-- row -->

			</div>
			<!-- /container -->

		</footer>
		<!-- /Footer -->

		<!-- preloader -->
		<div id='preloader'><div class='preloader'></div></div>
		<!-- /preloader -->


		<!-- jQuery Plugins -->
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
        <script>
            $(document).ready(function(){
                // Add smooth scrolling to all links
                $("a").on('click', function(event) {

                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function(){
   
                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                    });
                } // End if
                });
            });
        </script>
        <script>
            // Get the modal
            var modal = document.getElementById('id01');

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>

	</body>
</html>
