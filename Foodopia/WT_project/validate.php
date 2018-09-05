<?php

session_start();

function nameValidation($s, $who) {
    $f = -1;
    $x = -1;
    $g =  1;
    for ($i = 0; $i < strlen($s); $i++) {
        if ($i == 0) {
            if ($s[$i] >= 'A' and $s[$i] <= 'Z') $x = 1;
            else if ($s[$i] >= 'a' and $s[$i] <= 'z') $x = 1;
            else {
                $x = -1;
                break;
            }
        }
        else if ($s[$i] == ' ' and $s[$i - 1] == ' ' and $f == 1) {
            $_SESSION[$who] = "NAME - Incorrect format!";
            return;
        }
        else if ($s[$i] == ' ') $f++;
        else if ($s[$i] >= 'A' and $s[$i] <= 'Z') continue;
        else if ($s[$i] >= 'a' and $s[$i] <= 'z') continue;
        else if ($s[$i] != '-' and $s[$i] != '.') {
            $g = -1;
            break;
        }
    }
    if ($g == 1) {
        if ($x == 1) {
            if ($f == 0) {
                //echo "<b>YOUR NAME: &nbsp</b>".$s."<br>";
            } else {
                $_SESSION[$who] = "NAME - Must contain atleast two words.";
            }
        } else {
            $_SESSION[$who] = "NAME - Must start with a letter.";
        }
    } else {
        $_SESSION[$who] = "NAME - Wrong character. Only period and dash allowed.";
    }
}

function dobValidation($dd, $mm, $yy, $who) {
    if ($dd == 31) {
        // Check if 31th day falls in right month
        if (!($mm == 1 or $mm == 3 or $mm == 5 or $mm == 7 or $mm == 8 or $mm == 10 or $mm == 12)) {
            $_SESSION[$who] .= ('\n'."BIRTHDATE - Wrong date input.");
        }
    } // Check February days
    else if ($dd > 29 and $mm == 2) {
        $_SESSION[$who] .= ('\n'."BIRTHDATE - Wrong date input.");
    } // Check leap year
    else if ($dd == 29 and $mm == 2) {
        if ($yy % 4 == 0) {
            if ($yy % 100 == 0) {
                if ($yy % 400 != 0) {
                    $_SESSION[$who] .= ('\n'."BIRTHDATE - Wrong date input.");
                }
            }
        } else {
            $_SESSION[$who] .= ('\n'."BIRTHDATE - Wrong date input.");
        }
    }
}

function emailValidation($s, $who) {
    if (filter_var($s, FILTER_VALIDATE_EMAIL)) {
        ////
    } else {
        $_SESSION[$who] .= ('\n'."EMAIL - Wrong email format.");
    }
}

function passwordValidation($s, $who) {
    // Checking format
    $c = 0;
    $n = 0;
    $m = 0;
    for ($i = 0; $i < strlen($s); $i++) {
        if ($s[$i] >= 'a' and $s[$i] <= 'z') $c = 1;
        else if ($s[$i] >= 'A' and $s[$i] <= 'Z') $c = 1;
        else if ($s[$i] >= '1' and $s[$i] <= '9') $n = 1;
        else if ($s[$i] == '@' or $s[$i] == '#' or $s[$i] == '$' or $s[$i] == '%') $m++;
    }
    if ($m == 0) {
        $_SESSION[$who] .= ('\n'."PASSWORD - Must contain atleast one speacial character. (@ # $ %)");
    }
}

function pictureValidation($who) {
    // Stuff we need to validate file and store in a location
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileTempName = $_FILES['file']['tmp_name'];
    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));
    $allowedFileTypes = array('jpg', 'jpeg', 'png');

    if ($fileSize == 0) {
        return;
    } else {
        if (in_array($fileExtension, $allowedFileTypes)) {
            if ($fileError == 0) {
                if ($fileSize <= 4194304) {
                    // new name for the file
                    $fileNewName = uniqid('', true).".".$fileExtension;
                    // delete the old profile picture
                    if ($who == "RVproblem" and $_SESSION['pic'] != "upload/def.png") unlink($_SESSION['pic']);
                    if ($who == "RSproblem" and $_SESSION['pic'] != "upload/res_def.png") unlink($_SESSION['pic']);
                    // move new picture to the upload folder
                    $_SESSION['pic'] = $fileNewDest = 'upload/'.$fileNewName;
                    move_uploaded_file($fileTempName, $fileNewDest);
                } else {
                    $_SESSION[$who] .= ('\n'."PICTURE - File size exceeds the limit (4 MB max).");
                }
            } else {
                $_SESSION[$who] .= ('\n'."PICTURE - File is broken.");
            }
        } else {
            $_SESSION[$who] .= ('\n'."PICTURE - Invalid file type.");
        }
    }
}

