<?php
include('session.php');
$mathima = $_SESSION['mathima'];
$anebikeapo = $_SESSION['login_user'];
if(isset($_REQUEST['type']) && !empty($_REQUEST['type'])){
    $type = $_REQUEST['type'];
    switch($type){ 
        case "view":       
            $query = $db->query("SELECT IDannouncement, anebikeApo, mathima, thema, titlos, left(periexomeno,50) as periexomeno, imerominia FROM eduplatform.announcements WHERE mathima = '$mathima' ");
            while ($row = $query->fetch_assoc()) {
                //$row['periexomeno'] = str_ireplace('<p>','',$row['periexomeno']);
                //$row['periexomeno'] = str_ireplace('</p>','',$row['periexomeno']);
                $row['periexomeno'] = strip_tags($row['periexomeno']);
                $row['periexomeno'] = str_ireplace('"','',$row['periexomeno']);
                $data[] = $row;
            }
            if (!isset($data)) $data = 'NO DATA';
            echo json_encode($data);
            break;
        case "add":
            if(!empty($_POST['data'])){
                $db2 = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
                
                date_default_timezone_set('Europe/Athens');
                $date = date_create();
                $timestamp = "announce" . $anebikeapo . date_timestamp_get($date);
                $date = date("d-m-Y");
                $periexomeno = str_ireplace('"','',$_POST['data']['periexomeno']);
                
                $sql = "INSERT INTO eduplatform.announcements values (:idannounce, :anebike, :mathima, :thema, :titlos, :periexomeno, :imerominia)";
                $insert = $query = $db2->prepare($sql);
                $query->execute(array(":idannounce"=>$timestamp,":anebike"=> $anebikeapo, ":mathima"=> $mathima, ":thema"=> $_POST['data']['thema'], ":titlos"=> $_POST['data']['titlos'], ":periexomeno"=> $periexomeno, ":imerominia"=> $date));
                
                $db = mysqli_connect('localhost','root','','eduplatform');
                mysqli_set_charset($db,"utf8");
                
                $queryy = $db->query("SELECT * FROM eduplatform.students_courses WHERE mathimaMathiti = '$mathima' ");
                while ($row2 = $queryy->fetch_assoc()) {
                    $username = $row2['onomaMathiti'];
                    $sql = "INSERT INTO eduplatform.students_announcements values (:idannounce, :user, :seen)";
                    $query = $db2->prepare($sql);
                    $query->execute(array(":idannounce"=>$timestamp,":user"=> $username, ":seen"=> "0"));
                } 
                   
                if($insert){
                    $data['data'] = $insert;
                    $data['status'] = 'OK';
                    $data['msg'] = 'Η ανακοίνωση προστέθηκε με επιτυχία!';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Προέκυψε κάποιο πρόβλημα, παρακαλώ προσπαθήστε ξανά';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = 'Προέκυψε κάποιο πρόβλημα, παρακαλώ προσπαθήστε ξανά';
            }
            echo json_encode($data);
            break;
        case "viewDimoskopiseis":
            $query = $db->query("SELECT posesApantiseis.IDpoll, titlos, periexomeno, imerominia, posesApantiseis, FLOOR((posaNAi/posesApantiseis)*100) as tisekatoNAI FROM (SELECT IDpoll, COUNT(*) as posesApantiseis FROM polls_answers GROUP BY IDpoll) posesApantiseis INNER JOIN (SELECT polls.IDpoll, titlos, periexomeno, polls.imerominia, COUNT(*) as posaNai FROM polls LEFT JOIN polls_answers ON polls.IDpoll = polls_answers.IDpoll WHERE polls.mathima = '$mathima' AND apantisi = 'NAI' GROUP BY polls.IDpoll) dimoskopiseisPosaNai ON posesApantiseis.IDpoll = dimoskopiseisPosaNai.IDpoll");
            $counter = 1;
            while ($row = $query->fetch_assoc()) {
                $data['dimoskopisi'][$counter] = $row;
                $ergasia = $row['IDpoll'];
                $query2 = $db->query("SELECT onoma, epwnumo, AMmathiti, email, apantisi, imerominia FROM (SELECT username, apantisi, imerominia FROM polls_answers WHERE IDpoll = '$ergasia') mathitesApantiseis INNER JOIN students ON mathitesApantiseis.username = students.username ");
                while ($row2 = $query2->fetch_assoc()) {
                    $data['dimoskopisi'][$counter]['mathites'][] = $row2;
                }
                $counter = $counter + 1;
            }
            if (!isset($data)) $data = 'NO DATA';
            echo json_encode($data);
            break;
        case "saveDimoskopisi":
            if(!empty($_POST['data'])){
                $db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
                
                date_default_timezone_set('Europe/Athens');
                $date = date_create();
                $timestamp = "poll" . $anebikeapo . date_timestamp_get($date);
                $date = date("d-m-Y");

                $sql = "INSERT INTO eduplatform.polls values (:idpoll, :anebike, :mathima, :titlos, :periexomeno, :imerominia)";
                $insert = $query = $db->prepare($sql);
                $query->execute(array(":idpoll"=>$timestamp,":anebike"=> $anebikeapo, ":mathima"=> $mathima, ":titlos"=> $_POST['data']['titlosDimoskop'], ":periexomeno"=> $_POST['data']['periexomenoDimoskop'], ":imerominia"=> $date));
                
                if($insert){
                    $data['data'] = $insert;
                    $data['status'] = 'OK';
                    $data['msg'] = ' Επιτυχής καταχώρηση!';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = ' Αποτυχία, προσπαθήστε ξανά';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = ' Αποτυχία, προσπαθήστε ξανά';
            }
            echo json_encode($data);
            break;
        case "delete":
            if(!empty($_POST['id'])){
                $db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
                
                $sql = "DELETE FROM eduplatform.announcements WHERE IDannouncement = :id";
                $query = $db->prepare($sql);
                $delete = $query->execute(array(":id"=>$_POST['id']));
                
                $sql = "DELETE FROM eduplatform.students_announcements WHERE IDannouncement = :id";
                $query = $db->prepare($sql);
                $delete = $query->execute(array(":id"=>$_POST['id']));
                
                if($delete){
                    $data['status'] = 'OK';
                    $data['msg'] = 'Η ανακοίνωση διαγράφηκε με επιτυχία!';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Προέκυψε κάποιο πρόβλημα, παρακαλώ προσπαθήστε ξανά';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = 'Προέκυψε κάποιο πρόβλημα, παρακαλώ προσπαθήστε ξανά';
            }
            echo json_encode($data);
            break;
        case "deleteDimoskopisi":
            if(!empty($_POST['id'])){
                $db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
                
                $sql = "DELETE FROM eduplatform.polls WHERE IDpoll = :id";
                $query = $db->prepare($sql);
                $delete = $query->execute(array(":id"=>$_POST['id']));
                
                $sql = "DELETE FROM eduplatform.polls_answers WHERE IDpoll = :id";
                $query = $db->prepare($sql);
                $query->execute(array(":id"=>$_POST['id']));
                
                if($delete){
                    $data['status'] = 'OK';
                    $data['msg'] = 'Επιτυχής διαγραφή!';
                }else{
                    $data['status'] = 'ERR';
                    $data['msg'] = 'Προέκυψε κάποιο πρόβλημα, παρακαλώ προσπαθήστε ξανά';
                }
            }else{
                $data['status'] = 'ERR';
                $data['msg'] = 'Προέκυψε κάποιο πρόβλημα, παρακαλώ προσπαθήστε ξανά';
            }
            echo json_encode($data);
            break;
        default:
            echo '{"status":"INVALID"}';
    }
}
?>