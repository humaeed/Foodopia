<?php
    session_start();
    if (!isset($_REQUEST['RES_ID'])) {
        echo "<h1>DIE DIXXE DIE!</h1>";
        exit();
    }
    else if (isset($_SESSION['res_id']) and $_REQUEST['RES_ID'] == $_SESSION['res_id']) {
        header("location: res_prof.php");
    } else {
        $con = mysqli_connect("localhost", "root", "", "restaurant_system");
        $qry = "select * from restaurants where res_id= '".$_REQUEST['RES_ID']."';";
        $res = mysqli_query($con, $qry);
        $col = "";
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
            $_REQUEST['name']         = $row["name"];
            $_REQUEST['res_id']       = $row["res_id"];
            $_REQUEST['email']        = $row["email"];
            $_REQUEST['password']     = $row["password"];
            $_REQUEST['services']     = $row["services"];
            $_REQUEST['location_id']  = $row["location_id"];
            $_REQUEST['manager_name'] = $row["manager_name"];
            $_REQUEST['pic']          = $row["picture"];
            $_REQUEST['phone']        = $row['phone'];
            $_REQUEST['cuisine']        = $row['cuisine'];
            $_REQUEST['loggedIn']     = 2;
            $_REQUEST['success']      = "done";

            $q1 = "SELECT * FROM location WHERE location_id = '".$row['location_id']."'";
            $rs = mysqli_query($con, $q1);
            $ha = mysqli_fetch_array($rs, MYSQLI_ASSOC);
            $_REQUEST['house'] = $ha['house'];
            $_REQUEST['road']  = $ha['road'];
            $_REQUEST['city']  = $ha['city'];
            $_REQUEST['area']  = $ha['area'];
            $_REQUEST['longitude'] = $ha['longitude'];
            $_REQUEST['latitude'] = $ha['latitude'];

            $q1  = "SELECT COUNT(*) FROM reviews WHERE res_id = '".$row['res_id']."'";
            $rs  = mysqli_query($con, $q1);
            $ha  = mysqli_fetch_array($rs, MYSQLI_ASSOC);
            $_REQUEST['review_count'] = $ha['COUNT(*)'];

        } else {
            echo "<h1>DIE DIYYE DIE</h1>";
            exit();
        }
    }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php echo $_REQUEST['name']." | Foodopia"?>
    </title>
    <div class="header">
        <input type="text" size="50" maxlength="80" style='margin-left: 28px; margin-top: 6px; font-family: Roboto Condensed; line-height: 30px;' placeholder="Search" onkeyup="getsearch(this.value)" />
        <a href="#default" class="logo">FOODOPIA</a>
        <div class="header-right">
            <?php
                if (isset($_SESSION['loggedIn'])) {
                    if ($_SESSION['loggedIn'] == 1) {
                        echo '<a href="#home">HOME</a>
                              <a href="rev_prof.php">PROFILE</a>
                              <a href="validate.php?q=logout">LOG OUT</a>';
                    } else if ($_SESSION['loggedIn'] == 2) {
                        echo '<a href="#home">HOME</a>
                              <a href="res_prof.php">PAGE</a>
                              <a href="validate.php?q=logout">LOG OUT</a>';
                    } else {
                        echo '<a href="login.php">SIGN IN</a>
                              <a href="opt_reg.php">SIGN UP</a>';
                    }
                } else {
                    echo '<a href="login.php">SIGN IN</a>
                          <a href="opt_reg.php">SIGN UP</a>';
                }
            ?>
        </div>
    </div>
    <br><br>
    <table border="0" style="margin-top: 7px; position: fixed; z-index: 0;"  width="100%" align="center" border="0">
        <tr>
            <td width="115">
            </td>
            <td colspan="1" align="left">
                <div  id="search-result-container" style="background-color: white; border: 1px solid; margin-left: 150px; display:none; width: 322px;  z-index: 2;">
                </div>
            </td>
        </tr>
    </table>