// REVIEWER / RESTAURANT PAGE LOGIN
if (isset($_POST['LGSubmit'])) {
    // Estabilishing connection to database
    $_flag = "NOPE";
    $con = mysqli_connect("localhost", "root", "", "restaurant_system");
    if (!$con) {
        die("Connection Error :".mysqli_connect_error());
    } else {
        $q1 = "SELECT * FROM reviewer WHERE email= '".$_POST['email']."';";
        $q2 = "SELECT * FROM restaurants WHERE email= '".$_POST['email']."';";
        // searching in reviwer table
        $result = mysqli_query($con, $q1);
        if (mysqli_num_rows($result) > 0) {
            $_flag = "reviewer";
            $row   = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $q3    = "SELECT COUNT(*) FROM reviews WHERE rev_username = '".$row['rev_username']."' and approval = 'Y'";
            $res   = mysqli_query($con, $q3);
            $haha  = mysqli_fetch_array($res, MYSQLI_ASSOC);
            $_SESSION['review_count'] = $haha['COUNT(*)'];
        } else {
            // searching in restaurants table
            $result = mysqli_query($con, $q2);
            if (mysqli_num_rows($result) > 0) {
                $_flag = "restaurant";
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else
            {
                $str="select * from admin where email= '".$_POST['email']."' and password= '".$_POST['password'] ."' ;";
                $result=mysqli_query($con, $str);
                if(mysqli_num_rows($result)>0)
                {
                    $row[0]=mysqli_fetch_array($result);
                    if($row[0]['admin_id']=="1")
                    {
                        $_SESSION['loggedIn'] = 3;
                        $_SESSION['name']=$row[0]['Name'];


                    }
                }
            }
        }
    }
    if ($_flag == "reviewer") {
        if ($_POST['password'] != $row['password']) {
            $_SESSION['success'] = "failed";
            header("location: login.php");
        } else {
            if ($row['valid'] == 'Y') {
                      // SET SESSION
                $_SESSION['name']      = $row["name"];
                $_SESSION['username']  = $row["rev_username"];
                $_SESSION['email']     = $row["email"];
                $_SESSION['password']  = $row["password"];
                $_SESSION['follower']  = $row["follower"];
                $_SESSION['following'] = $row["following"];
                $_SESSION['points']    = $row["points"];
                $_SESSION['pic']       = $row["picture"];
                $_SESSION['dob']       = $row['dob'];
                $_SESSION['loggedIn']  = 1;
                $_SESSION['success']   = "done";
                // SET COOKIE
                $cookie_content = "NAM".$_SESSION['name']."%^%EMA".$_SESSION['email']."%^%PAS".$_SESSION['password']."%^%USE".$_SESSION['username']."%^%DOB".$_SESSION['dob']."%^%PIC".$_SESSION['pic'];
                setcookie("FOODOPIA", $cookie_content, time()+86400*7, "/");
                // GO
                header("location: rev_prof.php");
            } else {
                $_SESSION['success'] = 'banned';
                header("location: login.php");
            }
        }
    } else if ($_flag == "restaurant") {
        if ($_POST['password'] != $row["password"]) {
            $_SESSION['success'] = "failed";
            header("location: login.php");
        } else {
            if ($row['valid'] == 'Y') {
                // SET SESSION
                $_SESSION['name']         = $row["name"];
                $_SESSION['res_id']       = $row["res_id"];
                $_SESSION['email']        = $row["email"];
                $_SESSION['password']     = $row["password"];
                $_SESSION['services']     = $row["services"];
                $_SESSION['location_id']  = $row["location_id"];
                $_SESSION['manager_name'] = $row["manager_name"];
                $_SESSION['pic']          = $row["picture"];
                $_SESSION['phone']        = $row['phone'];
                $_SESSION['cuisine']      = $row['cuisine'];
                $_SESSION['loggedIn']     = 2;
                $_SESSION['success']      = "done";

                // LOCATION INFO
                $q1 = "SELECT * FROM location WHERE location_id = '".$row['location_id']."'";
                $rs = mysqli_query($con, $q1);
                $ha = mysqli_fetch_array($rs, MYSQLI_ASSOC);
                $_SESSION['house'] = $ha['house'];
                $_SESSION['road']  = $ha['road'];
                $_SESSION['city']  = $ha['city'];
                $_SESSION['area']  = $ha['area'];
                $_SESSION['longitude'] = $ha['longitude'];
                $_SESSION['latitude'] = $ha['latitude'];

                $q1  = "SELECT COUNT(*) FROM reviews WHERE res_id = '".$row['res_id']."' and approval = 'Y'";
                $rs  = mysqli_query($con, $q1);
                $ha  = mysqli_fetch_array($rs, MYSQLI_ASSOC);
                $_SESSION['review_count'] = $ha['COUNT(*)'];

                // SET COOKIE
                // $cookie_content = "NAM".$_SESSION['name']."%^%EMA".$_SESSION['email']."%^%PAS".$_SESSION['password']."%^%USE".$_SESSION['username']."%^%DOB".$_SESSION['dob']."%^%PIC".$_SESSION['pic'];
                //setcookie("FOODOPIA", $cookie_content, time()+86400*7, "/");
                // GO
                header("location: res_prof.php");
            } else {
                $_SESSION['success'] = "Pbanned";
                header("location: login.php");
            }
        }
    } else {
        $_SESSION['success'] = "failed";
        header("location: login.php");
    }
}

// PASSWORD RESET
if (isset($_POST['SDVerf'])) {
    $row;
    // Estabilishing connection to database
    $_flag = "NOPE";
    $con = mysqli_connect("localhost", "root", "", "restaurant_system");
    if (!$con) {
        die("Connection Error :".mysqli_connect_error());
    } else {
        $q1 = "select * from reviewer where email= '".$_POST['email']."';";
        $q2 = "select * from restaurants where email= '".$_POST['email']."';";
        // searching in reviwer table
        $result = mysqli_query($con, $q1);
        if (mysqli_num_rows($result) > 0) {
            $_flag = "reviewer";
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        } else {
            // searching in restaurants table
            $result = mysqli_query($con, $q2);
            if (mysqli_num_rows($result) > 0) {
                $_flag = "restaurant";
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            }
        }
    }

    if ($_flag == "reviewer" or $_flag == "restaurant") {
        // Generate a Random number from given string
        $token = "plskfuetcbcgsj10269s9sd51sd31sd";
        $token = str_shuffle($token);
        $token = $_SESSION['token'] = substr($token, 0, 6);

        // Link live for 90 seconds
        setcookie('FOODOPIA_RESET_CODE', $token, time() + 90);
        $resetLink = 'http://localhost/WT_project/reset.php?email='.$_POST['email'].'&code='.$token;
        $subject = "Password reset";
        $to = $_SESSION['recmail'] = $_POST['email'];

        // Mail body sent to user
        $mail = 'Dear '.$row['name'].', <br><br> Foodopia.com has received a request to reset the password for your account. If you did not request to reset your password, please ignore this email.<br><br><a href="'.$resetLink.'" style="font-style: "Roboto Condensed"; text-color: black; border: 3px solid; color: black">RESET PASSWORD</a><br><br>Regards,<br>Foodopia Team';
        $header = "MIME-Version: 1.0"."\r\n";
        $header .="Content-type:text/html;charset=UTF-8" . "\r\n" ;
        $header .= 'From: FOODOPIA<sender@example.com>'. "\r\n" ;

        if (mail($to, $subject, $mail, $header)) {
            $_SESSION['f_success'] = "GO";
            header("location: forgot.php?q=GO");
        } else {
            $_SESSION['f_success'] = "shit";
            header("location: forgot.php");
        }
    } else {
        $_SESSION['f_success'] = "failed";
        header("location: forgot.php");
    }
}

// CHANGING PASSWORD
if (isset($_POST['RSConfirm'])) {
    //passwordValidation($_POST['pass']);
    $con = mysqli_connect("localhost", "root", "", "restaurant_system");
    if (!$con) {
        die("Connection Error :".mysqli_connect_error());
    } else {
        $q1 = "SELECT * FROM reviewer WHERE email= '".$_SESSION['recmail']."';";
        // searching in reviwer table
        $result = mysqli_query($con, $q1);
        if (mysqli_num_rows($result) > 0) {
            $q1 = "UPDATE `reviewer` SET `password`= '".$_POST['pass']."' WHERE email = '".$_SESSION['recmail']."'";
        } else {
            $q1 = "UPDATE `restaurants` SET `password`= '".$_POST['pass']."' WHERE email = '".$_SESSION['recmail']."'";
        }
        // update password
        if (mysqli_query($con, $q1)) {
            $_SESSION['f_success'] = "DONE BABAY!";
            header("location: forgot.php?q=success");
        } else {
            header("location: forgot.php");
        }
    }
}

// REVIEWER SIGNUP
if (isset($_POST['RVSignUp'])) {
    $_SESSION['RVproblem'] = "";
    // Removing any extra spaces
    $_POST['Fname'] = trim($_POST['Fname'], " ");
    $_POST['Lname'] = trim($_POST['Lname'], " ");
    // Validation
    nameValidation($_POST['Fname']." ".$_POST['Lname'], "RVproblem");
    dobValidation($_POST['BirthDay'], $_POST['BirthMonth'], $_POST['BirthYear'], "RVproblem");
    emailValidation($_POST['email'], "RVproblem");
    passwordValidation($_POST['password'], "RVproblem");
    if ($_SESSION['RVproblem'] != "") {
        header("location: rev_reg.php");
    } else {
        // Estabilishing connection to database
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        if (!$con) {
            die("Connection Error :".mysqli_connect_error());
        } else {
            $q1 = "select * from reviewer where email= '".$_POST['email']."';";
            $r1 = mysqli_query($con, $q1);
            if (mysqli_num_rows($r1) > 0) {
                $_SESSION['RVproblem'] = "The email provided is already registered.";
                header("location: rev_reg.php");
            } else {
                // Concating DOB
                $dob = $_POST['BirthDay']."/".$_POST['BirthMonth']."/".$_POST['BirthYear'];
                $q1 = "INSERT INTO `reviewer`(`rev_username`, `name`, `email`, `password`, `picture`, `dob`) VALUES ('".$_POST['username']."', '".$_POST['Fname']." ".$_POST['Lname']."', '".$_POST['email']."', '".$_POST['rpassword']."', 'upload/def.png', '".$dob."')";
                if (mysqli_query($con, $q1)) {
                    unset($_SESSION['RVProblem']);
                    $_SESSION['REGWin'] = "true";
                    header("location: reg_win.php?q=rev");
                } else {
                    $_SESSION['RVproblem'] = "USERNAME - This username is already registered.";
                    header("location: rev_reg.php");
                }
            }
        }
    }
}

// RESTAURANT SIGNUP // BLACK MAGIC INVOLVED
if (isset($_POST['RSSignUp'])) {
    $_SESSION['RSproblem'] = "";
    // Validation
    // nameValidation($_POST['Rname'], "RSproblem"); MAKE THIS ANOTHER FUCNTION!!!!!!!
    emailValidation($_POST['email'], "RSproblem");
    passwordValidation($_POST['password'], "RSproblem");

    // ADD MANAGER VALIDATION FOR NAME!!!!!!!!!

    if ($_SESSION['RSproblem'] != "") {
        header("location: res_reg.php");
    } else {
        // Estabilishing connection to database
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        if (!$con) {
            die("Connection Error :".mysqli_connect_error());
        } else {
            $q2 = "SELECT * FROM restaurants WHERE email= '".$_POST['email']."';";
            $r2 = mysqli_query($con, $q2);

            if (mysqli_num_rows($r2) > 0) {
                $_SESSION['RSproblem'] = "The email provided is already registered.";
                header("location: res_reg.php");
            } else {

                $q1  = "SELECT location_id FROM restaurants";
                $res = mysqli_query($con, $q1);
                $LID = -1;
                for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                    $ans[$i] = mysqli_fetch_array($res);
                    $LID = max($LID, $ans[$i]['location_id']);
                }
                $LID += 1;

                $qX  = "INSERT INTO `restaurants` (`name`, `manager_name`, `email`, `password`, `location_id`) VALUES ('".$_POST['Rname']."', '".$_POST['m_name']."', '".$_POST['email']."', '".$_POST['password']."', '".$LID."');";

                if (mysqli_query($con, $qX)) {
                    unset($_SESSION['RSproblem']);
                    $_SESSION['REGWin'] = "true";
                    $q1 = "INSERT INTO `location`(`location_id`, `area`, `city`) VALUES ('".$LID."', '".$_POST['area']."', '".$_POST['city']."');";
                    mysqli_query($con, $q1);
                    /// JA EKHAN THEKE
                    header("location: reg_win.php?q=res");
                } else {
                    $_SESSION['RSproblem'] = "THIS RESTAURANT IS ALREADY REGISTERED.";
                    header("location: res_reg.php");
                }
            }
        }
    }
}

