<?php
ob_start();
session_start();
if (isset($_SESSION["username"])) {
    header("location: dashboard.php");
}
include 'class.php';
$dbhandler = new DatabaseHandler;
$dbhandler->createUserTable("users");
$dbhandler->createTransactionTable("transaction");
$dbhandler->createTransactionTable("blacklist");
$dbhandler->createTransactionTable("recyclebin");
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
            Log in
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
                        <li><a href="register.php">SIGNUP</a></li>
                        <li><a href="contact.php">SUPPORT</a></li>

                    </ul>
                </div>
            </div>
        </nav>
        <div class="container" style="color: white;">
            <div class="row">

                <div class="col-sm-2  col-lg-4 col-md-4">

                </div>

                <div class="col-sm-8 col-xs-12 col-lg-4 col-md-4 loginstyle" >

                    <form class="form-horizontal" method="post" role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>>

                        <div class="jumbotron">

                            <?php
                            if (isset($_GET["msg"]) && $_GET["msg"] == "successful") {
                                echo '<div class="alert alert-info">Registration Successful</div>';
                            }
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {



                                $table_type = "probation";
                                $username = test_input($_POST["username"]);
                                $password = test_input($_POST["password"]);
                                $state = $dbhandler->getUserDetails("users", $username);
                                

                                if ($state != null) {
                                    $user = array();
                                    $pass = array();
                                    $usertype = array();
                                    while ($temp = mysqli_fetch_array($state)) {
                                        $user[] = $temp["username"];
                                        $pass[] = $temp["password"];
                                        $usertype = $temp ["usertype"];
                                    }
                                    if ($pass[0] == md5($password)) {

                                        $_SESSION["username"] = $username;
                                        //check the usertype column to see if member is admin
                                        if ($usertype[0] == 1) {
                                            $_SESSION["usertype"] = 1;
                                        }
                                            header("location: dashboard.php");
                                       
                                    } else {
                                        echo "<div class='alert alert-info'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Warning!</strong>
  ";

                                        echo"<ul><li>Username or Password is Incorrect";

                                        echo "</ul></div>";
                                    }
                                    //echo "<br> Wrong password";
                                } else {
                                    echo "<div class='alert alert-info'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Warning!</strong>
  ";

                                    echo"<ul><li>Username or Password is Incorrect";

                                    echo "</ul></div>";
                                }
                            }
                            ?>
                            <div class="form-group">

                                <input type="text"  name="username"  class="form-control"  placeholder="Enter Username">
                            </div>
                            <div class="form-group">

                                <input type="password"  name="password"  class="form-control"   placeholder="Enter Password">
                            </div>

                            <div class="form-group">
                                <input type="checkbox">&nbsp;&nbsp;Remember me
                            </div>
                            <p style="font-size: 14px;">No Account yet? <a href="register.php">signup</a></p>
                            <div class="form-group">
                                <Button type="submit" class="btn btn-primary btn-block">Log in</Button>
                            </div>

                            <div class="form-group text-center">
                                <a href="reset.php">forgot password?</a>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="col-sm-2  col-lg-4 col-md-4">

                </div>
            </div>
        </div>

    </body>
</html>
<?php
ob_end_flush();
?>