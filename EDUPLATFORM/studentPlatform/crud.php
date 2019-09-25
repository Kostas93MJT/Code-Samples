<?php
include('session.php');
date_default_timezone_set('Europe/Athens');
//$db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
if(isset($_REQUEST['type']) && !empty($_REQUEST['type'])){
    $type = $_REQUEST['type'];
    switch($type){ 
        case "EggegrammenaMathimata":
            $mathitis = $_SESSION['login_user'];
            $query = $db->query("SELECT * FROM eduplatform.students_courses WHERE onomaMathiti LIKE '$mathitis' ");
            while ($row = $query->fetch_assoc()) {
                $data[] = $row['mathimaMathiti'];
            }
            $userID = $_SESSION['login_user'];
            
            $greekMonths = array('Ιανουαρίου','Φεβρουαρίου','Μαρτίου','Απριλίου','Μαΐου','Ιουνίου','Ιουλίου','Αυγούστου','Σεπτεμβρίου','Οκτωβρίου','Νοεμβρίου','Δεκεμβρίου');
            $greekdays = array('Δευτέρα','Τρίτη','Τετάρτη','Πέμπτη','Παρασκευή','Σάββατο','Κυριακή');
            $newformat = date('Y-m-d h:i A', strtotime($_SESSION['lastLogin']));        
            if( date('A', strtotime($newformat)) == "AM" )
                $ampm = "πμ";
            else
                $ampm = "μμ";
            $imerominiaLogin = date('j', strtotime($newformat)).' '.$greekMonths[date('m', strtotime($newformat))-1]. ' '. date('Y', strtotime($newformat)) . ', ' . date('h', strtotime($newformat)) . ':' . date('i', strtotime($newformat)) . ' ' . $ampm; // . ' '. $date;
            
            $newformat = date('Y-m-d', strtotime($_SESSION['imerominiaGennisis']));
            $imerominiaGennisis = date('j', strtotime($newformat)).' '.$greekMonths[date('m', strtotime($newformat))-1]. ' '. date('Y', strtotime($newformat)); // . ' '. $date;
            
            $ebdomadaDidaskalias = date("d-m-Y");
            $ebdomadaDidaskalias = date('d-m-Y', strtotime('previous monday', strtotime($ebdomadaDidaskalias)));
            $query = $db->query("SELECT * FROM teaching_weeks WHERE teaching_weeks.arxi = '$ebdomadaDidaskalias' ");
            $row = $query->fetch_assoc();
            $ebdomadaDidaskalias = $row['ebdomada']; 
            
            $query = $db->query("SELECT helper FROM students WHERE students.username = '$mathitis' ");
            $row = $query->fetch_assoc();
            $helper = $row['helper'];
            //return json data
            echo json_encode(array($data, $userID, $imerominiaLogin, $imerominiaGennisis, $ebdomadaDidaskalias, $helper));
            break;
        case "getTmimaDaskalos":
            $mathitis = $_POST['data']['name'];
            $mathima = $_POST['data']['id'];
            $AMmathitis = $_SESSION['AMmathiti'];
            $query = $db->query("SELECT * FROM eduplatform.students_courses WHERE onomaMathiti = '$mathitis' AND mathimaMathiti = '$mathima' ");
            $row = $query->fetch_assoc();
            $data['tmima'] = $row['tmimaMathiti'];
            $temp = $row['tmimaMathiti'];
            $query = $db->query("SELECT * FROM eduplatform.professors WHERE tmima LIKE '$temp' ");
            $row = $query->fetch_assoc();
            $data['kathigitisOnoma'] = $row['onoma'] . ' ' . $row['epwnumo'];
            $data['kathigitisEmail'] = $row['email'];
            $data['kathigitisUsername'] = $row['username'];
            $query = $db->query("SELECT * FROM eduplatform.students_algorithm_data WHERE AMmathiti = '$AMmathitis' AND mathima = '$mathima' ");
            $row = $query->fetch_assoc();
            $data['epipedoGnwsis'] = $row['tieinai'];
            echo json_encode($data);
            break;
        case "getUserPolls":
            $mathitis = $_SESSION['login_user'];
            $query = $db->query("SELECT mathimaMathiti, mathiteskaiPolls.IDpoll as IDpoll, titlos, periexomeno, mathiteskaiPolls.imerominia as imerominia, polls_answers.imerominia as imerominiaanswer, apantisi FROM (SELECT * FROM (SELECT username, mathimaMathiti FROM students INNER JOIN students_courses ON students.username = students_courses.onomaMathiti WHERE username = '$mathitis') mathimataFoititi INNER JOIN polls ON mathimataFoititi.mathimaMathiti = polls.mathima) mathiteskaiPolls LEFT JOIN polls_answers ON mathiteskaiPolls.IDpoll = polls_answers.IDpoll AND mathiteskaiPolls.username = polls_answers.username ORDER BY imerominia DESC LIMIT 19");
            while ($row = $query->fetch_assoc()) {
                $pollID = $row['IDpoll'];
                $query2 = $db->query("SELECT COUNT(*) as posaNai FROM polls_answers WHERE apantisi = 'NAI' AND IDpoll = '$pollID' ");
                $temp = $query2->fetch_assoc();
                $pollIDposaNai = $temp['posaNai'];
                $query2 = $db->query("SELECT COUNT(*) as posa FROM polls_answers WHERE IDpoll = '$pollID' ");
                $temp = $query2->fetch_assoc();
                $pollIDposa = $temp['posa'];
                if ($row['imerominiaanswer'] == NULL) {
                    $col['IDpoll'] = $row['IDpoll'];
                    $col['titlos'] = $row['titlos'];
                    $col['periexomeno'] = $row['periexomeno'];
                    $col['mathima'] = $row['mathimaMathiti'];
                    $col['imerominia'] = $row['imerominia'];
                    $col['imerominiaanswer'] = 'EMPTY';
                    $col['posa'] = $pollIDposa;
                    $col['posaNai'] = $pollIDposaNai;
                    $col['apantisi'] = '';
                    $col['edwseApantisi'] = false;
                    $data[] = $col;
                } else {
                    $col['IDpoll'] = $row['IDpoll'];
                    $col['titlos'] = $row['titlos'];
                    $col['periexomeno'] = $row['periexomeno'];
                    $col['mathima'] = $row['mathimaMathiti'];
                    $col['imerominia'] = $row['imerominia'];
                    $col['imerominiaanswer'] = $row['imerominiaanswer'];
                    $col['posa'] = $pollIDposa;
                    $col['posaNai'] = $pollIDposaNai;
                    $col['apantisi'] = $row['apantisi'];
                    $col['edwseApantisi'] = true;
                    $data[] = $col;
                }
            }
            if (!isset($data)) $data = 'NO DATA';
            echo json_encode($data);
            break; 
        case "addUserPollanswer":
            $date = date("d-m-Y");
            $db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
            $sql = "INSERT INTO eduplatform.polls_answers values (:id, :user, :apantisi, :imerominia)";
            $query = $db->prepare($sql);
            $query->execute(array(":id"=>$_POST['data']['IDpoll'], ":user"=> $_SESSION['login_user'], ":apantisi"=> $_POST['data']['apantisi'], ":imerominia"=> $date)); 
            echo "OK";
            break;
        case "algorithmNotifications":
            $mathitis = $_SESSION['login_user'];
            $query = $db->query("SELECT tieinai, helper FROM students_algorithm_data INNER JOIN students ON students_algorithm_data.AMmathiti = students.AMmathiti WHERE username = '$mathitis' ");
            $row = $query->fetch_assoc();
            $helper = $row['helper'];
            switch($row['tieinai']){
                case "ΑΡΧΑΡΙΟ":
                    $tieinai = "ΑΡΧΑΡΙΟ";
                    $tieinaiPlus = "ΚΑΝΟΝΙΚΟ";
                    break;
                case "ΚΑΝΟΝΙΚΟ":
                    $tieinai = "ΚΑΝΟΝΙΚΟ";
                    $tieinaiPlus = "ΥΨΗΛΟ";
                    break;
                case "ΥΨΗΛΟ":
                    $tieinai = "ΥΨΗΛΟ";
                    $tieinaiPlus = "ΠΟΛΥ ΥΨΗΛΟ";
                    break;
                case "ΠΟΛΥ ΥΨΗΛΟ":
                    $tieinai = "ΠΟΛΥ ΥΨΗΛΟ";
                    $tieinaiPlus = "ΠΟΛΥ ΥΨΗΛΟ";
                    break;
            }
            $query = $db->query("SELECT * FROM material INNER JOIN students_courses ON material.mathima = students_courses.mathimaMathiti WHERE (gnwsiakoEpipedo = '$tieinai' OR gnwsiakoEpipedo = '$tieinaiPlus') AND onomaMathiti = '$mathitis' ");
            while ($row = $query->fetch_assoc()) {
                $col['mathima'] = $row['mathima'];
                $col['titlos'] = $row['titlosArxeiou'];
                $col['biblio'] = $row['biblio'];
                $col['helper'] = $helper;
                if ($row['gnwsiakoEpipedo'] == $tieinai) 
                    $col['gnwsiako'] = 'idio';
                else
                    $col['gnwsiako'] = 'anwtero';
                $data[] = $col;
            }
            echo json_encode($data);
            break;
        case "viewProgramma":
            $mathitis = $_SESSION['login_user'];
            $query = $db->query("SELECT titlosArxeiou, mathima, ebdomada, arxi, telos FROM (SELECT titlosArxeiou, ebdomadaDidaskalias, mathima FROM (SELECT titlosArxeiou, biblio, ebdomadaDidaskalias,mathima FROM material UNION SELECT arithmos, IDergasias, ebdomadaDidaskalias, mathima FROM assignments UNION SELECT OSS, IDmeeting, ebdomada, mathima FROM meetings) programma INNER JOIN students_courses ON programma.mathima = students_courses.mathimaMathiti WHERE onomaMathiti = '$mathitis') programmaMathiti INNER JOIN teaching_weeks ON programmaMathiti.ebdomadaDidaskalias = teaching_weeks.ebdomada");
            while ($row = $query->fetch_assoc()) {
                if (strlen($row['titlosArxeiou']) == 1) {
                    $col['titlos'] = $row['titlosArxeiou'] . "η ΓΡΑΠΤΗ ΕΡΓΑΣΙΑ ";
                    $col['mathima'] = $row['mathima'];
                    $col['tieinai'] = "proj";
                    $col['arxi'] = date('Y-m-d', strtotime($row['arxi']));
                    $col['telos'] = date('Y-m-d', strtotime($row['telos']));
                    $data[] = $col;
                } elseif (mb_substr($row['titlosArxeiou'], 0, 3) == "ΟΣΣ") {
                    $col['titlos'] = "Συνάντηση " . $row['titlosArxeiou'];
                    $col['mathima'] = $row['mathima'];
                    $col['tieinai'] = "meet";
                    $col['arxi'] = date('Y-m-d', strtotime($row['arxi']));
                    $col['telos'] = date('Y-m-d', strtotime($row['telos']));
                    $data[] = $col;
                } else {
                    $col['titlos'] = $row['titlosArxeiou'];
                    $col['mathima'] = $row['mathima'];
                    $col['tieinai'] = "item";
                    $col['arxi'] = date('Y-m-d', strtotime($row['arxi']));
                    $col['telos'] = date('Y-m-d', strtotime($row['telos']));
                    $data[] = $col;
                }
            }
            if (!isset($data)) $data = 'NO DATA';
            echo json_encode($data);
            break;
        case "getNotifications":
            $mathitis = $_SESSION['login_user'];
            $db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
            $statement = $db->query("SELECT announcements.IDannouncement, announcements.thema, announcements.imerominia, announcements.mathima, students_announcements.username FROM students_announcements INNER JOIN announcements ON students_announcements.IDannouncement = announcements.IDannouncement WHERE username = '$mathitis' AND seen = 0");
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            echo '{ "records":';
            echo json_encode($statement->fetchAll());
            echo "}";
            break;
        case "notificationsSeen":
            $mathitis = $_SESSION['login_user'];
            $db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
            $sql = "DELETE FROM eduplatform.students_announcements WHERE username = :id AND seen = :see";
            $query = $db->prepare($sql);
            $delete = $query->execute(array(":id"=>$mathitis, ":see"=> 0 ));
            echo "OK";
            break;
        case "getAllAnnouncements":
            $mathitis = $_SESSION['login_user'];
            $db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
            $statement = $db->query("SELECT * FROM announcements INNER JOIN students_courses ON announcements.mathima = students_courses.mathimaMathiti WHERE students_courses.onomaMathiti = '$mathitis' ORDER BY announcements.imerominia DESC LIMIT 30");
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            echo '{ "records":';
            echo json_encode($statement->fetchAll());
            echo "}";
            break;
        case "getAllAnnouncementsByMathima":
            $mathitis = $_POST['data']['name'];
            $mathima = $_POST['data']['id'];
            $db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
            $statement = $db->query("SELECT * FROM announcements INNER JOIN students_courses ON announcements.mathima = students_courses.mathimaMathiti WHERE students_courses.onomaMathiti = '$mathitis' AND mathima = '$mathima' ORDER BY announcements.imerominia DESC LIMIT 20");
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            echo '{ "records":';
            echo json_encode($statement->fetchAll());
            echo "}";
            break;
        case "getSummathitesGnwsiako":
            $mathitis = $_POST['data']['name'];
            $mathima = $_POST['data']['id'];
            $AMmathiti = $_SESSION['AMmathiti'];
            $query = $db->query("SELECT * FROM students_algorithm_data WHERE AMmathiti = '$AMmathiti' AND mathima = '$mathima' ");
            $row2 = $query->fetch_assoc();
            $gnwsiakoFoititi = $row2['tieinai'];
            $query = $db->query("SELECT username, onoma, epwnumo, email, tmimaMathiti, tieinai FROM (SELECT username, onoma, epwnumo, email, AMmathiti, tmimaMathiti, mathimaMathiti FROM students INNER JOIN students_courses ON students.username = students_courses.onomaMathiti WHERE mathimaMathiti = '$mathima'AND NOT username = '$mathitis') mathitesMathimatos INNER JOIN students_algorithm_data ON mathitesMathimatos.AMmathiti = students_algorithm_data.AMmathiti AND mathitesMathimatos.mathimaMathiti = students_algorithm_data.mathima");
            switch($gnwsiakoFoititi){
                case "ΑΡΧΑΡΙΟ":
                    while ($row = $query->fetch_assoc()) {
                        if ($row['tieinai'] == "ΑΡΧΑΡΙΟ") {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#4db70b";
                            $data[] = $col;
                        } elseif ($row['tieinai'] == "ΚΑΝΟΝΙΚΟ") {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#186dcc";
                            $data[] = $col;
                        } else {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#000";
                            $data[] = $col;
                        }
                    }
                    break;
                case "ΚΑΝΟΝΙΚΟ":
                    while ($row = $query->fetch_assoc()) {
                        if ($row['tieinai'] == "ΑΡΧΑΡΙΟ") {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#ef910e";
                            $data[] = $col;
                        } elseif ($row['tieinai'] == "ΚΑΝΟΝΙΚΟ") {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#4db70b";
                            $data[] = $col;
                        } elseif ($row['tieinai'] == "ΥΨΗΛΟ") {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#186dcc";
                            $data[] = $col;
                        } else {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#000";
                            $data[] = $col;
                        }
                    }
                    break;
                case "ΥΨΗΛΟ":
                    while ($row = $query->fetch_assoc()) {
                        if ($row['tieinai'] == "ΚΑΝΟΝΙΚΟ") {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#ef910e";
                            $data[] = $col;
                        } elseif ($row['tieinai'] == "ΥΨΗΛΟ") {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#4db70b";
                            $data[] = $col;
                        } elseif ($row['tieinai'] == "ΠΟΛΥ ΥΨΗΛΟ") {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#186dcc";
                            $data[] = $col;
                        } else {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#000";
                            $data[] = $col;
                        }
                    }
                    break;
                case "ΠΟΛΥ ΥΨΗΛΟ":
                    while ($row = $query->fetch_assoc()) {
                        if ($row['tieinai'] == "ΥΨΗΛΟ") {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#ef910e";
                            $data[] = $col;
                        } elseif ($row['tieinai'] == "ΠΟΛΥ ΥΨΗΛΟ") {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#4db70b";
                            $data[] = $col;
                        } else {
                            $col['onoma'] = $row['onoma'];
                            $col['epwnumo'] = $row['epwnumo'];
                            $col['email'] = $row['email'];
                            $col['tmima'] = $row['tmimaMathiti'];
                            $col['xrwma'] = "#000";
                            $data[] = $col;
                        }
                    }
                    break;
            }
            if (!isset($data)) $data = 'NO DATA';
            echo json_encode($data);
            break;
        case "getDidaktikaYlika":
            $db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
            $temp = $_POST['data']['id'];
            $statement = $db->query("SELECT * FROM eduplatform.material WHERE mathima = '$temp' ");
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            echo '{ "records":';
            echo json_encode($statement->fetchAll());
            echo "}";
            break;
        case "aksiologisiYlikou":
            $mathitis = $_SESSION['login_user'];
            $idmat = $_POST['data']['IDmaterial'];
            $result = mysqli_query($db,"SELECT * FROM eduplatform.students_material WHERE username ='$mathitis' and IDmaterial = '$idmat' ");
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);
            $db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
            $date = date("d-m-Y");
            if ($count == 1) {
                $temp = $row['posesFores'] + 1;
                $sql = "UPDATE eduplatform.students_material SET posesFores= :times, teleutaiaProvoli= :teleutaia, theleiEpipleon= :epipleon, gnwsiakoEpipedo= :gnwsiako WHERE username= :user AND IDmaterial = :idmat";
                $query = $db->prepare($sql);
                $query->execute(array(":times"=> $temp, ":teleutaia"=> $date, ":epipleon"=> $_POST['data']['epipleonYliko'], ":user"=>$mathitis,":idmat"=> $idmat, ":gnwsiako"=> $_POST['data']['katanohsh']));   
            } else {
                $temp = 1;
                $sql = "INSERT INTO eduplatform.students_material values (:user, :idmat, :times, :theleiEpipleon, :teleutaiaProvoli, :gnwsiako)";
                $query = $db->prepare($sql);
                $query->execute(array(":user"=>$mathitis,":idmat"=> $_POST['data']['IDmaterial'], ":times"=> $temp, ":theleiEpipleon"=> $_POST['data']['epipleonYliko'], ":teleutaiaProvoli"=> $date, ":gnwsiako"=> $_POST['data']['katanohsh']));   
            }
            /* $sql = "DELETE FROM eduplatform.students_material_keywords WHERE username = :user AND IDmaterial = :idmat";
            $query = $db->prepare($sql);
            $delete = $query->execute(array(":user"=>$mathitis, ":idmat"=> $idmat));
            
            $db2 = mysqli_connect('localhost','root','','eduplatform');
            mysqli_set_charset($db2,"utf8");
            $query = $db2->query("SELECT * FROM eduplatform.material_keywords WHERE IDmaterial ='$idmat' ");
            $sql = "INSERT INTO eduplatform.students_material_keywords values (:user, :idmat, :key, :gnwsiako)";
            $query2 = $db->prepare($sql);
            while ($row = $query->fetch_assoc()) {
                $query2->execute(array(":user"=>$mathitis, ":idmat"=> $idmat, ":key"=> $row['keywords'], ":gnwsiako"=> $_POST['data']['katanohsh'] ));
            }; */
            break;
        case "getSliderValue":
            $mathitis = $_SESSION['login_user'];
            $idmat = $_POST['data']['IDmaterial'];
            $result = mysqli_query($db,"SELECT * FROM eduplatform.students_material WHERE username ='$mathitis' and IDmaterial = '$idmat' ");
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);
            if ($count == 1) {
                $data['epipleon'] = $row['theleiEpipleon'];
                $data['teleutaiaProv'] = $row['teleutaiaProvoli'];
                $data['teleutaiaProvTrue'] = true;
                $data['msg'] = 'YES';
                switch($row['gnwsiakoEpipedo']){
                    case 'ΚΑΘΟΛΟΥ': 
                        $data['gnwsiako'] = 1;
                        echo json_encode($data);
                        break;
                    case 'ΑΡΧΑΡΙΟ':
                        $data['gnwsiako'] = 2;
                        echo json_encode($data);
                        break;
                    case 'ΚΑΝΟΝΙΚΟ': 
                        $data['gnwsiako'] = 3;
                        echo json_encode($data);
                        break;
                    case 'ΥΨΗΛΟ':
                        $data['gnwsiako'] = 4;
                        echo json_encode($data);
                        break;
                    case 'ΠΟΛΥ ΥΨΗΛΟ':
                        $data['gnwsiako'] = 5;
                        echo json_encode($data);
                        break;
                }
            } else {
                $data['gnwsiako'] = 3;
                $data['msg'] = "NO";
                $data['teleutaiaProvTrue'] = false;
                echo json_encode($data);
            }
            break;
        case "getErgasiestemp":
            $mathitis = $_POST['data']['name'];
            $greekMonths = array('Ιανουαρίου','Φεβρουαρίου','Μαρτίου','Απριλίου','Μαΐου','Ιουνίου','Ιουλίου','Αυγούστου','Σεπτεμβρίου','Οκτωβρίου','Νοεμβρίου','Δεκεμβρίου');
            $greekdays = array('Δευτέρα','Τρίτη','Τετάρτη','Πέμπτη','Παρασκευή','Σάββατο','Κυριακή');
            /* $query = $db->query("SELECT assignments.IDergasias, arithmos, imeraParadosis, wraParadosis, ebdomadaDidaskalias, mathima, sxolia, onomaArxeiou, onomaMathiti, tmimaMathiti, onomaPDF FROM ((assignments LEFT JOIN students_courses ON assignments.mathima = students_courses.mathimaMathiti) LEFT JOIN students_assignments ON assignments.IDergasias = students_assignments.IDergasias) WHERE students_courses.onomaMathiti = '$mathitis' " ); */
            $query = $db->query("SELECT ergasiesMathimatwn.IDergasias, arithmos, imeraParadosis, wraParadosis, ebdomadaDidaskalias, mathima, sxolia, onomaArxeiou, onomaMathiti, tmimaMathiti, onomaPDF FROM (SELECT * FROM assignments LEFT JOIN students_courses ON assignments.mathima = students_courses.mathimaMathiti) ergasiesMathimatwn LEFT JOIN students_assignments ON ergasiesMathimatwn.IDergasias = students_assignments.IDergasias AND students_assignments.username = ergasiesMathimatwn.onomaMathiti WHERE onomaMathiti = '$mathitis' " );
            $today = date("d-m-Y");
            while ($row = $query->fetch_assoc()) {
                if (strtotime($today) <= strtotime($row['imeraParadosis'])) {
                    $newformat = date('Y-m-d', strtotime($row['imeraParadosis']));
                    $row['imeraParadosis'] = date('j', strtotime($newformat)).' '.$greekMonths[date('m', strtotime($newformat))-1]. ' '. date('Y', strtotime($newformat));
                    $row['wraParadosis'] = substr($row['wraParadosis'],0,5);
                    $data[] = $row;
                }
            }
            if (!isset($data)) $data = 'NO DATA';
            echo json_encode($data);
            break;
       /* case "getErgasies":
            $mathitis = $_POST['data']['name'];
            $db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
            $statement = $db->query("SELECT * FROM assignments LEFT JOIN students_courses ON assignments.mathima = students_courses.mathimaMathiti WHERE students_courses.onomaMathiti = '$mathitis' ");
            $statement->setFetchMode(PDO::FETCH_ASSOC);
            echo '{ "records":';
            echo json_encode($statement->fetchAll());
            echo "}";
            break; */
        default:
            echo '{"status":"INVALID"}';
    }
}
?>