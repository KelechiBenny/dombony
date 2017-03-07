<?php
ob_start();
session_start();
if (!isset($_SESSION["username"])) {
    header("location: dashboard.php");
}
include 'class.php';
$dbhandler = new DatabaseHandler;
$username = $_SESSION["username"];
$usertype = null;

if(isset($_SESSION["usertype"])){
    $usertype = $_SESSION["usertype"];
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["cancel"])){
        $dbhandler->deleteph("transaction", $_POST["cancel"]);
        header("location: transaction.php");
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            Transactions
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">      
        <link rel="stylesheet" href="bootstrap/css/font-awesome.min.css"> 
        <link rel="stylesheet" href="bootstrap/css/style.css">
        <script src="bootstrap/js/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>


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
                        <li><a href="dashboard.php">DASHBOARD</a></li>
                        <li><a href="contact.php">SUPPORT</a></li>
                        <li><a href="logout.php">LOGOUT</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container" >
            <div class="row">

                <div class="col-lg-1 col-md-1">

                </div>

                <div class="col-sm-12 col-xs-12 col-lg-10 col-md-10 loginstyle" >
                    <p class="text-center" style="font-weight: bold; font-size: 18px; padding-bottom: 20px;">Transactions</p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr style="font-weight: bold;">
                                
                                <td>Ph</td>
                                <td>Date</td>
                                <td>Time</td>
                                <td>Cancel</td>
                                <td>Idref1</td>
                                <td>Idref2</td>
                                <?php if ($usertype == 1){
                                    echo '<td>Edit</td>';
                                }?>
                            </tr>
                            <?php
                            
                            $amount =array();
                            $date =array();
                            $time =array();
                            $topay =array();
                            $paid =array();
                            $id =array();
                            $idref1 = array();
                            $idref2 = array();
                            $confirmref1 = array();
                            $confirmref2 = array();
                            $state = $dbhandler->selectAllFromWhereUsername("transaction",$_SESSION["username"]);
                            if ($state != null){
                           while ($temp = mysqli_fetch_array($state)) {
                                        $amount[] = $temp["amount"];
                                        $date[] = $temp["date"];
                                        $time[] = $temp["time"];
                                        $topay[] = $temp["topay"];
                                        $paid[] = $temp["paid"];
                                        $id[] = $temp["id"];
                                        $idref1[] = $temp["idref1"];
                                        $idref2[] = $temp["idref2"];
                                        $confirmref2[] = $temp["confirmref2"];
                                        $confirmref1[] = $temp["confirmref1"];
                                    }
                                    
                            for($i = 0; $i< count($amount); $i++){
                                //insert code so as not to show cancel but matched for member who has been matched
                               echo '
                                <td>&#8358;'.$amount[$i].'</td>
                                <td>'.$date[$i].'</td>
                                <td>'.$time[$i].'</td>';
                               if ($topay[$i] == null){
                                echo '<td><form class="form-horizontal text-center" name="form1" method=post role="form" style="color: black;">
                                <button class="btn btn-info btn-xs btn-block" type="submit" name="cancel" value="' . $id[$i] . '">Cancel</button>
                                </form></td>';
                               }else{
                                   if($paid[$i] == null){
                                       echo '<td><div class="label label-primary ">Matched</div></td>';
                                   }else{
                                       echo '<td><div class="label label-success">Confirmed</td>';
                                   }
                               }
                               $val1 ="";
                               $val2 = "";
                               if($confirmref1[$i] !=null){
                                   $val1.="<div class='label label-success'><i class='fa fa-check' style='color: white;'></i></div>";
                               }
                               if($confirmref2[$i] !=null){
                                   $val2.="<div class='label label-success'><i class='fa fa-check' style='color: white;'></i></div>";
                               }
                                echo '
                                    <td>'.$idref1[$i].'&nbsp;&nbsp;'.$val1.'</td>
                                    <td>'.$idref2[$i].'&nbsp;&nbsp;'.$val2.'</td>';
                                if($usertype == 1){
                                   echo '<td><form class="form-horizontal text-center" action="adminedit.php" name="form1" method=get role="form" style="color: black;">
                                <button class="btn btn-primary btn-xs btn-block" type="submit" name="edit" value="' . $id[$i] . '">Edit</button>
                                </form></td>';
                                }
                                echo '</tr>';
                            }
                            }
                            ?>
                        </table>
                    </div>
                    
        </div>
                <div class="col-lg-1 col-md-1">

                </div>
                
            </div>
        </div>
    </body>
</html>
<?php
ob_end_flush();
?>