// REVIEWER PROFILE EDIT
if (isset($_POST['RVEdit'])) {
    $_SESSION['RVproblem'] = "";
    // new name
    $new_name = "";
    $_POST['Fname'] = trim($_POST['Fname'], " ");
    $_POST['Lname'] = trim($_POST['Lname'], " ");
    $name = explode(" ", $_SESSION['name']);
    if (strlen($_POST['Fname']) > 0 and strlen($_POST['Lname']) > 0) {
        $new_name = $_POST['Fname']." ".$_POST['Lname'];
    } else if (strlen($_POST['Fname']) > 0) {
        $new_name = $_POST['Fname']." ".$name[1];
    } else if (strlen($_POST['Lname']) > 0) {
        $new_name = $name[0]." ".$_POST['Lname'];
    } else {
        $new_name = $_SESSION['name'];
    }
    // new email
    $new_email = "";
    if (strlen($_POST['email']) > 0) {
        $new_email = $_POST['email'];
    } else {
        $new_email = $_SESSION['email'];
    }
    // new pass
    $new_password = "";
    if (strlen($_POST['password']) > 0) {
        $new_password = $_POST['password'];
    } else {
        $new_password = $_SESSION['password'];
    }
    // Now validate the data
    nameValidation($new_name, "RVproblem");
    emailValidation($new_email, "RVproblem");
    passwordValidation($new_password, "RVproblem");
    pictureValidation("RVproblem");
    // new birthdate
    $new_dob = "";
    $old_dob = explode("/", $_SESSION['dob']);
    if (strlen($_POST['BirthDay']) > 0 and strlen($_POST['BirthMonth']) > 0 and strlen($_POST['BirthYear']) > 0) {
        $new_dob = $_POST['BirthDay']."/".$_POST['BirthMonth']."/".$_POST['BirthYear'];
        dobValidation($_POST['BirthDay'], $_POST['BirthMonth'], $_POST['BirthYear'], "RVproblem");
    }
    else if (strlen($_POST['BirthDay']) > 0 and strlen($_POST['BirthMonth']) > 0) {
        $new_dob = $_POST['BirthDay']."/".$_POST['BirthMonth']."/".$old_dob[2];
        dobValidation($_POST['BirthDay'], $_POST['BirthMonth'], (int)$old_dob[2], "RVproblem");
    }
    else if (strlen($_POST['BirthDay']) > 0 and strlen($_POST['BirthYear']) > 0) {
        $new_dob = $_POST['BirthDay']."/".$old_dob[1]."/".$_POST['BirthYear'];
        dobValidation($_POST['BirthDay'], (int)$old_dob[1], $_POST['BirthYear'], "RVproblem");
    }
    else if (strlen($_POST['BirthMonth']) > 0 and strlen($_POST['BirthYear']) > 0) {
        $new_dob = $old_dob[0]."/".$_POST['BirthMonth']."/".$_POST['BirthYear'];
        dobValidation((int)$old_dob[0], $_POST['BirthMonth'], $_POST['BirthYear'], "RVproblem");
    }
    else if (strlen($_POST['BirthDay']) > 0) {
        $new_dob = $_POST['BirthDay']."/".$old_dob[1]."/".$old_dob[2];
        dobValidation($_POST['BirthDay'], (int)$old_dob[1], (int)$old_dob[2], "RVproblem");
    }
    else if (strlen($_POST['BirthMonth']) > 0) {
        $new_dob = $old_dob[0]."/".$_POST['BirthMonth']."/".$old_dob[2];
        dobValidation((int)$old_dob[0], $_POST['BirthMonth'], (int)$old_dob[2], "RVproblem");
    }
    else if (strlen($_POST['BirthYear']) > 0) {
        $new_dob = $old_dob[0]."/".$old_dob[1]."/".$_POST['BirthYear'];
        dobValidation((int)$old_dob[0], (int)$old_dob[1], $_POST['BirthYear'], "RVproblem");
    }
    else {
        $new_dob = $_SESSION['dob'];
    }
    // check if all ok
    if ($_SESSION['RVproblem'] != "") {
        header("location: rev_prof.php?q=edit_profile");
    } else {
        $_SESSION['RVproblem'] = "nope";
        // Estabilishing connection to database
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        if (!$con) {
            die("Connection Error :".mysqli_connect_error());
        } else {
            $q1 = "select * from reviewer where email= '".$_POST['email']."';";
            $q2 = "select * from restaurants where email= '".$_POST['email']."';";
            $r1 = mysqli_query($con, $q1);
            $r2 = mysqli_query($con, $q2);
            if ((mysqli_num_rows($r1) > 0 or mysqli_num_rows($r2) > 0) and strlen($_POST['email']) > 0) {
                $_SESSION['RVproblem'] = "EMAIL - The email provided is already registered.";
                header("location: rev_prof.php?q=edit_profile");
            } else {
                $query = "UPDATE `reviewer` SET `name`='".$new_name."',`dob`='".$new_dob."',`email`='".$new_email."',`password`='".$new_password."',`picture`='".$_SESSION['pic']."' WHERE rev_username = '".$_SESSION['username']."'";
                if (mysqli_query($con, $query)) {
                    unset($_SESSION['RVProblem']);// = "nope";
                    $_SESSION['name']      = $new_name;
                    $_SESSION['email']     = $new_email;
                    $_SESSION['password']  = $new_password;
                    $_SESSION['dob']       = $new_dob;
                    // SET COOKIE
                    $cookie_content = "NAM".$_SESSION['name']."%^%EMA".$_SESSION['email']."%^%PAS".$_SESSION['password']."%^%USE".$_SESSION['username']."%^%DOB".$_SESSION['dob']."%^%PIC".$_SESSION['pic'];
                    setcookie("FOODOPIA", $cookie_content, time()+86400*7, "/");
                    header("location: rev_prof.php?q=profile");
                } else {
                    $_SESSION['RVproblem'] = "PROBLEM - error L0L";
                    header("location: rev_prof.php?q=edit_profile");
                }
            }
        }
    }
}

