<?php
ob_start();
include 'class.php';
session_start();
if(isset($_SESSION["username"])){
    header("location: dashboard.php");
}
$dbhandler = new DatabaseHandler;
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
            Reset
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
                        <li><a href="login.php">LOGIN</a></li>
                       
                        <li><a href="contact.php">SUPPORT</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container" style="color: white;">
            <div class="row">

                <div class="col-sm-4 col-xs-4 col-lg-4 col-md-4">

                </div>

                <div class="col-sm-8 col-xs-12 col-lg-4 col-md-4 loginstyle" >
                    <div class="jumbotron">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $username = test_input($_POST["username"]);
                        $state = $dbhandler->getUserDetails("users", $username);
                        
                        

                        if ($state != null) {
                            $user = array();
                            $email = array();

                            while ($temp = mysqli_fetch_array($state)) {
                                $user[] = $temp["username"];
                                $email[] = $temp["email"];
                            }
                            //send mail
                        $reset = $dbhandler->autoChangePassword("users", $username);
                        if ($reset != false){
                        $to = $email[0]; 
                        $email_subject = "Hi ".$user[0];
                        $email_body = " your new password is ".$reset;
                        $headers = "From: support@donorsbay.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@tribenigeria.com.
                        $headers .= "Reply-To: $email[0]";
                        if(mail($to, $email_subject, $email_body, $headers)){
                            echo "<div class='alert alert-success'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Password has been sent to your email</strong>
  </div>
  ";
                        }
                        }else{
                            echo "<div class='alert alert-info'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Password not reset</strong>
  </div>
  ";
                        }
                           
                            //echo "<br> Wrong password";
                        } else {
                            echo "<div class='alert alert-warning'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  <strong>Warning!</strong>
  ";

                            echo"<ul><li>Username doesnt exist";

                            echo "</ul></div>";
                        }
                    }
                    ?>
                    <form class="form-horizontal" method="post" role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>>
                        <div class="form-group">
                           
                            <input type="text"  name="username"  class="form-control"  placeholder="Enter Username">
                        </div>
                        <div class="form-group">
                            <Button type="submit" class="btn btn-primary  btn-block">Reset</Button>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-4 col-lg-4 col-md-4">

                </div>
            </div>
        </div>
        

    </body>
</html>
<?php
ob_end_flush();
?>