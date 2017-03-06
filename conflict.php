<?php
session_start();
include 'class.php';
$dbhandler = new DatabaseHandler;
$username = $_SESSION["username"];
$link = $dbhandler->connectToDB();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            Conflict
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
                float: left;
                list-style: none;

            }
            .row li{

                padding-left: 120px;
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
                        <li><a href="contact.php">SUPPORT</a></li>
                        <li><a href="logout.php">LOGOUT</a></li>

                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row" style="padding-top: 80px;">

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
                    if (isset($_POST["add"])) {
                        $detail = $dbhandler->getRef("transaction", $_POST["add"]);
                        if($detail != null){
                        extract(mysqli_fetch_array($detail));
                        if ($idref1 == $_POST["add"]){
                            $query = "UPDATE  transaction SET confirmref1 = 'yes', ref1 = 'confirm#$' WHERE idref1 =".$_POST["add"];
                             mysqli_query($link, $query);
                        }else{
                            $query = "UPDATE  transaction SET confirmref2 = 'yes', ref2 = 'confirm#$' WHERE idref2 =".$_POST["add"];
                             mysqli_query($link, $query);
                        }
                        $query = "UPDATE  transaction SET paid = 'yes' WHERE id =".$_POST["add"];
                        mysqli_query($link, $query); 
                        $dbhandler->deleteph("blacklist", $_POST["add"]);
                    }
                    }

                    if (isset($_POST["delete"])) { 
                            $dbhandler->recyclebin("transaction", $_POST["delete"]);
                            $dbhandler->deleteph("blacklist", $_POST["delete"]);
                       
                        processCancel($_POST["delete"]);
                        
                   }
                }
?>
               
                        
                            
                               
                    <div class="table-responsive text-left">
                 <table class="table table-bordered table-condensed" style="font-weight: bold;">
                     <tr>
                         <td>id</td>
                         <td>username</td>
                         <td>Email</td>
                         <td>amount</td>
                         <td>Add</td>
                         <td>delete</td>
                     </tr>
                     <?php
                     $state = $dbhandler->selectAll("blacklist");
                     $id1 = array();
                     $user= array();
                     $amount1 = array();
                     if($state != null){
                         while ($temp = mysqli_fetch_array($state)){
                             $id1 [] = $temp["id"];
                             $user [] = $temp["username"];
                             $amount1 [] = $temp["amount"];
                         }
                         for($i = 0; $i<count($id1); $i++){
                             $detail = $dbhandler->selectAllFromWhereUsername("users", $user[$i]);
                             if($detail != null){
                                 extract(mysqli_fetch_array($detail));
                        echo' <tr>
                         <td>'.$id1[$i].'</td>
                         <td>'.$user[$i].'</td>
                         <td>'.$email.'</td>
                         <td>&#8358;'.$amount1[$i].'</td>
                         <td><form class="form-horizontal text-center" method=post action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" role="form" style="color: black;">
                 <button class="btn btn-success " type="submit" value="' . $id1[$i] . '" name="add" style = "font-weight: bold">Confirm</button>
                 </form></td>
                         <td>
                         <form class="form-horizontal text-center" method=post action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" role="form" style="color: black;">
                 <button class="btn btn-danger" type="submit" value="' . $id1[$i] . '" name="delete" style = "font-weight: bold">Delete</button>
                 </form>
                 </td>
                     </tr>';
                     }
                         }
                     }
                     
                     ?>
                     
                     
                        </table>
                    </div>
                
                

            </div>
        </div>
    </body>
</html>
<?php
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
        $dbhandler->deleteph("blacklist", $id1);
    }
}
?>