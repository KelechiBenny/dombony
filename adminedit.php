<?php
//remember to check for error two in information display
ob_start();
session_start();
if (!isset($_SESSION["usertype"])) {
    header("Location: dashboard.php");
}
if (!isset($_SESSION["username"])) {
    header("Location: dashboard.php");
}
$editid = $_GET["edit"];
$username = $_SESSION["username"];
include 'class.php';
$dbhandler = new DatabaseHandler;
$str = "amount,ref1,idref1,ref2,idref2,confirmref1,confirmref2,filled";
$values = explode(",", $str);
$names = array();
for ($i = 0; $i < sizeof($values); $i++) {
    $names[$values[$i]] = "";
}

$state =$dbhandler->getfilledbyid($editid,"transaction");
if($state != null){
    extract(mysqli_fetch_array($state));
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}




?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Edit
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
                    <a class="navbar-brand" href="#"><i class="fa fa-group" style="font-size: 25px;"></i> &nbsp;&nbsp; Donors Bay </a></a>
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
        <div class="container">
            <div class="row">

                <div class="col-sm-2  col-lg-3 col-md-4">

                </div>

                <div class="col-sm-8 col-xs-12 col-lg-6 col-md-4 signupstyle" >
                    <div class="jumbotron">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        foreach ($names as $name => $value) {
                            $names[$name] = test_input($_POST[$name]);
                        }
                            
                        if (true) {
                            
                            $insert = $dbhandler->adminUpdateTransaction($editid,$names,"transaction");
                            
                            if ($insert) {
                            echo "<div class='alert alert-success ' style='padding-top: 1%'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Account update Succesful!</strong></div>
  ";
                            } else {
                                echo "<div class='alert alert-warning ' style='padding-top: 1%'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Account update not Successful!</strong></div>
  ";
                            }
                        } else {
                            echo "<div class='alert alert-warning ' style='padding-top: 1%'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Warning!</strong>
  ";

                            echo"<ul>";
                            if (sizeof($errors1) != 0) {
                                foreach ($errors1 as $error => $value) {
                                    echo "<li>" . $value . "</li>";
                                }
                            }
                            echo "</ul></div>";
                        }
                    }
                    //echo $bankaccount[0];
                    ?>



                    <form class="form-horizontal" method="post" role="form" >
                        <div class="form-group">
                            
                            <input type="text"  name="amount" placeholder="Enter amount"  class="form-control" value="<?php echo $amount ?>">
                        </div>

                        <div class="form-group">
                            
                            <input type="text"  name="ref1"  class="form-control"  placeholder="Enter ref1" value="<?php echo $ref1 ?>"   >
                        </div>
                        <div class="form-group">
                            
                            <input type="number"  name="idref1"  placeholder="Enter idref1"  class="form-control" value="<?php echo $idref1?>">
                        </div>
                        <div class="form-group">
                            
                            <input type="text"  name="confirmref1"  placeholder="Enter confirmref1"  class="form-control" value="<?php echo $confirmref1 ?>"   >
                        </div>

                        <div class="form-group">
                           
                            <input type="text"  name="ref2"  placeholder="Enter ref2"  class="form-control" value="<?php echo $ref2 ?>">
                        </div>
                        
                        <div class="form-group">
                            
                            <input type="number"  name="idref2"  placeholder="Enter idref2"  class="form-control" value="<?php echo $idref2?>">
                        </div>
                        <div class="form-group">
                            
                            <input type="text"  name="confirmref2"  placeholder="Enter confirmref2"  class="form-control" value="<?php echo $confirmref2 ?>"   >
                        </div>
                        
                        
                        
                        
                        <div class="form-group">
                            
                            <input type="text"  name="filled"  placeholder="filled"  class="form-control" value="<?php echo $filled ?>"  >
                        </div>

                        <div class="form-group">
                            <Button type="submit" class="btn btn-primary  btn-block">Update</Button>
                        </div>

                    </form>

                </div>
                <div class="col-sm-2  col-lg-3 col-md-4">

                </div>
                </div>
            </div>
        </div>

    </body>
</html>
<?php
ob_end_flush();
?>