<?php
ob_start();
include 'class.php';
session_start();

$dbhandler = new DatabaseHandler;
$usertype = null;
$time_range = 2;
if(isset($_SESSION["usertype"])){
    $usertype = $_SESSION["usertype"];
}
if (!isset($_SESSION["username"])) {
    header("location: login.php");
}


//check if the referrals still exists in the probation table and if yes then set activated and disabled else set avtivate and enable
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["five"])) {

        ph("5000");
    }
    if (isset($_POST["ten"])) {
        ph("10000");
    }
    if (isset($_POST["twenty"])) {
        ph("20000");
    }
    if (isset($_POST["fifty"])) {
        ph("50000");
    }
    
    if (isset($_POST["hundred"])) {
        ph("100000");
    }
    
    if (isset($_POST["first"])) {
        $state = $dbhandler->getRef("transaction",$_POST["first"]);
        if($state != null){
        extract(mysqli_fetch_array($state));
        if($username == $_SESSION["username"]){
       $dbhandler->confirmref1("transaction", $_POST["first"]);
       $dbhandler->deleteph("blacklist",$_POST["first"]);
       
        }
        }
         header("location: dashboard.php");
 
    }
    
    if (isset($_POST["second"])) {
        $state = $dbhandler->getRef("transaction",$_POST["second"]);
        if($state != null){
        extract(mysqli_fetch_array($state));
        if($username == $_SESSION["username"]){
       $dbhandler->confirmref2("transaction", $_POST["second"]);
       $dbhandler->deleteph("blacklist",$_POST["second"]);
       header("location: dashboard.php");
        }
        }
         header("location: dashboard.php");
    }
    
    if (isset($_POST["cant"])) {
        $state = $dbhandler->getfilledbyid($_POST["cant"],"transaction");
        if($state != null){
        extract(mysqli_fetch_array($state));
        if($username == $_SESSION["username"]){
        processCancel($_POST["cant"]);
        }
        }
        header("location: dashboard.php");
    }
    
    if (isset($_POST["purge"])) {
        
        echo "<br><br><br><div class='alert alert-success'>You have reported a member as beggar</div>";
       $dbhandler->blacklist("transaction", $_POST["purge"]);
    }
    
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            Dashboard
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">      
        <link rel="stylesheet" href="bootstrap/css/font-awesome.min.css"> 
        <link rel="stylesheet" href="bootstrap/css/style.css">
        <script src="bootstrap/js/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>
        <script src="countdown.js"></script>

    </head>
    <body>
     
        <style>
            li{
                font-weight: bold;
            }

        </style>
        <!---Navigation bar-->
        <nav class="navbar navbar-inverse navbar-fixed-top ">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                    </button>
                    <a class="navbar-brand" href="#"><i class="fa fa-group" style="font-size: 25px;"></i> &nbsp;&nbsp; Donors Bay</a></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">HOME</a></li>

                        <li><a href="dashboard.php"><?php echo "HI!  " . strtoupper($_SESSION["username"]); ?></a></li>
                        <li><a href="profile.php">PROFILE</a></li>
                        <li><a href="transaction.php">TRANSACTIONS</a></li>
                        <li><a href="contact.php">SUPPORT</a></li>
                        <?php
                        if(isset($_SESSION["usertype"]) && $_SESSION["usertype"] == 1){
                           echo ' <li><a href="conflict.php">CONFLICT</a></li>';
                        }
                        ?>
                        <li><a href="logout.php">LOGOUT</a></li>

                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row" style="padding-top: 60px">
                <div class="col-lg-4 col-md-4 col-sm-4"></div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4"></div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4"></div>
                <div class="col-lg-4 col-sm-12 col-xs-12 col-md-4">
                    <?php
                    if (isset($_GET["msg"])) {
                        echo "<div class='alert alert-success text-center'>PH of &#8358;" . $_GET["msg"] . " Successful</div>";
                    }
                    ?>
                    <br /> <br /> <br /> <br /> <br />
                    <form class="form-horizontal" method="post" role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>>
                        <button class="btn btn-primary btn-lg btn-block" name="five" type="submit" >&#8358;5,000</button>
                        <button class="btn btn-success btn-lg btn-block" name="ten" type="submit" >&#8358;10,000</button>
                        <button class="btn btn-info btn-lg btn-block" name="twenty" type="submit" >&#8358;20,000</button>
                        <button class="btn btn-danger btn-lg btn-block" name="fifty" type="submit" >&#8358;50,000</button>
                        <button class="btn btn-warning btn-lg btn-block" name="hundred" type="submit" >&#8358;100,000</button>
                    </form>
                    <p class="text-center" style="font-size: 24px; padding-top: 45px; font-weight: bold;">Select any package of your choice</p>

                    <?php
                    //call a function to get list of every body you are to pay and those to be paid
                    topay($_SESSION["username"]);
                    tobepaid($_SESSION["username"]);
                    ?>






                </div>
                <div class="col-lg-4 col-md-4"></div>
            </div>
        </div>
   <script>
     
   </script>
    </body>
</html>

<?php

function ph($package) {
    global $dbhandler;
    global $usertype;
    $insert = null;
    if($usertype == 1){
     $insert = $dbhandler->insertIntoTransactionAdmin("transaction", $_SESSION["username"], $package);
    }else{
    $insert = $dbhandler->insertIntoTransaction("transaction", $_SESSION["username"], $package);
    }
    if ($insert) {
        echo "<br><br> Successfully inserted";
        header("location: dashboard.php?msg=" . $package);
    } else {
        echo "<br><br>Not Successfully inserted";
    }
}