</head>

<style type="text/css">
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: "Roboto Condensed";
    }

    .header {
        overflow: hidden;
        padding: 5px 20px;
        background: black;
        position: fixed;
        width: 100%;
    }

    .header a {
        float: left;
        color: black;
        color: white;
        padding: 12px;
        font-size: 18px;
        line-height: 25px;
        border-radius: 4px;
        text-align: center;
        text-decoration: none;
        font-family: "Roboto Condensed";

    }

    .header a.logo {
        font-size: 45px;
        font-weight: bold;
        font-family: "Operator Mono";
    }

    .header-right {
        float: right;
    }

    @media screen and (max-width: 500px) {
        .header a {
            float: none;
            display: block;
            text-align: left;
        }
        .header-right {
            float: none;
        }
    }

    .PPic {
        margin-left: 200;
        margin-top: 50;
    }

    .PInfo {
        width: 50%;
        margin-left: 450;
        margin-right: 450;
        margin-top: -170;
    }

    .aC {
        text-decoration: none;
    }

    .good {
        background: black;
        color: white;
        width: 200px;
        height: 200px;
        border-radius: 20px;
        margin-left: 320px;
        margin-right: 200px;
        margin-top: 40px;
        cursor: hand;
        font-family: Roboto Condensed;
    }

    .average {
        background: black;
        color: white;
        width: 200px;
        height: 200px;
        border-radius: 20px;
        margin-left: 570px;
        margin-top: -200px;
        cursor: hand;
        font-family: Roboto Condensed;
    }

    .bad {
        background: black;
        color: white;
        width: 200px;
        height: 200px;
        border-radius: 20px;
        margin-left: 820px;
        margin-top: -200px;
        cursor: hand;
        font-family: Roboto Condensed;
    }

    .map {
        border: 0px solid;
        height: 350px;
        width: 350px;
        margin-left: 100px;
    }

    .open {
        border: 0px solid;
        height: 350px;
        width: 350px;
        margin-top: -360px;
        margin-left: 500px;
    }

    .service {
        border: 0px solid;
        height: 350px;
        width: 350px;
        margin-top: -370px;
        margin-left: 900px;
    }

    .form {
        -webkit-border-radius: 10px;
        margin: 0 auto;
    }

    .form input[type="text"] {
        width: 300px;
    }

    textarea {
        border-style: solid;
        border-width: 1px;
        border-radius: 3px;
        height: 165;
        font-size: 17px;
        border-color: rgb(153, 153, 153);
        padding: 7px;
        font-family: "Roboto Condensed";
        font-size: 14px;
        -webkit-border-radius: 5px;
    }

    select {
        border-style: solid;
        border-width: 1px;
        border-radius: 3px;
        height: 38;
        width: 300;
        font-size: 50px;
        border-color: rgb(153, 153, 153);
        padding: 7px;
        font-family: "Roboto Condensed";
        font-size: 14px;
        -webkit-border-radius: 5px;

    }

    .form input[type="email"] {
        width: 300px;
    }

    .form input[type="password"] {
        width: 300px;
    }

    .form input.birthday {
        width: 85px;
    }

    .form input.birthmonth {
        width: 100px;
    }

    .form input.birthyear {
        width: 128px;
    }

    .form label {
        color: #000;
        font-size: 16px;
        font-family: "Roboto Condensed";
    }

    .form input {
        border-style: solid;
        border-width: 1px;
        border-radius: 3px;
        height: 38;
        font-size: 17px;
        border-color: rgb(153, 153, 153);
        padding: 7px;
        font-family: "Roboto Condensed";
        font-size: 14px;
        -webkit-border-radius: 5px;
    }

    .form .select-style {
        -webkit-appearance: button;
        -webkit-border-radius: 2px;
        -webkit-box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
        -webkit-padding-end: 20px;
        -webkit-padding-start: 2px;
        -webkit-user-select: none;
        background-image: url(images/select-arrow.png),
        -webkit-linear-gradient(#FAFAFA, #F4F4F4 40%, #E5E5E5);
        background-repeat: no-repeat;
        border: 0px solid #FFF;
        color: #555;
        font-size: inherit;
        margin: 0;
        overflow: hidden;
        padding-top: 5px;
        padding-bottom: 5px;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-family: "Roboto Condensed";
    }

    .form input.buttom {
        width: 15%;
        height: 8.5%;
        color: white;
        cursor: pointer;
        font-size: 20px;
        margin-top: 5px;
        margin-left: 600px;
        margin-bottom: 15px;
        font-weight: bold;
        border: 1px solid;
        border-radius: 4px;
        background: black;
        padding: 12px 18px 13px;
        font-family: "Roboto Condensed";
    }

    fieldset {
        border: 2px solid black;
        background: white;
        border-radius: 5px;
        padding: 15px;
    }

    fieldset legend {
        background: black;
        color: white;
        height: 40px;
        padding: 6.5px 50px;
        font-size: 32px;
        border-radius: 5px;
        margin-left: 10px;
    }

    .info_table{
        border-spacing:10px;
    }

    .shitButton {
        background: black;
        color: white;
        font-weight: bold;
        width: 70px;
        cursor: hand;
    }

    .data {
        border-collapse: collapse;
        width: 100%;
        cursor: pointer;
    }

    .data td {
        border: 1px solid #ddd;
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: center;
        font-size: 14px;
    }

    .data tr:nth-child(even){background-color: #f2f2f2;}

    .data tr:hover {background-color: #ddd;}

    .data th {
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: center;
        background-color: black;
        color: white;
    }

    .myBtn {
        color: white;
        cursor: pointer;
        font-size: 13px;
        border: 1px solid;
        border-radius: 4px;
        background: black;
        padding: 5px 5px 5px;
        font-family: "Roboto Condensed";
    }

</style>

<script type="text/javascript">
    function getsearch(str) {
        if (str.length == 0) {
           document.getElementById('search-result-container').style.display = "none";
        } else {
            document.getElementById('search-result-container').style.display = "block";
            var xhttp= new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("search-result-container").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET","validate.php?q=search&val=" + str, true);
            xhttp.send();
        }
    }

    function WR_CLICK() {
        var x = json_ecode($_SESSION['loggedIn']);
        //alert(x)
    }

     function foodRemove(val) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "validate.php?q=removeFood&id=" + val, true);
        xhttp.send();
        //
        location.reload();
    }


    function serviceRemove(val) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "validate.php?q=removeService&id=" + val, true);
        xhttp.send();
        //
        location.reload();
    }

    function LOAD_BUTTON()
    {
        //alert("ok");
        if(document.getElementById("good").style.display == "none"){
            document.getElementById("good").style.display = "block";
            document.getElementById("avg").style.display = "block";
            document.getElementById("bad").style.display = "block";
        }
    }
    function ADD_RATING()
    {
        var id = <?php echo json_encode($_REQUEST['res_id']); ?>;
        var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState==4 && this.status==200){
                    calculate(this.responseText);
                }
            };
        xhttp.open("GET","validate.php?q=CAL"+"&id="+id,true);
        xhttp.send();
    }
    function calculate(str)
    {
        var res = str.split("#");
        var total = res[0];
        var good = res[1];
        var bad = res[2];
        var avg = res[3];
        good = Math.round((100*good)/total);
        bad = Math.round((100*bad)/total);
        avg = Math.round((100*avg)/total);
        document.getElementById("g").innerHTML=good+"%";
        document.getElementById("b").innerHTML=bad+"%";
        document.getElementById("a").innerHTML=avg+"%";
    }

    function LOAD_AC() {
         LOAD_BUTTON();ADD_RATING();
    }

