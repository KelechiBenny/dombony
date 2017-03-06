<?php
ob_start();
session_start();
include 'class.php';
$dbhandler = new DatabaseHandler;
if (!isset($_SESSION["username"])) {
    header("location: login.php");
}
$username = $_SESSION["username"];

?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Profile
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
            h3,h4{
                font-weight: bold;

            }
            p{
                color: white;
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
                    <a class="navbar-brand" href="#">
                        <i class="fa fa-group" style="font-size: 25px;"></i> &nbsp;&nbsp; Donors bay</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">HOME</a></li>

                        <?php
                        if (!isset($_SESSION["username"])) {
                            echo '<li><a href="login.php">LOGIN</a></li>
                        <li><a href="register.php">SIGNUP</a></li>
                        ';
                        } else {
                            echo '<li><a href="dashboard.php">DASHBOARD</a></li>';
                            echo '<li><a href="contact.php">SUPPORT</a></li>';
                            echo '<li><a href="logout.php">LOGOUT</a></li>';
                        }
                        ?>


                    </ul>
                </div>
            </div>
        </nav>

        <div class="row">
            <div class="col-sm-5 col-xs-12 col-lg-4 col-md-4">
                <div class="" style="padding-top: 80px; padding-left: 20px; padding-right: 30px;">

                    <div class="jumbotron text-right" style="padding-top: 20px;">
                        <a href="editprofile.php"><i class="fa fa-edit" style="font-size: 24px; color:black; padding-bottom: 30px;"></i></a>
                     
                            <?php
                            $details = $dbhandler->selectAllFromWhereUsername("users", $username);
                            if ($details != null) {
                                extract(mysqli_fetch_array($details));
                                echo '<div class="table-responsive text-left">
                 <table class="table table-bordered " style="font-weight: bold; background-color: #fcc98d;">
                 <tr><td>Full Name:</td><td>' . $fullname . '</td></tr>
                 <tr><td>Phone no:</td><td>' . $phonenumber . '</td></tr>
                 <tr><td>Email:</td><td>' . $email . '</td></tr>
                  <tr><td>Bank Name:</td><td>' . $bankname . '</td></tr>
                  <tr><td>Account Holder:</td><td>' . $accountholder . '</td></tr>
                  <tr><td>Bank Account no:</td><td>' . $bankaccount . '</td></tr>
</table></div>';
                                        
                                    ;
                            }
                            ?>

                        
                    </div>
                </div>
            </div>
            <div class="col-sm-2  col-lg-4 col-md-4">

            </div>
           <div class="col-sm-5 col-xs-12 col-lg-4 col-md-4">
               
                <div class="" style="padding-top: 80px; padding-right: 30px; padding-left: 20px;">
                    <div class="jumbotron text-center" style="padding-top: 10px;">
                    <p style="font-weight: 20px; color: black;">Change password</p>
                       
                     
                        
                        <form class="form-horizontal" method="post" style="padding-left: 10px; padding-right: 10px; " role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $oldpassword = md5($_POST["oldpassword"]);
                            $newpassword = md5($_POST["newpassword"]);
                            $confirmpassword = md5($_POST["confirmpassword"]);
                            $details = $dbhandler->selectAllFromWhereUsername("users", $username);
                            extract(mysqli_fetch_array($details));
                            if($oldpassword == $password){
                                if($newpassword == $confirmpassword){
                                   $process = $dbhandler->changePassword("users", $username, $newpassword);
                                   if($process!=null){
                                       echo '<div class="text-info" style="font-weight: bold;">Password Changed</div>';
                                   }else{
                                       echo '<div class="text-warning" style="font-weight: bold;">Error Changing Password</div>';
                                   }
                                   
                                }else{
                                    echo '<div class="text-danger" style="font-weight: bold;">Password mismatch</div>';
                                }
                            }else{
                                echo '<div class="text-danger" style="font-weight: bold;">Wrong password Entered</div>';
                            }
                        }
                        
                        ?>
                            <div class="form-group">
                            
                            <input type="password"  name="oldpassword" class="form-control"  placeholder="Enter old password">
                        </div>
                            
                         <div class="form-group">
                            
                            <input type="password"  name="newpassword"  class="form-control" placeholder="Enter new password">
                        </div>
                            
                        <div class="form-group">
                            
                            <input type="password"  name="confirmpassword"  class="form-control"   placeholder="Confirm password">
                        </div>
                            <div class="form-group">
                            <Button type="submit" class="btn btn-primary btn-block">Change Password</Button>
                        </div>
                    
                        </form>

                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
