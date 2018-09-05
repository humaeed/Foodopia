<?php
    session_start();
    if(isset($_GET['key']))
    {
        if($_GET['key']=="reviewers")
        {
            $_SESSION['reviewer']=1; unset($_SESSION['rev']);
            unset($_SESSION['restaurant']);

            $con=mysqli_connect("localhost","root","","restaurant_system");
            if(!$con)
            {
                die("Connection Error : ".mysqli_connect_error() );
            }
            else
            {
                $str="SELECT * from reviewer ;";
                $res=mysqli_query($con,$str);
                
                if(mysqli_num_rows($res)==0)
                {
                    echo "<tr>";
                    echo "<td>No Data Available</td>";
                }
                else
                {
                    $str="SELECT * from reviewer WHERE `reviewer`.`valid` = 'Y' ;";
                    $res=mysqli_query($con,$str);
                    $name="";
                    $username="";
                    $email="";
                    $password="";
                    echo "
                    <tr>
                            <th>User Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Approved</th>
                            <th>Declined</th>
                            <th>Total</th>
                            <th>Operation</th>
                    </tr> " ;

                for($i=0;$i<mysqli_num_rows($res);$i++)
                {
                    $row[$i]=mysqli_fetch_array($res);
                    $name="<br/>".$row[$i]['name'];
                    $username="<br/>".$row[$i]['rev_username'];
                    $email="<br/>".$row[$i]['email'];
                    $password="<br/>".$row[$i]['password'];

                    $str2="SELECT * from reviews WHERE `reviews`.`approval` = 'Y' AND `reviews`.`rev_username`= '".$row[$i]['rev_username']."' ;";
                    $res2=mysqli_query($con,$str2);
                    $approved = mysqli_num_rows($res2) ;

                    $str3="SELECT * from reviews WHERE `reviews`.`approval` = 'N' AND `reviews`.`rev_username`= '".$row[$i]['rev_username']."' ;";
                    $res3=mysqli_query($con,$str3);
                    $declined = mysqli_num_rows($res3) ;

                    $str4="SELECT * from reviews WHERE `reviews`.`rev_username`= '".$row[$i]['rev_username']."' ;";
                    $res4=mysqli_query($con,$str4);
                    $total = mysqli_num_rows($res4) ;

                    echo "<tr>";
                    echo "<td>$username </td>";
                    echo "<td>$name</td>";
                    echo "<td>$email</td>";
                    echo "<td>$password</td>";
                    echo "<td class="."rev".">$approved</td>";
                    echo "<td class="."rev".">$declined</td>";
                    echo "<td class="."rev".">$total</td>";
                    echo "<td> <a class="."Bbtt"." href="."operation.php?user=".$row[$i]['rev_username']."&com="."ban". ">  Ban  </a>  </td>";  
                    echo "</tr>";
                }



                $str="SELECT * from reviewer WHERE `reviewer`.`valid` = 'N' ;";
                $res=mysqli_query($con,$str);
                $name="";
                $username="";
                $email="";
                $password="";
                
                

                for($i=0;$i<mysqli_num_rows($res);$i++)
                {
                    $row[$i]=mysqli_fetch_array($res);
                    $name="<br/>".$row[$i]['name'];
                    $username="<br/>".$row[$i]['rev_username'];
                    $email="<br/>".$row[$i]['email'];
                    $password="<br/>".$row[$i]['password'];

                    $str2="SELECT * from reviews WHERE `reviews`.`approval` = 'Y' AND `reviews`.`rev_username`= '".$row[$i]['rev_username']."' ;";
                    $res2=mysqli_query($con,$str2);
                    $approved = mysqli_num_rows($res2) ;

                    $str3="SELECT * from reviews WHERE `reviews`.`approval` = 'N' AND `reviews`.`rev_username`= '".$row[$i]['rev_username']."' ;";
                    $res3=mysqli_query($con,$str3);
                    $declined = mysqli_num_rows($res3) ;

                    $str4="SELECT * from reviews WHERE `reviews`.`rev_username`= '".$row[$i]['rev_username']."' ;";
                    $res4=mysqli_query($con,$str4);
                    $total = mysqli_num_rows($res4) ;

                    echo "<tr>";
                    echo "<td>$username </td>";
                    echo "<td>$name</td>";
                    echo "<td>$email</td>";
                    echo "<td>$password</td>";
                    echo "<td class="."rev".">$approved</td>";
                    echo "<td class="."rev".">$declined</td>";
                    echo "<td class="."rev".">$total</td>";
                    echo "<td>  <a class="."UBbtt"." href="."operation.php?user=".$row[$i]['rev_username']."&com="."unban".">  UnBan  </a>  </td>";  
                    echo "</tr>";
                }
            }
                }
                
        }

        else if($_GET['key']=="rev")
        {
            $_SESSION['rev']=1; unset($_SESSION['reviewer']); 
            unset($_SESSION['restaurant']); 

            $con=mysqli_connect("localhost","root","","restaurant_system");
            if(!$con)
            {
                die("Connection Error : ".mysqli_connect_error() );
            }
            else
            {
                $str="SELECT * from reviews WHERE `reviews`.`approval` = 'X' ;";
                $res=mysqli_query($con,$str);
                
                if(mysqli_num_rows($res)==0)
                {
                    echo "<tr>";
                    echo "<td align="."right".">No Data Available</td>";
                    echo "</tr>";
                }
                else
                {
                    $str="SELECT * from reviews WHERE `reviews`.`approval` = 'X' ;";
                    $res=mysqli_query($con,$str);
                    $revid="";
                    $revusername="";
                    $resid="";
                    $time="";
                    $rating="";
                    $res_name="";
                    $des="";
                    
                    echo "
                    <tr>
                                <th>Review ID</th>
                                <th>Reviewer User Name</th>
                                <th>Restaurant Name</th>
                                <th>Rating</th>
                                <th>Description</th>
                                <th>Time</th>
                                <th>Operation</th>
                    </tr> " ;

                    for($i=0;$i<mysqli_num_rows($res);$i++)
                    {
                        $row[$i]=mysqli_fetch_array($res);
                        $revid="<br/>".$row[$i]['review_id'];
                        $resid=$row[$i]['res_id'];
                        $revusername="<br/>".$row[$i]['rev_username'];
                        $res_name=$row[$i]['restaurant'];
                        
                        $rating="<br/>".$row[$i]['rating'];
                        $des="<br/>".$row[$i]['review'];
                        $time="<br/>".$row[$i]['date'];
                        echo "<tr>";
                        echo "<td>$revid </td>";
                        echo "<td>$revusername</td>";
                        echo "<td>$res_name</td>";
                        echo "<td>$rating</td>";
                        echo "<td>$des</td>";
                        echo "<td>$time</td>";
                        echo "<td>  <a class="."UBbtt"." href="."operation.php?id=".$row[$i]['review_id']."&com="."acc"."&rate=".$row[$i]['rating']."&restaurant=".$resid.">  Accept  </a> &nbsp&nbsp&nbsp  <a class="."Bbtt"." href="."operation.php?id=".$row[$i]['review_id']."&com="."del".">  Delete  </a>       </td>";  
                        echo "</tr>";
                    }
                }
            }
        }

        else if($_GET['key']=="restaurant")
        {
            $_SESSION['restaurant']=1; unset($_SESSION['reviewer']); 
            unset($_SESSION['rev']); 


            $con=mysqli_connect("localhost","root","","restaurant_system");
            if(!$con)
            {
                die("Connection Error : ".mysqli_connect_error() );
            }
            else
            {
                $str="SELECT * from restaurants;";
                $res=mysqli_query($con,$str);
                
                if(mysqli_num_rows($res)==0)
                {
                    echo "<tr>";
                    echo "<td>No Data Available</td>";
                }
                else
                {
                    $str="SELECT * from restaurants WHERE `restaurants`.`valid` = 'Y' ;";
                    $res=mysqli_query($con,$str);
                    $resid="";
                    $resname="";
                    $cuisine="";
                    $posrev="";
                    $negrev="";
                    $avgrev="";
                    echo "
                    <tr>
                                <th>Restaurant ID</th>
                                <th>Restaurant Name</th>
                                <th>Cuisine</th>
                                <th>Posotive Review</th>
                                <th>Negative Review</th>
                                <th>Average Review</th>
                                <th>Operation</th>
                    </tr> " ;

                    for($i=0;$i<mysqli_num_rows($res);$i++)
                    {
                        $row[$i]=mysqli_fetch_array($res);
                        $resid="<br/>".$row[$i]['res_id'];
                        $resname="<br/>".$row[$i]['name'];
                        $cuisine="<br/>".$row[$i]['cuisine'];

                        $p="SELECT * from reviews WHERE `reviews`.`res_id` = '".$row[$i]['res_id']."' AND `reviews`.`rating`= 'GOOD' AND `reviews`.`approval`='Y';";
                        $pres=mysqli_query($con,$p);
                        $posrev=mysqli_num_rows($pres);

                        $n="SELECT * from reviews WHERE `reviews`.`res_id` = '".$row[$i]['res_id']."' AND `reviews`.`rating`= 'BAD' AND `reviews`.`approval`='Y';";
                        $nres=mysqli_query($con,$n);
                        $negrev=mysqli_num_rows($nres);   

                        $a="SELECT * from reviews WHERE `reviews`.`res_id` = '".$row[$i]['res_id']."' AND `reviews`.`rating`= 'AVERAGE' AND `reviews`.`approval`='Y' ;";
                        $ares=mysqli_query($con,$a);
                        $avgrev=mysqli_num_rows($ares);                   

                        //$posrev="<br/>".$row[$i]['pos_rev'];
                        //$negrev="<br/>".$row[$i]['neg_rev'];
                        //$avgrev="<br/>".$row[$i]['avg_rev'];

                        echo "<tr>";
                        echo "<td>$resid </td>";
                        echo "<td>$resname</td>";
                        echo "<td>$cuisine</td>";
                        echo "<td class="."rev".">$posrev</td>";
                        echo "<td class="."rev".">$negrev</td>";
                        echo "<td class="."rev".">$avgrev</td>";
                        echo "<td> <a class="."Bbtt"." href="."operation.php?res=".$row[$i]['res_id']."&com="."ban". ">  Ban  </a>  </td>";  
                        echo "</tr>";
                    }



                    $str="SELECT * from restaurants WHERE `restaurants`.`valid` = 'N' ;";
                    $res=mysqli_query($con,$str);
                    $resid="";
                    $resname="";
                    $cuisine="";
                    $posrev="";
                    $negrev="";
                    $avgrev="";

                    for($i=0;$i<mysqli_num_rows($res);$i++)
                    {
                        $row[$i]=mysqli_fetch_array($res);
                        $resid="<br/>".$row[$i]['res_id'];
                        $resname="<br/>".$row[$i]['name'];
                        $cuisine="<br/>".$row[$i]['cuisine'];

                        $p="SELECT * from reviews WHERE `reviews`.`res_id` = '".$row[$i]['res_id']."' AND `reviews`.`rating`= 'GOOD' AND `reviews`.`approval`='Y' ;";
                        $pres=mysqli_query($con,$p);
                        $posrev=mysqli_num_rows($pres);

                        $n="SELECT * from reviews WHERE `reviews`.`res_id` = '".$row[$i]['res_id']."' AND `reviews`.`rating`= 'BAD' AND `reviews`.`approval`='Y';";
                        $nres=mysqli_query($con,$n);
                        $negrev=mysqli_num_rows($nres);   

                        $a="SELECT * from reviews WHERE `reviews`.`res_id` = '".$row[$i]['res_id']."' AND `reviews`.`rating`= 'AVERAGE' AND `reviews`.`approval`='Y';";
                        $ares=mysqli_query($con,$a);
                        $avgrev=mysqli_num_rows($ares);

                        //$posrev="<br/>".$row[$i]['pos_rev'];
                        //$negrev="<br/>".$row[$i]['neg_rev'];
                        //$avgrev="<br/>".$row[$i]['avg_rev'];

                        echo "<tr>";
                        echo "<td>$resid </td>";
                        echo "<td>$resname</td>";
                        echo "<td>$cuisine</td>";
                        echo "<td class="."rev".">$posrev</td>";
                        echo "<td class="."rev".">$negrev</td>";
                        echo "<td class="."rev".">$avgrev</td>";
                        echo "<td> <a class="."UBbtt"." href="."operation.php?res=".$row[$i]['res_id']."&com="."unban". ">  UnBan  </a>  </td>";  
                        echo "</tr>";
                    }
                }
            }

        }

    }
?>