// RESTAURANT PROFILE EDIT
if (isset($_POST['RS_INFO_EDIT'])) {
    $_SESSION['RSproblem'] = "";
    // Validation not done yet
    if ($_POST['Rname'] == "") $_POST['Rname'] = $_SESSION['name'];
    if ($_POST['cuisine'] == "") $_POST['cuisine'] = $_SESSION['cuisine'];

    // Validation done!
    if ($_POST['Mname'] == "") $_POST['Mname'] = $_SESSION['manager_name'];
    else nameValidation($_POST['manager_name'], "RSproblem");
    if ($_POST['email'] == "") $_POST['email'] = $_SESSION['email'];
    else emailValidation($_POST['email'], "RSproblem");
    if ($_POST['password'] == "" or $_POST['password'] == $_SESSION['password']) $_POST['password'] = $_SESSION['password'];
    else passwordValidation($_POST['password'], "RSproblem");
    //
    pictureValidation("RSproblem");

    if ($_SESSION['RSproblem'] != "") {
        header("location: res_prof.php?q=rs_edit");
    } else {
        $_SESSION['RSproblem'] = "nope";
        // Estabilishing connection to database
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        // QUERY KORTSI
        $qX = "UPDATE `restaurants` SET `name`='".$_POST['Rname']."', `picture`='".$_SESSION['pic']."', `manager_name`='".$_POST['Mname']."',`email`='".$_POST['email']."',`password`='".$_POST['password']."',`phone`='".$_POST['phone']."',`cuisine`='".$_POST['cuisine']."' WHERE `restaurants`.`res_id` = '".$_SESSION['res_id']."';";

        if (mysqli_query($con, $qX)) {
            unset($_SESSION['RSproblem']);
            $_SESSION['name']      = $_POST['Rname'];
            $_SESSION['email']     = $_POST['email'];
            $_SESSION['password']  = $_POST['password'];
            $_SESSION['phone']     = $_POST['phone'];
            $_SESSION['cuisine']   = $_POST['cuisine'];

            // SET COOKIE
            //$cookie_content = "NAM".$_SESSION['name']."%^%EMA".$_SESSION['email']."%^%PAS".$_SESSION['password']."%^%USE".$_SESSION['username']."%^%DOB".$_SESSION['dob']."%^%PIC".$_SESSION['pic'];
            //setcookie("FOODOPIA", $cookie_content, time()+86400*7, "/");
            header("location: res_prof.php");
        } else {
            $_SESSION['RSproblem'] = "PROBLEM - error L0L";
            header("location: res_prof.php?q=rs_edit");
        }
    }
}

