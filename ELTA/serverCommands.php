<?php
include('config.php');
session_start();
date_default_timezone_set('Europe/Athens');
//$db = new PDO("mysql:host=localhost;dbname=eduplatform;charset=utf8", "root", "");
if(isset($_REQUEST['type']) && !empty($_REQUEST['type'])){
    $type = $_REQUEST['type'];
    switch($type){ 
        case "test":
            $json = file_get_contents('http://yugiohprices.com/api/card_data/Reasoning');
            $obj = json_decode($json); 
            echo json_encode($obj);
        case "checkStoreStatus":
            //Find client's store and number
            $emailPelati = $_POST['user'];
            $sql = "SELECT * FROM arithmoi WHERE emailClient = '$emailPelati' ";
            $result = mysqli_query($db,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $katastima = $row['IDstore'];
            $arithmosPelati = $row['number'];
            
            //Get the store's information
            $sql = "SELECT * FROM katastimataelta WHERE IDkatastimatos = '$katastima' ";
            $result = mysqli_query($db,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            
            //Get logged in employees
            $sql = "SELECT COUNT(*) as posoi FROM ergazomenoi WHERE katastimaErgasias = '$katastima' AND online = 1";
            $result = mysqli_query($db,$sql);
            $row2 = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $row['posoiOnline'] = $row2['posoi'];
            $row['arithmosPelati'] = $arithmosPelati;
            
            //Get number of people waiting in line in front of the client and estimated delay time
            $sql = "SELECT COUNT(*) as posoi, SUM(timeCost) as posiWra FROM arithmoi WHERE IDstore = '$katastima' AND emailClient NOT LIKE '$emailPelati' AND number < '$arithmosPelati' ";
            $result = mysqli_query($db,$sql);
            $row2 = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $row['posoiPerimenoun'] = $row2['posoi'];
            if ($row['posoiPerimenoun'] == 0)
                $row['posiKathusterisi'] = 0;
            else       
                $row['posiKathusterisi'] = $row2['posiWra'];
            
            //Get number of people waiting behind the client
            $sql = "SELECT COUNT(*) as posoi FROM arithmoi WHERE IDstore = '$katastima' AND emailClient NOT LIKE '$emailPelati' AND number > '$arithmosPelati' ";
            $result = mysqli_query($db,$sql);
            $row2 = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $row['perimenounPiswApoPelati'] = $row2['posoi'];
            
            //Get clients that fall under the 15' time range
            $sql = "SELECT m.number AS posoi, SUM(m1.timeCost) AS total FROM arithmoi m INNER JOIN arithmoi m1 ON m1.number <= m.number WHERE  m.timeCost <= 15 GROUP  BY m.number HAVING SUM(m1.timeCost) <= 15 ORDER  BY total DESC LIMIT  1";
            $result = mysqli_query($db,$sql);
            $row2 = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $row['posaAtomaEntosTetartou'] = $row2['posoi'];
            //$row['posaAtomaPerimenoun2'] = $row2['total'];
            if ($row['posaAtomaEntosTetartou'] <=  $row['capacity']) {
                $row['capacity'] = $row['capacity'] - $row['posaAtomaEntosTetartou'];
            } else {
                $row['posaAtomaEntosTetartou'] = $row['capacity'];
                $row['capacity'] = 0;
            }
            
            echo json_encode($row);
            break;
        case "printNumber":
            $emailPelati = $_POST['user'];
            $IDkatastima = $_POST['katastima'];
            $douleia = $_POST['douleia'];
            
            //Costs for each work in time (seconds)
            switch ($douleia) {
                    case "SL":
                        $cost = 2;
                        break;
                    case "GL":
                        $cost = 1;
                        break;
                    case "SP":
                        $cost = 3;
                        break;
                    case "GP":
                        $cost = 2;
                        break;
                    default:
                        $cost = 3;
                }
            
            //Print number and check if this is the store's first client 
            $sql = "SELECT MAX(number) AS megaliterosArithmos FROM arithmoi WHERE IDstore = '$IDkatastima' ";
            $result = mysqli_query($db,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            if ($row['megaliterosArithmos'] > 0)
                $number = $row['megaliterosArithmos'] + 1;
            else
                $number = 1;
            $sql = "INSERT INTO arithmoi (IDstore, number, emailClient, workClient, timeCost) VALUES ('$IDkatastima', '$number', '$emailPelati','$douleia','$cost')";
            $db->query($sql);
            
            echo $number;
            break;
        case "destroyNumber":
            $emailPelati = $_POST['user'];
            $IDkatastima = $_POST['katastima'];
        
            $sql = "DELETE FROM arithmoi WHERE IDstore = '$IDkatastima' AND emailClient= '$emailPelati' ";
            $db->query($sql);
            
            echo "OK";
            break;            
        case "isConnected":
            if ( isset( $_SESSION['user_id'])) { 
                $connected['isCon'] = "YES";
                $connected['user'] = $_SESSION['user_id'];
            } else {
                $connected['isCon'] = "NO";
                $connected['user'] = null;
            }
            echo json_encode($connected);
            break;
        case "getCounty":
            $query = $db->query("SELECT * FROM elta.katastimataelta");
            while ($row = $query->fetch_assoc()) {
                $data[] = $row;
            }
            //return json data
            echo json_encode($data);
            break;
        case "checkEmail":
            if (!isset($_REQUEST['email'])) {
                $exists = false;
            } else {
                $email = $_REQUEST['email'];
                $query = $db->query("SELECT COUNT(*) as posa FROM pelates WHERE email = '$email' ");
                $posa = $query->fetch_assoc();
                $email = $posa['posa'];
                if ($email == 1)
                    $exists = 1;
                else
                    $exists = 0;
            }
            echo json_encode($exists);
            break;
        case "getEmployeeStore":
            $employee = $_REQUEST['user'];
            $sql = "SELECT * FROM ergazomenoi WHERE email = '$employee' ";
            $result = mysqli_query($db,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);
            if ($count == 0) {
                echo "not found";
                break;
            }
            $katastima = $row['katastimaErgasias'];
            
            $sql = "UPDATE ergazomenoi SET online=1 WHERE email='$employee' ";
            $db->query($sql);
            
            $query = $db->query("SELECT IDstore, number, emailClient, workClient, city, numberServiced FROM arithmoi RIGHT JOIN katastimataelta ON IDkatastimatos = IDstore WHERE IDstore = '$katastima' ORDER BY number ASC" );
            while ($row = $query->fetch_assoc()) {
                switch ($row['workClient']) {
                    case "SL":
                        $row['workClient'] = "αποστολή γράμματος";
                        break;
                    case "GL":
                        $row['workClient'] = "παραλαβή γράμματος";
                        break;
                    case "SP":
                        $row['workClient'] = "αποστολή δέματος";
                        break;
                    case "GP":
                        $row['workClient'] = "παραλαβή δέματος";
                        break;
                    case "ΟΤ":
                        $row['workClient'] = "λοιπές συναλλαγές";
                        break;
                    default:
                        $row['workClient'] = "άγνωστο";
                } 
                $plirofories[] = $row;
            }
            
            echo json_encode($plirofories);
            break;   
        case "getEmployeeStoreNumber":
            $employee = $_REQUEST['user'];
            $sql = "SELECT * FROM ergazomenoi WHERE email = '$employee' ";
            $result = mysqli_query($db,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $katastima = $row['katastimaErgasias'];
            
            $sql = "SELECT * FROM katastimataelta WHERE IDkatastimatos = '$katastima' ";
            $result = mysqli_query($db,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $numberServiced = $row['numberServiced'];
            
            echo $numberServiced;
            break;
        case "nextStoreNumber":
            $employee = $_REQUEST['user'];
            $sql = "SELECT * FROM ergazomenoi WHERE email = '$employee' ";
            $result = mysqli_query($db,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $katastima = $row['katastimaErgasias'];
            
            $sql = "SELECT * FROM katastimataelta WHERE IDkatastimatos = '$katastima' ";
            $result = mysqli_query($db,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $numberServiced = $row['numberServiced'] + 1;
            
            $sql = "UPDATE katastimataelta SET numberServiced='$numberServiced' WHERE IDkatastimatos='$katastima' ";
            $db->query($sql);
            
            //Delete all previous numbers (we are assuming they have already been serviced)
            $sql = "DELETE FROM arithmoi WHERE IDstore = '$katastima' AND number < '$numberServiced' ";
            $db->query($sql);
            
            echo $numberServiced;
            break;
        case "logoutEmployee":
            $employee = $_REQUEST['user'];
            $sql = "UPDATE ergazomenoi SET online=0 WHERE email='$employee' ";
            $db->query($sql);
            
            echo "OK";
            break;
        case "createAccount":
            $pass = password_hash($_REQUEST['pass'], PASSWORD_DEFAULT);
            $db = new PDO("mysql:host=localhost;dbname=elta;charset=utf8", "root", "");
            $sql = "INSERT INTO pelates values (:email, :pass, :date)";
            $query = $db->prepare($sql);
            $query->execute(array(":email"=>$_REQUEST['user'], ":pass"=> $pass, ":date"=> date("d/m/Y"))); 
            echo "OK";
            break;
        case "checkNewsletter":
            $email = $_REQUEST['user'];
            $query = $db->query("SELECT COUNT(*) as posa FROM newsletter WHERE email = '$email' ");
            $posa = $query->fetch_assoc();
            $exists = $posa['posa'];
            if ($exists == 0) {
                $db = new PDO("mysql:host=localhost;dbname=elta;charset=utf8", "root", "");
                $sql = "INSERT INTO newsletter values (:email, :date)";
                $query = $db->prepare($sql);
                $query->execute(array(":email"=>$email, ":date"=> date("d/m/Y")));
                $exists = 0;
            }
            echo json_encode($exists);
            break;
        default:
            echo '{"status":"INVALID"}';
    }
}

//mysqli_close($db);
?>