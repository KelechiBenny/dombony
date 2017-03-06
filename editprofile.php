<?php
//remember to check for error two in information display
ob_start();
session_start();
$username = $_SESSION["username"];
include 'class.php';
$dbhandler = new DatabaseHandler;

$str = "fullname,email,phonenumber";
$values = explode(",", $str);
$names = array();
for ($i = 0; $i < sizeof($values); $i++) {
    $names[$values[$i]] = "";
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
            Sign up
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
                    <a class="navbar-brand" href="#"><i class="fa fa-support" style="font-size: 25px;"></i> &nbsp;&nbsp; Gold Share</a></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">HOME</a></li>

                        <li><a href="dashboard.php"><?php echo "HI!  " . strtoupper($_SESSION["username"]); ?></a></li>
                       <li><a href="contact.php">CONTACT</a></li>
                        <li><a href="logout.php">LOGOUT</a></li>

                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">

                <div class="col-sm-2  col-lg-4 col-md-4">

                </div>

                <div class="col-sm-8 col-xs-12 col-lg-4 col-md-4 signupstyle" >
                    <div class="jumbotron">
                        <form class="form-horizontal" method="post" role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>>
                    <?php
                    $details = $dbhandler->selectAllFromWhereUsername("users",$username);
                    extract(mysqli_fetch_array($details));
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        foreach ($names as $name => $value) {
                            $names[$name] = test_input($_POST[$name]);
                        }
                            
                        if (true) {
                            
                            $insert = $dbhandler->updateProfile($username,$names,"users");
                            
                            if ($insert) {
                            echo "<div class='alert alert-success ' style='padding-top: 1%'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Account update Succesful!</strong></div>
  ";
                            } else {
                               echo "<div class='alert alert-danger ' style='padding-top: 1%'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Account update unsuccessful!</strong></div>
  ";
                            }
                        } else {
                            echo "<div class='alert alert-info ' style='padding-top: 1%'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Warning!</strong>
  ";

                            echo"<ul>";
                            if (sizeof($errors1) != 0) {
                                foreach ($errors1 as $error => $value) {
                                    echo "<li>" . $value . "</li>";
                                }
                            } else {
                                if (sizeof($errors2) != 0) {
                                    foreach ($errors2 as $error => $value) {
                                        echo "<li>" . $value . "</li>";
                                    }
                                } else {
                                    if (sizeof($errors3) != 0) {
                                        foreach ($errors3 as $error => $value) {
                                            echo "<li>" . $value . "</li>";
                                        }
                                    }
                                }
                            }
                            echo "</ul></div>";
                        }
                    }
                   
                    ?>



                    
                        <div class="form-group">
                            
                            <input type="text"  name="fullname" placeholder="Enter full name"  class="form-control" value="<?php echo $fullname; ?>"  placeholder="Enter Fullname">
                        </div>

                        <div class="form-group">
                            
                            <input type="number"  name="phonenumber"  placeholder="Enter Phone Number"  class="form-control" value="<?php echo $phonenumber;?>"   placeholder="Enter Phone number">
                        </div>
                        <div class="form-group">
                            
                            <input type="email"  name="email"  class="form-control"  placeholder="Enter Email" value="<?php echo $email; ?>"   placeholder="Enter email">
                        </div>
                        
                        <!--<div class="form-group">
                            
                            <input type="text"  name="bankname"  placeholder="Enter bank name"  class="form-control" value="<?php// echo $bankname; ?>"   placeholder="Enter Bank name">
                        </div>
                        
                        <div class="form-group">
                           
                            <input type="text"  name="accountholder"  placeholder="Enter Account Holders Name"  class="form-control" value="<?php //echo $accountholder; ?>"  placeholder="Enter account no">
                        </div>
                        
                        <div class="form-group">
                           
                            <input type="text"  name="bankaccount"  placeholder="Enter Bank Account"  class="form-control" value="<?php// echo $bankaccount; ?>"  placeholder="Enter account no">
                        </div>
                        -->
                        

                        <div class="form-group">
                            <Button type="submit" class="btn btn-primary  btn-block">Update</Button>
                        </div>

                    </form>

                </div>
                <div class="col-sm-2  col-lg-4 col-md-4">

                </div>
                </div>
            </div>
        </div>

    </body>
</html>
<?php
ob_end_flush();
?>
