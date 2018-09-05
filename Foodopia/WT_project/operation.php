<?php
    session_start();
    $_SESSION['restaurantname']=$_GET['restaurant'];
    if(!isset($_SESSION['loggedIn'])){
            header("location:login.php");
    } 
    if (isset($_POST['logout'])) {
        session_destroy();
        header("location: login.php");
    
    }

    if(isset($_GET['id']))
    {
        $con = mysqli_connect("localhost","root","","restaurant_system");

        if(!$con)
        {
            die("Connection Error :".mysqli_connect_error());
        }

        else
        {
            if($_GET['com']=="acc")
            {
                $str="UPDATE `reviews` SET `approval` = 'Y' , `notify` = '1'  WHERE `reviews`.`review_id` = '".$_GET['id']."';";
            }
            else if($_GET['com']=="del")
            {
                $str="UPDATE `reviews` SET `approval` = 'N' , `notify` = '1' WHERE `reviews`.`review_id` = '".$_GET['id']."';";
            }
            if($_GET['com']=="acc" && mysqli_query($con,$str))
            {
                header("location: Admin.php");
            }
            else if ($_GET['com']=="del" && mysqli_query($con,$str))
            {
                header("location: Admin.php");
            }
        }
    }

    if(isset($_GET['user']))
    {
        $con = mysqli_connect("localhost","root","","restaurant_system");

        if(!$con)
        {
            die("Connection Error :".mysqli_connect_error());
        }

        else
        {
            if($_GET['com']=="ban")
            {
               $str="UPDATE `reviewer` SET `valid` = 'N' WHERE `reviewer`.`rev_username` = '".$_GET['user']."' ;";
            }
            else if($_GET['com']=="unban")
            {
                $str="UPDATE `reviewer` SET `valid` = 'Y' WHERE `reviewer`.`rev_username` = '".$_GET['user']."' ;";
            }
            if(mysqli_query($con,$str))
            {
                header("location: Admin.php");
            }
            else
            {
                echo "<h1>YOUR REGISTRATION FAILED!</h1>";
            }
        }
    }

    if(isset($_GET['res']))
    {
        $con = mysqli_connect("localhost","root","","restaurant_system");

        if(!$con)
        {
            die("Connection Error :".mysqli_connect_error());
        }

        else
        {
            if($_GET['com']=="ban")
            {
               $str="UPDATE `restaurants` SET `valid` = 'N' WHERE `restaurants`.`res_id` = '".$_GET['res']."' ;";
            }
            else if($_GET['com']=="unban")
            {
                $str="UPDATE `restaurants` SET `valid` = 'Y' WHERE `restaurants`.`res_id` = '".$_GET['res']."' ;";
            }
            if(mysqli_query($con,$str))
            {
                header("location: Admin.php");
            }
            else
            {
                echo "<h1>YOUR REGISTRATION FAILED!</h1>";
            }
        }
    }

    if(isset($_GET['food']))
    {
        $con = mysqli_connect("localhost","root","","restaurant_system");

        if(!$con)
        {
            die("Connection Error :".mysqli_connect_error());
        }

        else
        {
            $str="DELETE FROM `foods` WHERE `foods`.`food_id` = ".$_GET['food']." ;";
            if(mysqli_query($con,$str))
            {
                header("location: food.php");
            }
            else
            {
                echo "<h1>YOUR REGISTRATION FAILED!</h1>";
            }
        }
    }
?>