if (isset($_POST['RSLOC_INFO_EDIT'])) { // update location
    $_POST['road'] = ((strlen($_POST['road']))==0? $_SESSION['road']:$_POST['road']);
    $_POST['house'] = ((strlen($_POST['house']))==0? $_SESSION['house']:$_POST['house']);

    $con=mysqli_connect("localhost","root","","restaurant_system");
    if($con){
        $query = "update location set road='".$_POST['road']."',house='".$_POST['house']."',city='".$_POST['city']."',area='".$_POST['area']."' WHERE location_id='".$_SESSION['location_id']."';";
        if (mysqli_query($con, $query)) {
            $_SESSION['area'] = $_POST['area'];
            $_SESSION['city'] = $_POST['city'];
            $_SESSION['house'] = $_POST['house'];
            $_SESSION['road'] = $_POST['road'];

            /// SOUROV MAP ADD KOR !!!!!!!!!

            $_SESSION['address']="";
            if($_POST['house']!="")
            {
                $house="House ".$_POST['house'];
            }
            if($_POST['road']!="")
            {
                $road="Road ".$_POST['road'];
            }

            $area=$_POST['area'];
            $city=$_POST['city'];

            if($_POST['house']==NULL and $_POST['road']==NULL)
            {
                $_SESSION['address']=$area.", ".$city.", "."Bangladesh";
            }
            else if($_POST['house']==NULL and $_POST['road']!="")
            {
                $_SESSION['address']=$road.", ".$area.", ".$city.", "."Bangladesh";
            }
            else if($_POST['house']!="" and $_POST['road']==NULL)
            {
                $_SESSION['address']=$house.", ".$area.", ".$city.", "."Bangladesh";
            }
            else if($_POST['house']!="" and $_POST['road']!="")
            {
                $_SESSION['address']=$house.", ".$road.", ".$area.", ".$city.", "."Bangladesh";
            }
            header("location: ../PHP/index.php");
            //header("location: res_prof.php");
        }
    } else {
         die("Connection Error :".mysqli_connect_error());
    }
}

