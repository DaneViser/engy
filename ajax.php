<?php
session_start();
$db = mysqli_connect("localhost", "root", "", "engy");

if (!$db) {
    echo "ERROR WITH DB CONNECTION" . mysqli_connect_errno();
    echo "<br>" . mysqli_connect_error();
    exit();
}

mysqli_query($db, "SET NAMES utf8");

$f = $_GET['f'];

if($f == "insertRow"){
    $currUser = $_SESSION['id_user'];
    $ins_customer = $_POST["ins_customer"];
    $ins_prod     = $_POST["ins_prod"];
    $ins_traff    = $_POST["ins_traff"];
    $ins_maincomp = $_POST["ins_maincomp"];
    $ins_dest     = $_POST["ins_dest"];
    $ins_looking  = $_POST["ins_looking"];
    $ins_pot      = $_POST["ins_pot"];
    $ins_act      = $_POST["ins_act"];
    $ins_next     = $_POST["ins_next"];
    $ins_result   = $_POST["ins_result"];
    $ins_datecomm = $_POST["ins_datecomm"];

    $stmt = $db->prepare("INSERT INTO `data`(`customer`, `prod`, `traff`, `maincomp`, `dest`, `looking`, `pot`, `act`, `next`, `result`, `datecomm`, `user`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('sssssssssssi',$ins_customer,$ins_prod    ,$ins_traff   ,$ins_maincomp,$ins_dest    ,$ins_looking ,$ins_pot     ,$ins_act     ,$ins_next    ,$ins_result  ,$ins_datecomm, $currUser);
    $stmt->execute();
    
    $rez = $stmt->get_result();
    echo $rez;

}



if($f == "fillDataTable"){
    $currUser = $_SESSION['id_user'];
    $stmt = $db->prepare("SELECT * FROM data WHERE user = ?");
    $stmt->bind_param('i', $currUser);
    $stmt->execute();

    $rez = $stmt->get_result();
    if(mysqli_num_rows($rez) > 0){
        while($red = mysqli_fetch_object($rez)){
        echo '<tr>
        <th id="'.$red->data_id.'customer"  contenteditable style="max-width:1px" scope="row"       >'.$red->customer.'</th>
        <td id="'.$red->data_id.'prod"      contenteditable style="max-width:1px"                   >'.$red->prod.'</td>
        <td id="'.$red->data_id.'traff"     contenteditable style="max-width:1px"                   >'.$red->traff.'</td>
        <td id="'.$red->data_id.'maincomp"  contenteditable style="max-width:1px"                   >'.$red->maincomp.'</td>
        <td id="'.$red->data_id.'dest"      contenteditable style="max-width:1px"                   >'.$red->dest.'</td>
        <td id="'.$red->data_id.'looking"   contenteditable style="max-width:1px"                   >'.$red->looking.'</td>
        <td id="'.$red->data_id.'pot"       contenteditable style="max-width:1px"                   >'.$red->pot.'</td>
        <td id="'.$red->data_id.'act"       contenteditable style="max-width:1px"                   >'.$red->act.'</td>
        <td id="'.$red->data_id.'next"      contenteditable style="max-width:1px"                   >'.$red->next.'</td>
        <td id="'.$red->data_id.'result"    contenteditable style="max-width:1px"                   >'.$red->result.'</td>
        <td id="'.$red->data_id.'datecomm"  contenteditable style="max-width:1px"                   >'.$red->datecomm.'</td>

        <td><button id="sendToArchive" onclick="sendToArch('.$red->data_id.')">SEND TO ARCHIVE</button></td>
        </tr>';
        }
    }
}
if($f == "prijava"){
    $korIme = $_POST['korIme'];
    $pass = $_POST['pass'];

    $stmt = $db->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param('s', $korIme);
    $stmt->execute();

    $rez = $stmt->get_result();

    if(mysqli_num_rows($rez) > 0){
        $red = mysqli_fetch_object($rez);
        if($red->password != $pass){
            echo "Lozinka za korisnika $red->first_name $red->last_name nije ispravna!";
        }
        else{
            $_SESSION['user'] = "$red->first_name $red->last_name";
            $_SESSION['username'] = "$red->username";
            $_SESSION['status'] = $red->role;
            $_SESSION['id_user'] = $red->id_user;
            echo "prijavljen.php";
        }
    }
    else{
        echo "Korisnik ne postoji!";
    }
}
?>