<?php
   include('session.php');
    if($_SESSION['loggedIn']){
        $temp = $_SESSION['mathima'];
        $sql = "SELECT * FROM eduplatform.students_courses WHERE mathimaMathiti = '$temp'";
        $result = mysqli_query($db,$sql);
        $countMathima = mysqli_num_rows($result);
        $temp = $_SESSION['tmima'];
        $sql = "SELECT * FROM eduplatform.students_courses WHERE tmimaMathiti = '$temp'";
        $result = mysqli_query($db,$sql);
        $countTmima = mysqli_num_rows($result);
    } else
      header('Location: ../index.php');
?>
<html lang="gr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>Πίνακας Ελέγχου</title>
		<link rel="shortcut icon" href="../favicon.ico">
        <link rel="stylesheet" href="../css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/component.css" />
		<!-- csstransforms3d-shiv-cssclasses-prefixed-teststyles-testprop-testallprops-prefixes-domprefixes-load --> 
		<script src="js/modernizr.custom.25376.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
        <style>
            #titloss{
                margin: 0;
	           font-size: 25px;
	           line-height: 1.3;
            }
            #titloi {
                font-weight: 300;
                font-size: 30px;
                line-height: 1.3;
                font-weight: bold;
                display: inline;
            }
        </style>
	</head>
	<body>
		<div id="perspective" class="perspective effect-airbnb">
			<div class="container">
				<div class="wrapper"><!-- wrapper needed for scroll -->
                    <!-- preloader -->
		              <div id='preloader'><div class='preloader'></div></div>
		            <!-- /preloader -->
					<!-- Top Navigation -->
					<div class="codrops-top clearfix">
						<a><span>ΕΛΛΗΝΙΚΟ ΑΝΟΙΚΤΟ ΠΑΝΕΠΙΣΤΗΜΙΟ</span></a>
						<span class="right"><a>ΕΚΠΑΙΔΕΥΤΙΚΟΣ&nbsp; <font color="black"><?php echo $_SESSION['onoma'], " ", $_SESSION['epwnumo'], ", "; ?></font><span id="date"></span></a></span>
					</div>
					<header class="codrops-header">
						<h1>Καλοσωρίσατε στην ηλεκτρονική πλατφόρμα του πανεπιστημίου </h1><span id="titloss">Κάντε κλικ στο Κεντρικό Μενού για περισσότερες επιλογές</span>
                        <button id="showMenu2" style="font-size:15px; display:none"> <i class="feature-icon fa fa-reply"></i> Κεντρικό Μενού</button>
					</header>
					<div id="swma1">
						<div class="column">
							<p id="titloi">Μάθημα διδασκαλίας: &nbsp; </p><p><?php echo $_SESSION['mathima']; ?></p>
                            <p id="titloi">Συντονιστής μαθήματος: &nbsp; </p><p><?php echo $_SESSION['suntonistis_mathimatos']; ?><a  href="mailto:<?php echo $_SESSION['suntonistis_email']; ?>"> <i class="fa fa-envelope-o"></i></a>
                            <p id="titloi">Τμήμα διδασκαλίας: &nbsp; </p><p><?php echo $_SESSION['tmima']; ?></p>
                            
						</div>
						<div class="column">
							<p id="titloi">Τρέχουσα εβδομάδα εξαμήνου: &nbsp; </p><p><?php echo $_SESSION['ebdomadaDidaskalias']; ?>η εβδομάδα</p>
                            <p id="titloi">Αριθμός εγγεγραμμένων μαθητών στο μάθημα: &nbsp; </p><p><?php echo $countMathima; ?></p>
                            <p id="titloi">Αριθμός μαθητών στο τμήμα: &nbsp; </p><p><?php echo $countTmima; ?></p>
						</div>
					</div>
                    <div id="swma2" style="display: none" align="center">
                       
                        <iframe src="about:blank" id="frame1" name="frame1" frameborder="0" width="80%" scrolling="no" height="220%"></iframe>
                    </div>
                    <div id="swma3" style="display: none" align="center">
                        
                        <iframe src="about:blank" id="frame2" name="frame2" frameborder="0" width="80%" scrolling="no" height="240%"></iframe>
                    </div>
                    <div id="swma4" style="display: none" align="center">
                        
                        <iframe src="about:blank" id="frame3" name="frame3" frameborder="0" width="90%" scrolling="no" height="600%"></iframe>
                    </div>
                    <div id="swma5" style="display: none" align="center">
                        
                        <iframe src="about:blank" id="frame4" name="frame4" frameborder="0" width="90%" scrolling="no" height="600%"></iframe>
                    </div>
                    <div id="swma6" style="display: none" align="center">
                        
                        <iframe src="about:blank" id="frame5" name="frame5" frameborder="0" width="90%" scrolling="no" height="600%"></iframe>
                    </div>
                    <div class="related">
							<p><button id="showMenu"> <i class="feature-icon fa fa-reply"></i> Κεντρικό Μενού</button></p>
                    </div>
                    <!-- /main -->
				</div><!-- wrapper -->
			</div><!-- /container -->
			<nav class="outer-nav left vertical">
				<a class="icon-home" id="epilogi1" href="#"> Αρχική</a>
				<a class="icon-news" id="epilogi2" href="uploadfile.php" target="frame1"> Αρχεία διδακτικού υλικού</a>
				<a class="icon-image" id="epilogi3" href="uploadfile2.php" target="frame2"> Κεφάλαια διδασκαλίας</a>
				<a class="icon-upload" id="epilogi4" href="uploadfile3.php" target="frame3"> Γραπτές εργασίες</a>
				<a class="icon-star" id="epilogi5" href="uploadfile4.php" target="frame4"> Ανακοινώσεις / Έρευνες</a>
				<a class="icon-mail" id="epilogi6" href="uploadfile5.php" target="frame5">Μαθητές και διδασκαλία</a>
				<a class="icon-lock" href="logout.php" >Αποσύνδεση</a>
			</nav>
		</div><!-- /perspective -->
		<script src="js/classie.js"></script>
		<script src="js/menu.js"></script>
	</body>
</html>