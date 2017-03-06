<?php
session_start();
include 'class.php';
$time_frame = 1.0;
$dbhandler = new DatabaseHandler;
$value = $dbhandler->selectAll("transaction");
$link =$dbhandler->connectToDB();
$date = array();
$time = array();
$id = array();
$paid= array();
$topay= array();
if ($value != null) {
    while ($temp = mysqli_fetch_array($value)) {
        $date[] = $temp["date"];
        $time[] = $temp["time"];
        $id[] = $temp["id"];
        $topay[] = $temp["topay"];
        $paid[] = $temp["paid"];
    }
    
    for ($i = 0; $i < sizeof($date); $i++) {
        $t1 = strtotime($date[$i] . " " . $time[$i]);
        $t2 = strtotime(date("Y-m-d") . " " . date("H:i:s"));
        $time_diff = ($t2 - $t1) / 60;       
        echo $time_diff."<br>";
        if ($time_diff > $time_frame && $paid[$i] == null && $topay[$i] != null){
            processCancel($id[$i]);
            echo "deleted".$id[$i];
}

    }
}

function processCancel($id1){
    global $dbhandler;
    $state1 = $dbhandler->getRef("transaction",$id1);
    if($state1 != null){
        extract(mysqli_fetch_array($state1));
        if($idref1 == $id1){
            $state2 = $dbhandler->resetRef("transaction",$id, "idref1","ref1");
        }else{
            if($idref2 == $id1){
              $state2 = $dbhandler->resetRef("transaction",$id, "idref2","ref2");
            }
        }
        $dbhandler->recyclebin("transaction", $id1);
        $dbhandler->deleteph("transaction", $id1);
        $dbhandler->deleteph("blacklist", $id1);
    }
}
?>