if (isset($_POST['FOOD_ADD'])) {
    $con = mysqli_connect("localhost","root","","restaurant_system");
    $qX  = "INSERT INTO `foods`(`res_id`, `food_name`, `food_price`) VALUES ('".$_SESSION['res_id']."', '".$_POST['FoodName']."', '".$_POST['Price']."');";
    if (mysqli_query($con, $qX)) {
        header("location: res_prof.php?q=rs_edit#FOOOD");
    } else {
        //$_SESSION['RSproblem'] = "Food Adding Problem!";
        header("location: res_prof.php?q=rs_edit#FOOOD");
    }
}

if (isset($_POST['ADD_SERVICE'])) {
    $con = mysqli_connect("localhost","root","","restaurant_system");

    if ($_SESSION['services'] != "") {
        $go = explode('%', $_SESSION['services']);
        for ($i = 0; $i < count($go); $i++) {
            if ($_POST['ServiceName'] == $go[$i]) {
                header("location: res_prof.php?q=rs_edit#SERVICE");
                exit();
            }
        }
        $_POST['ServiceName'] = $_SESSION['services']."%".$_POST['ServiceName'];
    }

    $qX  = "UPDATE `restaurants` SET `services` = '".$_POST['ServiceName']."' where res_id = '".$_SESSION['res_id']."';";

    if (mysqli_query($con, $qX)) {
        $_SESSION['services'] = $_POST['ServiceName'];
        header("location: res_prof.php?q=rs_edit#SERVICE");
    } else {
        $_SESSION['RSproblem'] = "Service Adding Problem!";
        header("location: res_prof.php?q=rs_edit");
    }
}

