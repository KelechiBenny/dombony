<?php
ob_start();
session_start();
if (isset($_SESSION["username"])) {
    header("location: dashboard.php");
}
include 'class.php';
$dbhandler = new DatabaseHandler;
$formhandler = new FormHandler;
$dbhandler->createUserTable("users");
$dbhandler->createTransactionTable("transaction");
$str = "fullname,username,password,confirmpassword,email,phonenumber,bankname,bankaccount,accountholder";
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
            Register
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

                        <li><a href="login.php">LOGIN</a></li>
                        <li><a href="contact.php">SUPPORT</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">

            <div class="col-sm-2 col-md-4  col-lg-3"></div>
            <div class="col-sm-8 col-md-4 col-xs-12 col-lg-6 loginstyle">
                <div class="text-info text-center">Fill every required information</div>
                <div class="jumbotron">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        foreach ($names as $name => $value) {
                            $names[$name] = test_input($_POST[$name]);
                        }
                        $errors1 = $formhandler->formValidation($names, "users");
                        
                        
                        if (sizeof($errors1) == 0) {
                            $insert = $dbhandler->insertIntoUsers($names, "users");
                            if ($insert) {
                                
                                header("Location: login.php?msg=successful");
                            } else {
                                echo "Account Not Created";
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
                            }
                            echo "</ul></div>";
                        }
                    }
                    ?>
                    <form class="form-horizontal" method="post" role="form" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>>

                        <div class="form-group">

                            <input type="text"  name="fullname"  class="form-control" value="<?php echo $names["fullname"] ?>"  placeholder="Enter Full name">
                        </div>
                        <div class="form-group">

                            <input type="text"  name="username"  class="form-control"  value="<?php echo $names["username"] ?>"  placeholder="Enter Username">
                        </div>

                        <div class="form-group">

                            <input type="password"  name="password"  class="form-control"   placeholder="Enter Password">
                        </div>
                        <div class="form-group">

                            <input type="password"  name="confirmpassword"  class="form-control"   placeholder="Confirm Password">
                        </div>
                        <div class="form-group">

                            <input type="email"  name="email"  class="form-control" value="<?php echo $names["email"] ?>"   placeholder="Enter email">
                        </div>
                        <div class="form-group">

                            <input type="number"  name="phonenumber"  class="form-control" value="<?php echo $names["phonenumber"] ?>"   placeholder="Enter Phone number">
                        </div>
                        <div class="form-group">

                            <input type="text"  name="bankname"  class="form-control" value="<?php echo $names["bankname"] ?>"   placeholder="Enter Bank name">
                        </div>
                        <div class="form-group">

                            <input type="text"  name="accountholder"  class="form-control" value="<?php echo $names["accountholder"] ?>"   placeholder="Enter account name">
                        </div>

                        <div class="form-group">

                            <input type="number"  name="bankaccount"  class="form-control" value="<?php echo $names["bankaccount"] ?>"  placeholder="Enter account no">
                        </div>

                        <div class="form-group">
                            <Button type="submit" class="btn btn-primary  btn-block">Register</Button>
                        </div>

                    </form>
                    <div class="col-sm-2 col-md-4 col-lg-3"></div>
                </div>
            </div>

    </body>
</html>