</script>

<body onload="LOAD_AC()">
    <br><br>
    <div class="PPic">
        <img src="<?php echo $_REQUEST['pic']; ?>" height="200" width="200">
    </div>
    <div class="PInfo">
        <h1>
            <?php echo $_REQUEST['name']; ?> &nbsp;
            <label style="font-size: 20px;">(<?php echo $_REQUEST['review_count']." Reviews";?>)</label>
        </h1>
        <h4 style="margin-top: -20;"><?php echo $_REQUEST['area'].", ".$_REQUEST['city'] ?></h4>
        <h2 style="margin-top: -10;"><a style="border: 3px solid; color: black" class="aC" href="res_prof2.php?RES_ID=<?php echo $_REQUEST['RES_ID'] ?>">&nbsp;REVIEWS&nbsp;</a>&nbsp;&nbsp;<a style="border: 3px solid; color: black" class="aC" href="res_prof2.php?RES_ID=<?php echo $_REQUEST['RES_ID'] ?>#2">&nbsp;INFO&nbsp;</a>&nbsp;&nbsp;<a id='WR' style="border: 3px solid; border-color: blue; color: red;" class="aC" onclick='WR_CLICK()' href="write_review.php?RES_ID=<?php echo $_REQUEST['RES_ID'] ?>&RES_NAME=<?php echo $_REQUEST['name']; ?>">&nbsp;WRITE A REVIEW&nbsp;</a></h2>
    </div>
    <?php
        if (isset($_SESSION['loggedIn']) and $_SESSION['loggedIn'] == 2) {
            echo "<script>document.getElementById('WR').style.visibility = 'hidden';</script>";
        } else if (isset($_SESSION['loggedIn']) and $_SESSION['loggedIn'] == 0) {
            echo "document.getElementById('WR').href = '#'";
        }
    ?>
    <hr style="margin-top: 100px; margin-left: 150px; margin-right: 150px;">
    <div id="HERE">
        <br><br>
        <?php
        echo "<div class='form'>";
        if (isset($_REQUEST['q'])) {
            //////
        } else {
            echo "<h1 id='1' style='margin-top: -15px; margin-bottom: -10px; text-align: center; font-size: 40px;'>REVIEWS</h1>";
            echo "
                <button class='good' id='good' onclick='addGoodReview()'> <h1>Good</h1><h3 id='g'></h3> </button>
                <button class='average' id='avg' onclick='addAvgReview()'> <h1>AVERAGE</h1><h3 id='a'></h3> </button>
                <button class='bad' id='bad' onclick='addBadReview()'> <h1>BAD</h1> <h3 id='b'></h3></button>";


            echo"<div style='margin-left: 300px; margin-right: 300px; ' id='BOARD'></div>

                                        <hr style='margin-top: 50px; margin-left: 150px; margin-right: 150px;'>
                                          <h1 id='2' style='margin-top: 30px; margin-bottom: 30px; text-align: center; font-size: 40px;'>RESTAURANT INFO</h1>
                                          <div class='map' id='map'>
                                            <h2 align='center'>MAP
                                            </h2>";

                                            $con = mysqli_connect("localhost","root","","restaurant_system");
                                            $str = "SELECT * FROM location WHERE `location`.`location_id` = '".$_REQUEST['location_id']."' ;";
                                                $res = mysqli_query($con,$str);
                                                $row=mysqli_fetch_array($res, MYSQLI_ASSOC);
                                                $lat=$row["latitude"];
                                                $lng=$row["longitude"];

                                                echo "
                                                <script>
                                                var geocoder;
                                                function initMap()
                                                {
                                                    var location={lat:$lat,lng:$lng};
                                                    var map= new google.maps.Map(document.getElementById('map'),{
                                                        zoom:15,
                                                        center:location
                                                    });
                                                    var marker = new google.maps.Marker({
                                                    position: location,
                                                    map: map
                                                    }) ;
                                                }
                                            </script>
                                            ";


                                          echo "</div>
                                          <div style='border: 0px solid;' class='open'>
                                             <h2 align='center'>FOOD</h2>
                                            <h4 align='center' style='font-weight: normal;'>";

                                                $con = mysqli_connect("localhost","root","","restaurant_system");
                                                $str = "SELECT * FROM foods WHERE `foods`.`res_id` = '".$_REQUEST['res_id']."' ;";
                                                $res = mysqli_query($con,$str);

                                                if (mysqli_num_rows($res) == 0) {
                                                    echo "<label style='text-align: center;'>NONE</label>";
                                                } else {
                                                    echo "<table border=0 id='f_data' class='data' height=200 width=200>
                                                            <tr>
                                                                <th>NAME</th>
                                                                <th>PRICE</th>
                                                            </tr>";
                                                    for ($i = 0; $i < mysqli_num_rows($res); $i++) {
                                                        $row[$i] = mysqli_fetch_array($res);
                                                        echo "<tr>
                                                            <td>
                                                                ".$row[$i]['food_name']."
                                                            </td>
                                                            <td>
                                                                TK. ".$row[$i]['food_price']."
                                                            </td>
                                                          </tr>";
                                                    }
                                                     echo "
                                                     </table>";
                                                }

                                           echo "
                                          </div>
                                          <div style='border: 0px solid;' class='service'>
                                            <h2 align='center'>SERVICE</h2>
                                            <h4 align='center' style='font-weight: normal;'>";

                                                if ($_REQUEST['services']=='') echo 'NONE';
                                                else {
                                                     echo "<table border=0 style='margin-top: -39px;' id='f_data' class='data' height=200 width=200>
                                                    <tr>
                                                        <th>NAME</th>
                                                    </tr>";
                                                    $go = explode('%', $_REQUEST['services']);
                                                    for ($i = 0; $i < count($go); $i++) {
                                                        echo "<tr>
                                                            <td>
                                                                ".$go[$i]."
                                                            </td>

                                                        </tr>";
                                                    }
                                                }
                                                echo "</h4></div><br><br>";
                                        }
                                        echo "</div>";
    ?>
    </div>
    <script>
        function addGoodReview(){
            hide();
            var id = <?php echo json_encode($_REQUEST['res_id']); ?>;
            var xhttp = new XMLHttpRequest();1
            xhttp.onreadystatechange = function(){
                if(this.readyState==4 && this.status==200){
                    document.getElementById('BOARD').innerHTML = this.responseText;

                }
            };
            xhttp.open('GET','validate.php?q=show&REV=good&id='+id,true);
            xhttp.send();
        }

        function addBadReview(){
            hide();
            var id = <?php echo json_encode($_REQUEST['res_id']); ?>;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState==4 && this.status==200){
                    document.getElementById('BOARD').innerHTML = this.responseText;

                }
            };
            xhttp.open('GET','validate.php?q=show&REV=bad&id='+id,true);
            xhttp.send();

        }
        function addAvgReview(){
            hide();
            var id = <?php echo json_encode($_REQUEST['res_id']); ?>;
            var xhttp = new XMLHttpRequest();1
            xhttp.onreadystatechange = function(){
                if(this.readyState==4 && this.status==200){
                    document.getElementById('BOARD').innerHTML = this.responseText;

                }
            };
            xhttp.open('GET','validate.php?q=show&REV=avg&id='+id,true);
            xhttp.send();
        }

        function hide()
        {
            document.getElementById("good").style.display = "none";
            document.getElementById("avg").style.display = "none";
            document.getElementById("bad").style.display = "none";

            //document.getElementById("good").style.visibility = "hidden";
            //document.getElementById("avg").style.visibility = "hidden";
            //document.getElementById("bad").style.visibility = "hidden";
        }
    </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjeDZmz2dgDazm9AadXqbLTUoOw07H0C4"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjeDZmz2dgDazm9AadXqbLTUoOw07H0C4&callback=initMap"></script>
</body>

</html>