// LOGOUT and AJAX SHIZ
if (isset($_REQUEST['q'])) {
    if ($_REQUEST['q'] == "logout") {
        session_destroy();
        header("location: login.php");
    } else if ($_REQUEST['q'] == "load_reviews") {
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        if (!$con) {
             die('Could not connect: ' . mysqli_error($con));
        } else {
            $query1 = "SELECT * From reviews where restaurant LIKE '%".$_REQUEST['n']."%' AND rev_username= '".$_SESSION['username']."';";
            $query2 = "SELECT * From reviews where rev_username= '".$_SESSION['username']."';";
            // decide which query to be executed
            if ($_REQUEST['n'] == "null") {
                $res = mysqli_query($con, $query2);
            } else {
                $res = mysqli_query($con, $query1);
            }
            // AJAXing shit
            if (mysqli_num_rows($res) > 0) {
                for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                    $row[$i] = mysqli_fetch_array($res);
                    // Setting color for rating
                    if ($row[$i]['rating'] == "GOOD") $col = "green";
                    else if ($row[$i]['rating'] == "AVERAGE") $col = "orange";
                    else $col = "red";
                    // Print review
                    echo "<h3>".$row[$i]['restaurant']."&nbsp; &nbsp;<small style='font-size: 13px;'>".$row[$i]['date']."</small></h3>"."<h4 style='margin-top: -15;'>Review: <small style='font-size: 20px; color: ".$col."'>".$row[$i]['rating']."</small></h4>"."<p style='margin-top: -15; margin-bottom: 40;'>".$row[$i]['review']."</p>";
                }
            } else {
                echo "<h1>NO REVIEWS POSTED YET!</h1>";
            }
        }
    } else if ($_REQUEST['q'] == "ForF") {
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        if ($_REQUEST['w'] == "Follow") {
            // USER 1
            if ($_SESSION['following'] == "") $_SESSION['following'] = $_REQUEST['UN'];
            else $_SESSION['following'] .= "@".$_REQUEST['UN'];
            $qry1 = "UPDATE `reviewer` SET `following`='".$_SESSION['following']."' WHERE rev_username = '".$_SESSION['username']."'";
            $res  = mysqli_query($con, $qry1);
            // USER 2
            $qry2 = "SELECT follower From reviewer WHERE rev_username = '".$_REQUEST['UN']."';";
            $res  = mysqli_query($con, $qry2);
            $row  = mysqli_fetch_array($res, MYSQLI_ASSOC);
            if ($row['follower'] == "") $row['follower'] = $_SESSION['username'];
            else $row['follower'] .= "@".$_SESSION['username'];
            $qry1 = "UPDATE `reviewer` SET `follower`='".$row['follower']."' WHERE rev_username = '".$_REQUEST['UN']."'";
            $res  = mysqli_query($con, $qry1);
        } else {
            // USER 1
            $f_c = explode("@", $_SESSION['following']);
            $_SESSION['following'] = "";
            for ($i = 0; $i < count($f_c); $i++) {
                if ($f_c[$i] == $_REQUEST['UN']) continue;
                else {
                    if ($_SESSION['following'] == "") $_SESSION['following'] = $f_c[$i];
                    else $_SESSION['following'] .= "@".$f_c[$i];
                }
            }
            $qry1 = "UPDATE `reviewer` SET `following`='".$_SESSION['following']."' WHERE rev_username = '".$_SESSION['username']."'";
            $res  = mysqli_query($con, $qry1);
            // USER 2
            $qry2 = "SELECT `follower` From reviewer WHERE rev_username = '".$_REQUEST['UN']."';";
            $res  = mysqli_query($con, $qry2);
            $hah  = mysqli_fetch_array($res, MYSQLI_ASSOC);
            $f_c  = explode("@", $hah['follower']);
            $ans  = "";
            for ($i = 0; $i < count($f_c); $i++) {
                if ($f_c[$i] == $_SESSION['username']) continue;
                else {
                    if ($ans == "") $ans = $f_c[$i];
                    else $ans .= "@".$f_c[$i];
                }
            }
            $qry1 = "UPDATE `reviewer` SET `follower`='".$ans."' WHERE rev_username = '".$_REQUEST['UN']."'";
            $res  = mysqli_query($con, $qry1);
        }
    } else if ($_REQUEST['q'] == 'DELREV') {
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        } else {
            $query = "DELETE FROM reviews where review_id = '".$_REQUEST["id"]."';";
            if (mysqli_query($con, $query)) {
                $_SESSION['review_count']--;
            }
        }
    } else if ($_REQUEST['q'] == 'removeFood') {
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        } else {
            $query = "DELETE FROM foods where food_id = '".$_REQUEST["id"]."';";
            mysqli_query($con, $query);
        }
    } else if ($_REQUEST['q'] == 'removeService') {
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        $go = explode('%', $_SESSION['services']);
        $_SESSION['services'] = "";

        $flag = 0;
        for ($i = 0; $i < count($go); $i++) {
            if ($go[$i] == $_REQUEST['id']) continue;
            else {
                if ($flag == 0) {
                    $_SESSION['services'] .= $go[$i];
                    $flag = 1;
                } else {
                    $_SESSION['services'] = $_SESSION['services'] . "%" . $go[$i];
                }
            }
        }
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        } else {
            $query = "UPDATE `restaurants` SET `services` = '".$_SESSION['services']."' where res_id = '".$_SESSION['res_id']."';";
            mysqli_query($con, $query);
        }
    } else if ($_REQUEST['q'] == 'edit') {
            $con = mysqli_connect("localhost", "root", "", "restaurant_system");
            if (!$con) {
                die('Could not connect: ' . mysqli_error($con));
            } else {

                if ($_REQUEST['what'] == "food_name"){
                    $query = "UPDATE `foods` SET `food_name` = '".$_REQUEST['val']."' WHERE food_name = '".$_REQUEST['org']."' and res_id='".$_REQUEST['id']."';";
                    mysqli_query($con, $query);
                } else {
                    $query = "UPDATE `foods` SET `food_price` = '".$_REQUEST['val']."' WHERE food_price = '".$_REQUEST['org']."' and res_id='".$_REQUEST['id']."';";
                    mysqli_query($con, $query);
                }
        }
    } else if ($_REQUEST['q'] == 'edit_Service') { //services
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        } else {
            $go = explode('%', $_SESSION['services']);
            $_SESSION['services'] = "";
            $flag = 0;
            for ($i = 0; $i < count($go); $i++) {
                if($flag==0){
                    if ($go[$i] == $_REQUEST['org']){
                        $_SESSION['services'] .= $_REQUEST['val'];
                    }
                    else{
                        $_SESSION['services'] = $_SESSION['services'] . "%" . $go[$i];
                    }
                    $flag=1;
                }
                else{
                    if ($go[$i] == $_REQUEST['org']){
                        $_SESSION['services'] .= $_REQUEST['val'];
                    }
                    else {
                        $_SESSION['services'] = $_SESSION['services'] . "%" . $go[$i];
                    }
                }
            }

            $query = "UPDATE `restaurants` SET `services` = '".$_SESSION['services']."' where res_id = '".$_REQUEST['id']."';";
            mysqli_query($con, $query);
        }
    } else if ($_REQUEST['q'] == "search") {
        $yes = 0;
        $result = "";
        $con = mysqli_connect("localhost","root","","restaurant_system");
        if (!$con) {
            die("Connection Error : ".mysqli_connect_error() );
        } else {
            $loc = "SELECT * from location ;";
            $resloc = mysqli_query($con, $loc);
            echo "<strong style='font-size: 18px;'>RESTAURANTS</strong>";
            for ($i = 0; $i < mysqli_num_rows($resloc); $i++) {
                $locarea[$i] = mysqli_fetch_array($resloc);
                $area = $locarea[$i]['area'];
                if (ucfirst(strtolower($_REQUEST["val"])) == $area) {
                    $yes = 1;
                    //echo $locid=$locarea[$i]['location_id'];
                    $str = "SELECT * from restaurants WHERE `restaurants`.`location_id` = '".$locarea[$i]['location_id']."' AND `restaurants`.`valid` = 'Y' ;";
                    $res = mysqli_query($con, $str);
                    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                    $result = $result .'<div class="search-result">'."<a href="."Restaurant.php?res=".$row['res_id'].">".$row['name']."</a>".'</div>';
                }
            }

            if ($yes == 1) echo $result;

            if ($yes != 1) {
                $str     = "SELECT * from restaurants WHERE name LIKE '%".$_REQUEST["val"]."%' AND `restaurants`.`valid` = 'Y' ;";
                $res     = mysqli_query($con, $str);
                $name    = "";
                $cuisine = "";
                $count   = "";
                $result  = "";
                for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                    $row[$i] = mysqli_fetch_array($res);
                    $result  = $result .'<div class="search-result">'."<a href="."res_prof2.php?RES_ID=".$row[$i]['res_id'].">".$row[$i]['name']."</a>".'</div>';
                }
                if ($result == "") {
                    echo "</br> No Result Found </br>";
                } else {
                    echo $result;
                }
            }
            echo "<hr><strong style='font-size: 18px;'>REVIEWERS</strong>";
            $str     = "SELECT * from reviewer WHERE name LIKE '%".$_REQUEST["val"]."%' AND `reviewer`.`valid` = 'Y' ;";
            $res     = mysqli_query($con,$str);
            $name    = "";
            $cuisine = "";
            $count   = "";
            $reve    = "";

            for($i=0;$i<mysqli_num_rows($res);$i++)
            {
                $row[$i]=mysqli_fetch_array($res);
                $reve = $reve .'<div class="search-result">'."<a href="."rev2_prof.php?UN=".$row[$i]['rev_username'].">".$row[$i]['name']."</a>".'</div>';
            }
            if($reve=="")
            {
                echo "</br> No Result Found </br>";
            }
            else
            {
                echo $reve ;
            }
        }
    }  else if($_REQUEST['q']=='show'){ //show reviews
        if($_REQUEST['REV']=='good'){
            $con = mysqli_connect("localhost", "root", "", "restaurant_system");

            $qry = "select * from reviews where res_id= '".$_REQUEST['id']."' and rating= 'GOOD' and approval ='Y';"; //approval thakbe


            $res = mysqli_query($con, $qry);
            $col = "";
            if (mysqli_num_rows($res) > 0) {
                for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                        if ($i != 0) echo "<hr  style='margin-left: 10px; margin-right:10px;'>";
                        $row[$i] = mysqli_fetch_array($res);
                        // Setting color for rating
                        if ($row[$i]['rating'] == "GOOD") $col = "green";
                        else if ($row[$i]['rating'] == "AVERAGE") $col = "orange";
                        else $col = "red";
                        // Print review
                        echo "
                        <h3>".$row[$i]['rev_username']."&nbsp; &nbsp;
                            <small style='font-size: 13px;'>".$row[$i]['date']."</small>
                        </h3>"."
                        <h4 style='margin-top: -15;'>Review:
                            <small style='font-size: 20px; color: ".$col."'>".$row[$i]['rating']."</small>
                        </h4>"."
                        <p style='margin-left: 0; margin-top: -10; margin-bottom: 35;'>".$row[$i]['review']."</p>";

                    }
            }
        }
        else if($_REQUEST['REV']=='bad'){
            $con = mysqli_connect("localhost", "root", "", "restaurant_system");

            $qry = "select * from reviews where res_id= '".$_REQUEST['id']."' and rating= 'BAD' and approval ='Y';"; //approval thakbe

            $res = mysqli_query($con, $qry);
            $col = "";
            if (mysqli_num_rows($res) > 0) {
                for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                        if ($i != 0) echo "<hr  style='margin-left: 300px; margin-right: 300px;'>";
                        $row[$i] = mysqli_fetch_array($res);
                        // Setting color for rating
                        if ($row[$i]['rating'] == "GOOD") $col = "green";
                        else if ($row[$i]['rating'] == "AVERAGE") $col = "orange";
                        else $col = "red";
                        // Print review
                        echo "
                        <h3>".$row[$i]['rev_username']."&nbsp; &nbsp;
                            <small style='font-size: 13px;'>".$row[$i]['date']."</small>
                        </h3>"."
                        <h4 style='margin-top: -15;'>Review:
                            <small style='font-size: 20px; color: ".$col."'>".$row[$i]['rating']."</small>
                        </h4>"."
                        <p style='margin-left: 0; margin-top: -10; margin-bottom: 35;'>".$row[$i]['review']."</p>";

                    }
            }
        }
        if($_REQUEST['REV']=='avg'){
            $con = mysqli_connect("localhost", "root", "", "restaurant_system");

            $qry = "select * from reviews where res_id= '".$_REQUEST['id']."' and rating= 'AVERAGE' and approval ='Y';";

            $res = mysqli_query($con, $qry);
            $col = "";
            if (mysqli_num_rows($res) > 0) {
                for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                        if ($i != 0) echo "<hr  style='margin-left: 300px; margin-right: 300px;'>";
                        $row[$i] = mysqli_fetch_array($res);
                        // Setting color for rating
                        if ($row[$i]['rating'] == "GOOD") $col = "green";
                        else if ($row[$i]['rating'] == "AVERAGE") $col = "orange";
                        else $col = "red";
                        // Print review
                        echo "
                        <h3>".$row[$i]['rev_username']."&nbsp; &nbsp;
                            <small style='font-size: 13px;'>".$row[$i]['date']."</small>
                        </h3>"."
                        <h4 style='margin-top: -15;'>Review:
                            <small style='font-size: 20px; color: ".$col."'>".$row[$i]['rating']."</small>
                        </h4>"."
                        <p style='margin-left: 0; margin-top: -10; margin-bottom: 35;'>".$row[$i]['review']."</p>";

                    }
            }
        }
    }
    else if($_REQUEST['q']=='CAL'){ //calculate
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        }
        else{
            $QTOTAL = "SELECT rating from reviews WHERE res_id='".$_REQUEST['id']."' AND approval='Y';";
            $res  = mysqli_query($con, $QTOTAL);
            $total = mysqli_num_rows($res);

            $QGOOD = "SELECT rating from reviews WHERE rating='GOOD' AND res_id='".$_REQUEST['id']."' AND approval='Y';";
            $res  = mysqli_query($con, $QGOOD);
            $good = mysqli_num_rows($res);

            $QBAD = "SELECT rating from reviews WHERE rating='BAD' AND res_id='".$_REQUEST['id']."' AND approval='Y';";
            $res  = mysqli_query($con, $QBAD);
            $bad = mysqli_num_rows($res);

            $QAVG = "SELECT rating from reviews WHERE rating='AVERAGE' AND res_id='".$_REQUEST['id']."' AND approval='Y';";
            $res  = mysqli_query($con, $QAVG);
            $avg = mysqli_num_rows($res);

            echo $total."#".$good."#".$bad."#".$avg;
        }
    }
}

// POSTING A REVIEW
if (isset($_POST['PRSubmit'])) {
    $con = mysqli_connect("localhost","root","","restaurant_system");
    $qX  = "INSERT INTO `reviews`(`rating`, `res_id`, `rev_username`, `restaurant`, `review`) VALUES ('".$_POST['RATING']."', '".$_SESSION['REVIEW_OF_RES_ID']."', '".$_SESSION['username']."', '".$_SESSION['REVIEW_OF_RES_NAME']."', '".$_POST['input_review']."');";

    mysqli_query($con, $qX);
    header('location: res_prof2.php?RES_ID='.$_SESSION['REVIEW_OF_RES_ID'].'&RES_NAME='.$_SESSION['REVIEW_OF_RES_NAME']);
}

?>