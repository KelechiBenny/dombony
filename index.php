<?php 
ob_start();
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Donors Bay
        </title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">      
        <link rel="stylesheet" href="bootstrap/css/font-awesome.min.css"> 
        
        <link rel="stylesheet" href="bootstrap/css/style.css">
        
        
        
        <script src="bootstrap/js/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>
  <script>     

$(document).ready(function(){
  var divs = ["#div1", "#div2","#div3", "#div4", "#div5", "#div6", "#div7"];
  var time = 1000;
  for ( i = 0; i<divs.length; i++){
      $(divs[i]).hide("fast");
  }
  for (i = 0; i <divs.length; i++){
   $(divs[i]).show(3000);
   $(divs[i]).animate({
        left: '3%',fontSize: '18px',top:'20px',
        right: '3%',opacity: '1'
    },time); 
    time+=800;
}
}
  );
</script>


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
                color: #868787;
            }
            .container-fluid{
                font-size: 16px;
                font-weight:bold;
                line-height: 1.4;
                
            }
            .jumbotron{
                min-height: 350px;
            }
            i{
                font-size: 20px;
                color: black;
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

                        <i class="fa fa-group" style="font-size: 24px;"></i> &nbsp;&nbsp; Donors Bay</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">HOME</a></li>
                        
                        <?php
                        if(!isset($_SESSION["username"])){
                         echo '<li><a href="login.php">LOGIN</a></li>
                        <li><a href="register.php">SIGNUP</a></li>
                        <li><a href="contact.php">CONTACT</a></li>
                        ';
                        }else{
                            echo '<li><a href="dashboard.php">DASHBOARD</a></li>';
                            echo '<li><a href="profile.php">PROFILE</a></li>';
                            echo '<li><a href="contact.php">SUPPORT</a></li>';
                            echo '<li><a href="logout.php">LOGOUT</a></li>';
                        }
                        ?>
                        
                        
                    </ul>
                </div>
            </div>
        </nav>

        <!--Company name and search-->
     
       
        <div class="container-fluid" >
       
       <div class="row" style="padding-top: 100px;">
           <h1 class="text-center" style="padding-bottom: 50px; font-weight: bold; color: #125baa">Features</h1>
           <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
              
               <div class="jumbotron">
                   <p class="text-center"><i class="fa fa-hand-o-down" style="font-size:36px; color:red;"></i></p>
                   <p class="text-center">Purge Button</p>
                    There is no room for cyber beggars. If someone who is supposed to pay you keeps begging you to confirm him/her
                    just use the purge button and he/she will be reported to the support team and after 15-20 mins a proof of payment
                    wasn't provided then that member will be deleted.
               </div>
           </div>
           <div class="col-md-2 col-lg-2"></div>
           <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
               <div class="jumbotron">
                   <p class="text-center"><i class="fa fa-money" style="font-size:36px; color:red;"></i></p>
                   <p class="text-center">100% Return</p>
                   you get 100% return for any package you select and pay for. e.g if you choose &#8358; 10000 package
                   you will be matched with two members to pay you &#8358; 10000 each.
               </div>
           </div>
       </div>
       
           <div class="row" style="padding-top: 100px;">
           <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
               <div class="jumbotron">
                   <p class="text-center"><i class="fa fa-briefcase" style="font-size:36px; color:red;"></i></p>
                   <p class="text-center">Packages</p>
                    Different packages have been made available, from &#8358; 5000 to &#8358; 10000 to &#8358; 20000
                    to &#8358; 50000 and finally &#8358; 100000. Choose any package of your choice and please use your spare money.
                    Remember you can ph as many times as possible.
               </div>
           </div>
           <div class="col-md-2 col-lg-2"></div>
           <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                <div class="jumbotron">
                    <p class="text-center"><i class="fa fa-clock-o" style="font-size:36px; color:red;"></i></p>
                   <p class="text-center">Time Frame</p>
                   Maximum payment time is 2 hours so please if you can't make payment before 2 hours then don't register.
                   Our delete Script is automatic so if you have any issues to resolve please do that within the time frame.
               </div>
           </div>
       </div>
       
           <div class="row" style="padding-top: 100px;">
           <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
               <div class="jumbotron">
                   <p class="text-center"><i class="fa fa-line-chart" style="font-size:36px; color:red;"></i></p>
                   <p class="text-center">Transaction Table</p>
                    A transaction page has been provided to help you monitor your ph and gh. you can 
                    cancel a ph right before you are matched from the transaction page.
        
               </div>
           </div>
           <div class="col-md-2 col-lg-2"></div>
           <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                <div class="jumbotron">
                    <p class="text-center"><i class="fa fa-trash-o" style="font-size:36px; color:red;"></i></p>
                   <p class="text-center">I can't pay button</p>
                   I can't pay button, this button enables someone who cannot make payment to opt out. once this member clicks on 
                   this button, the ph is deleted and the member he/she was supposed to pay is re-matched with another member.
               </div>
           </div>
       </div>
            </div>
        <footer class="text-center navbar-inverse">Copyright &copy; Reserved 2017</footer>
    </body>
</html>
<?php
ob_end_flush();
?>