<?php

include 'class.php';
$dbhandler = new DatabaseHandler;
$money = array("5000", "10000", "20000", "50000","100000");
for ($r = 0; $r < count($money); $r++) {
    $unmatched = $dbhandler->getAllunmatched($money[$r], "transaction");
    if ($unmatched != null) {
        echo "<br> found some people";
        $username_owe = array();
        $id_owe = array();
        while ($temp = mysqli_fetch_array($unmatched)) {
            $username_owe[] = $temp["username"];
            $id_owe[] = $temp["id"];
        }
        //var_dump($username_owe);
        //work on the matching
        for ($i = 0; $i < count($username_owe); $i++) {
            $paid = $dbhandler->getAllPaidAndRefUnfilled($money[$r], "transaction");
            if ($paid != null) {
                $username= array();
                $id = array();
                $ref1 =array();
                $ref2 = array();
                while ($temp = mysqli_fetch_array($paid)) {
                    $username[] = $temp["username"];
                    $id[] = $temp["id"];
                    $ref1[] = $temp["ref1"];
                    $ref2[] = $temp["ref2"];
                }
                for($j = 0; $j<count($id); $j++){
                
                echo "<br>" . $username[$j];
                if ($username[$j] == $username_owe[$i]){
                    continue;
                }else{
                if ($ref1[$j] == null) {
                    $state1 = $dbhandler->assignref1("transaction", $username_owe[$i], $id_owe[$i], $id[$j]);
                    $state2 = $dbhandler->updateMatch("transaction", $username[$j], $id_owe[$i]);
                } else {
                    if ($ref2[$j] == null) {
                        $state1 = $dbhandler->assignref2("transaction", $username_owe[$i], $id_owe[$i], $id[$j]);
                        $state2 = $dbhandler->updateMatch("transaction", $username[$j], $id_owe[$i]);
                    }
                }

                $paid = $dbhandler->getfilledbyid($id[$j], "transaction");
                if ($paid != null) {
                    extract(mysqli_fetch_array($paid));
                    if ($ref1 != null && $ref2 != null) {
                        $dbhandler->lock("transaction", $id);
                    }
                }
                break;
            }
                }
            }
        }
    }
}
?>