function topay($users) {
    global $dbhandler,$time_range;
    $details = $dbhandler->getWhoToPay("transaction", $users);
    if ($details != null) {

        $user = array();
        $amount = array();
        $topay = array();
        $id1 = array();
        $timetran = array();
        $datetran = array();
        while ($temp = mysqli_fetch_array($details)) {
            $user[] = $temp["topay"];
            $amount[] = $temp["amount"];
            $topay[] = $temp["topay"];
            $id1[] = $temp["id"];
            $timetran[] = $temp["time"];
            $datetran[] = $temp["date"];
        }

        for ($i = 0; $i < count($user); $i++) {
            $state = $dbhandler->selectAllFromWhereUsername("users", $user[$i]);
            if ($state != null) {
                extract(mysqli_fetch_array($state));
                echo '<div class="jumbotron text-center" >';
                                $test = date("Y-m-d H:i:s",strtotime($datetran[$i] . " " . $timetran[$i])+($time_range*3600))."";
                                
                                //echo $test;
                                $t1 = strtotime($datetran[$i] . " " . $timetran[$i]);
                                $t2 = strtotime(date("Y-m-d") . " " . date("H:i:s"));
                                $time_diff = ($t2 - $t1) / 60;
                               
                                $phtime = "'".$test."'";
                               
                                if ($topay[$i] != null) {
                                    echo "<div class='label label-default'><strong id ='clockdiv".$i."' ></strong></div>";
                                   echo '<script>initializeClock("clockdiv'.$i.'",'.$phtime.')</script> 
                                   ';
                                    
                                }
                            
                 echo '<p style="padding-top: 20px;">Pay the Following member the sum of &#8358;' . $amount[$i] . '</p>
                 <table class="table table-bordered  text-left" style="font-weight: bold; background-color: #fcc98d;">
                                
                 <tr><td>Username:</td><td>' . $username . '</td></tr>
                 <tr><td>Bank Name:</td><td>' . $bankname . '</td></tr>
                 <tr><td>Account Name:</td><td>' . $accountholder . '</td></tr>
                 <tr><td>Account no:</td><td>' . $bankaccount . '</td></tr>
                 <tr><td>Phone no:</td><td>' . $phonenumber . '</td></tr></table>
                 <form class="form-horizontal text-center" name="form1" method=post role="form" style="color: black;">
                 <button class="btn btn-danger btn-block" type="submit" value="' . $id1[$i] . '" name="cant">Cant pay</button>
                 
                 
                 </form>
</div>';
            }
        }
    }
}

function tobepaid($user) {
    global $dbhandler;
    $details = $dbhandler->getpayer("transaction", $user);
   
    if ($details != null) {

        $user = array();
        $amount = array();
        $id1 = array();
        $ref1 = array();
        $ref2 = array();
        $idref1 = array();
        $idref2 = array();
        while ($temp = mysqli_fetch_array($details)) {
            $amount[] = $temp["amount"];
            
            $id1[] = $temp["id"];
            $ref1[] = $temp["ref1"];
            $ref2[] = $temp["ref2"];
            $idref1[] = $temp["idref1"];
            $idref2[] = $temp["idref2"];
        }

        for ($i = 0; $i < count($ref1); $i++) {

            $state = null;
            $state = $dbhandler->selectAllFromWhereUsername("users", $ref1[$i]);

            if ($state != null) {
                extract(mysqli_fetch_array($state));
                echo '<div class="jumbotron text-center">
                    
                 <p>The following member is to pay you the sum of &#8358;' . $amount[$i] . '</p>
                 <table class="table table-bordered  text-left" style="font-weight: bold; background-color: #fcc98d;">
                             
                 <tr><td>Username:</td><td>' . $username . '</td></tr>              
                 <tr><td>Phone no:</td><td>' . $phonenumber . '</td></tr></table>
                 <form class="form-horizontal text-center" name="form1" method=post role="form" style="color: black;">
                 <button class="btn btn-primary btn-block" type="submit" value="' . $idref1[$i] . '" name="first">Activate</button>
                 <button class="btn btn-warning btn-block " type="submit" value="' . $idref1[$i] . '" name="purge">Purge</button>
                 </form>
</div>';
            }

            $state = $dbhandler->selectAllFromWhereUsername("users", $ref2[$i]);

            if ($state != null) {
                extract(mysqli_fetch_array($state));
                echo '<div class="jumbotron text-center">
                 <p>The following member is to pay you the sum of &#8358;' . $amount[$i] . '</p>
                 <table class="table table-bordered  text-left" style="font-weight: bold; background-color: #fcc98d;">                                 
                 
                <tr><td>Username:</td><td>' . $username . '</td></tr>                
                 <tr><td>Phone no:</td><td>' . $phonenumber . '</td></tr></table>
                 <form class="form-horizontal text-center" name="form1" method=post role="form" style="color: black;">
                 <button class="btn btn-primary btn-block" type="submit" value="' . $idref2[$i] . '" name="second">Activate</button>
                 <button class="btn btn-warning btn-block" type="submit" value="' . $idref2[$i] . '" name="purge">Purge</button>
                 </form>
</div>';
            }
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
        $dbhandler->deleteph("transaction", $id1);
    }
}
ob_end_flush();
?>