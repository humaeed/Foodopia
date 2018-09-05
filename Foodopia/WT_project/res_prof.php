<?php
    session_start();
    if (isset($_SESSION['loggedIn'])) {
       if ($_SESSION['loggedIn'] != 2) {
            header("location: login.php");
        }
    } else {
        header("location: login.php");
    }

    if (!isset($_SESSION['RSproblem'])) {
        $_SESSION['RSproblem'] = "nope";
    }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php echo $_SESSION['name']." | Foodopia"?>
    </title>
    <div class="header">
        <input type="text" size="50" maxlength="80" style='margin-left: 28px; margin-top: 6px; font-family: Roboto Condensed; line-height: 30px;' placeholder="Search" onkeyup="getsearch(this.value)" />
        <a href="#default" class="logo">FOODOPIA</a>
        <div class="header-right">
            <a href="#home">HOME</a>
            <a href="res_prof.php">PAGE</a>
            <a href="validate.php?q=logout">LOG OUT</a>
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


    function validatePassword() {
        var password = document.getElementById("password")
        var confirm_password = document.getElementById("rpassword");
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        }
        else {
            confirm_password.setCustomValidity('');
        }
    }

    function preview(event) { // Picture preview before upload
        var reader = new FileReader();
        var imageField = document.getElementById("IMG");
        reader.onload = function() {
            if (reader.readyState == 2) {
                imageField.src = reader.result;
            }
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    function validateCuisine() { //cuisine// only char
        var ok = 0;
        var x = document.getElementById("c").value;
        for (var i = 0; i < x.length; i++){
            if(x[i]>='0'&&x[i]<='9'){
                ok=1;
                alert("Can't contain numeric value");
                break;
            }
        }
        if(ok)document.getElementById("c").value="";
    }


    function validatePrice() //road //only number
    {
        var ok=0;
        var dot=0;
        var x = document.getElementById("price").value;
        for(var i=0;i<x.length;i++){
            if(x[i]=='.' && dot == 0) dot=1;
            else if(x[i]>='0'&&x[i]<='9'){
              continue;
            }
            else{
                ok=1;
                alert("Price must be numeric");
                break;
            }
        }
        if(ok)document.getElementById("price").value="";
    }
    function validateName() //cuisine// only char
    {
        var ok=0;
        var x = document.getElementById("n").value;
        for(var i=0;i<x.length;i++){
            if(x[i]>='0'&&x[i]<='9'){
                ok=1;
                alert("Can't contain numeric value");
                break;
            }
        }
        if(ok)document.getElementById("n").value="";
    }

    function validateRoad() //road //only number
    {
        var ok=0;
        var x = document.getElementById("road").value;
        for(var i=0;i<x.length;i++){
            if(x[i]>='0'&&x[i]<='9'){
              continue;
            }
            else{
                ok=1;
                alert("Road must be numeric");
                break;
            }
        }
        if(ok)document.getElementById("road").value="";
    }

    function validateHouse() //road //only number and char
    {
        var ok=0;
        var x = document.getElementById("house").value;
        for(var i=0;i<x.length;i++){
            if(x[i]>='0'&&x[i]<='9' || x[i]>='a'&&x[i]<='z' || x[i]>='A'&&x[i]<='Z' || x[i] == ' ' || x[i] == ','){
              continue;
            }
            else{
                ok=1;
                alert("House must be numeric");
                break;
            }
        }
        if(ok)document.getElementById("house").value="";
    }

    function validatePhone() //phone //only number
    {
        var ok=0;
        var x = document.getElementById("phone").value;
        for(var i=0;i<x.length;i++){
            if(x[i]>='0'&&x[i]<='9'){
              continue;
            }
            else{
                ok=1;
                alert("Phone Number must be numeric");
                break;
            }
        }
        if(ok)document.getElementById("phone").value="";
    }

    function checkAC() {
        var CITY = document.getElementById("city");
        var AREA = document.getElementById("area");
        //
        if (document.getElementById("city").value == "nocity") {
            CITY.setCustomValidity("Select a city");
        } else {
            CITY.setCustomValidity('');
        }
        //
        if (document.getElementById("area").value == "noarea") {
            AREA.setCustomValidity("Select an area");
        } else {
            AREA.setCustomValidity('');
        }
    }

    function addItem() {
        var dhaka  = ["Banani", "Gulshan", "Dhanmondi", "Mohakhali", "Mirpur"];
        var ctg    = ["Boalkhali", "Fatikchhari", "Hathazari", "Lohagara", "Mirsharai"];
        var raj    = ["Durgapur", "Godagari", "Putia", "Kazla", "Tanor"];
        var khulna = ["BIT Khulna", "Doulatpur", "Khulna sadar", "Siramani"];
        var sylhet = ["Kadamtali", "Mogla", "Jalalabad", "Lalbazar"];
        var name   = document.getElementById("city").value;

        if (name == "Dhaka") {
            var x = document.getElementById("area");
            for (var item in x) {
                x.remove(item);
            }
            var it = document.createElement("option");
            it.text = "Select Area:"; it.value = "noarea";
            document.getElementById("area").appendChild(it);
            for (var i = 0; i < dhaka.length; i++) {
                var item   = document.createElement("option");
                item.value = item.text = dhaka[i];
                document.getElementById("area").appendChild(item);
            }

        } else if (name == "Rajshahi") {
            var x = document.getElementById("area");
            for (var item in x) {
                x.remove(item);
            }
            var it = document.createElement("option");
            it.text = "Select Area:"; it.value = "noarea";
            document.getElementById("area").appendChild(it);
            for (var i = 0; i < raj.length; i++) {
                var item = document.createElement("option");
                item.value = item.text = raj[i];
                document.getElementById("area").appendChild(item);
            }
        } else if (name == "Chittagong") {
            var x = document.getElementById("area");
            for (var item in x) {
                x.remove(item);
            }
            var it = document.createElement("option");
            it.text = "Select Area:"; it.value = "noarea";
            document.getElementById("area").appendChild(it);
            for (var i = 0; i < ctg.length; i++) {
                var item = document.createElement("option");
                item.value = item.text = ctg[i];
                document.getElementById("area").appendChild(item);
            }
        } else if (name == "Khulna") {
            var x = document.getElementById("area");
            for (var item in x) {
                x.remove(item);
            }
            var it = document.createElement("option");
            it.text = "Select Area:"; it.value = "noarea";
            document.getElementById("area").appendChild(it);
            for (var i = 0; i < khulna.length; i++) {
                var item = document.createElement("option");
                item.value = item.text = khulna[i];
                document.getElementById("area").appendChild(item);
            }
        } else if (name == "Sylhet") {
            var x = document.getElementById("area");
            for (var item in x) {
                x.remove(item);
            }
            var it = document.createElement("option");
            it.text = "Select Area:"; it.value = "noarea";
            document.getElementById("area").appendChild(it);
            for (var i = 0; i < sylhet.length; i++) {
                var item = document.createElement("option");
                item.value = item.text = sylhet[i];
                document.getElementById("area").appendChild(item);
            }
        } else {
            var x = document.getElementById("area");
            for (var item in x) {
                x.remove(item);
            }
            var it = document.createElement("option");
            it.text = "Select Area:"; it.value = "noarea";
            document.getElementById("area").appendChild(it);
        }
    }

    function LOAD_AC() {
         LOAD_BUTTON();ADD_RATING();

        var dhaka  = ["Banani", "Gulshan", "Dhanmondi", "Mohakhali", "Mirpur"];
        var ctg    = ["Boalkhali", "Fatikchhari", "Hathazari", "Lohagara", "Mirsharai"];
        var raj    = ["Durgapur", "Godagari", "Putia", "Kazla", "Tanor"];
        var khulna = ["BIT Khulna", "Doulatpur", "Khulna sadar", "Siramani"];
        var sylhet = ["Kadamtali", "Mogla", "Jalalabad", "Lalbazar"];

        var city   = <?php echo json_encode($_SESSION['city']); ?>;
        var area   = <?php echo json_encode($_SESSION['area']); ?>;

        if (city == "Dhaka") {
            document.getElementById('city').getElementsByTagName('option')[1].selected = 'selected';
            for (var i = 0; i < dhaka.length; i++) {
                var item   = document.createElement("option");
                item.value = item.text = dhaka[i];
                document.getElementById("area").appendChild(item);
                if (dhaka[i] == area) {
                    document.getElementById('area').getElementsByTagName('option')[i + 1].selected = 'selected';
                }
            }
        } else if (city == "Chittagong") {
            document.getElementById('city').getElementsByTagName('option')[2].selected = 'selected';
            for (var i = 0; i < ctg.length; i++) {
                var item   = document.createElement("option");
                item.value = item.text = ctg[i];
                document.getElementById("area").appendChild(item);
                if (ctg[i] == area) {
                    document.getElementById('area').getElementsByTagName('option')[i + 1].selected = 'selected';
                }
            }
        } else if (city == "Rajshahi") {
            document.getElementById('city').getElementsByTagName('option')[3].selected = 'selected';
            for (var i = 0; i < raj.length; i++) {
                var item   = document.createElement("option");
                item.value = item.text = raj[i];
                document.getElementById("area").appendChild(item);
                if (raj[i] == area) {
                    document.getElementById('area').getElementsByTagName('option')[i + 1].selected = 'selected';
                }
            }
        } else if (city == "Khulna") {
            document.getElementById('city').getElementsByTagName('option')[4].selected = 'selected';
            for (var i = 0; i < khulna.length; i++) {
                var item   = document.createElement("option");
                item.value = item.text = khulna[i];
                document.getElementById("area").appendChild(item);
                if (khulna[i] == area) {
                    document.getElementById('area').getElementsByTagName('option')[i + 1].selected = 'selected';
                }
            }
        } else if (city == "Sylhet") {
            document.getElementById('city').getElementsByTagName('option')[5].selected = 'selected';
            for (var i = 0; i < sylhet.length; i++) {
                var item   = document.createElement("option");
                item.value = item.text = sylhet[i];
                document.getElementById("area").appendChild(item);
                if (sylhet[i] == area) {
                    document.getElementById('area').getElementsByTagName('option')[i + 1].selected = 'selected';
                }
            }
        }
    }

    function CHECK_FP() {
        if (document.getElementById('food').value != "" && document.getElementById('price').value != "") {
            document.getElementById('food').setCustomValidity('');
            document.getElementById('price').setCustomValidity('');
        } else {
            if (document.getElementById('food').value == "") {
                 document.getElementById('food').setCustomValidity("Enter a food name");
            } else {
                document.getElementById('price').setCustomValidity("Enter a food price");
            }
        }
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
        var id = <?php echo json_encode($_SESSION['res_id']); ?>;
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
</script>

<body onload="LOAD_AC()">
    <br>
    <div class="PPic">
        <img src="<?php echo $_SESSION['pic']; ?>" height="200" width="200">
    </div>
    <div class="PInfo">
        <h1>
            <?php echo $_SESSION['name']; ?> &nbsp;
            <label style="font-size: 20px;">(<?php echo $_SESSION['review_count']." Reviews";?>)</label>
        </h1>
        <h4 style="margin-top: -20;"><?php echo $_SESSION['area'].", ".$_SESSION['city'] ?></h4>
        <h2 style="margin-top: -10;"><a style="border: 3px solid; color: black" class="aC" href="res_prof.php">&nbsp;PROFILE&nbsp;</a>&nbsp;&nbsp;<a style="border: 3px solid; color: black" class="aC" href="res_prof.php?q=rs_edit">&nbsp;EDIT&nbsp;</a>&nbsp;&nbsp;<a style="border: 3px solid; color: black" class="aC" href="res_prof.php">&nbsp;REVIEWS&nbsp;</a>&nbsp;&nbsp;<a style="border: 3px solid; color: black" class="aC" href="res_prof.php#2">&nbsp;INFO&nbsp;</a></h2>
    </div>
    <hr style="margin-top: 100px; margin-left: 150px; margin-right: 150px;">
    <div id="HERE">
        <br><br>
        <?php
        echo "<div class='form'>";
        if (isset($_REQUEST['q'])) {
            if ($_REQUEST['q'] == "rs_edit") {
                echo "<table align='center' border='0'>";
                    echo "<tr>"; //res info
                        echo "<td>";
                            echo "<table>";
                                echo "<tr>";
                                    echo "<td>";
                                        echo "<form method='POST'  enctype='multipart/form-data' action='validate.php'>";
                                        echo "<fieldset>";
                                        echo "<legend><strong><font size='4'>Restaurant Info</font></strong></legend>";
                                        echo "<table border=0 width='640' class='info_table'>";
                                            echo "<tr>
                                                <td align='center' colspan='2'>
                                                    <strong>Profile Picture</strong>
                                                    <br><br>
                                                    <img id='IMG' src='upload/res_def.png' alt='PIC' height='120' width='120'>
                                                    <br><br>
                                                    <input type='file' id='IMG_FILE' name='file' onchange='preview(event)'>
                                                    <br><br>
                                                </td>
                                            </tr>";

                                            echo "<tr>";
                                                echo "<td >";
                                                echo "<label id='name'>Restaurant Name :</label>";
                                                echo "<input type='text' name='Rname' placeholder='".$_SESSION['name']."'/>";
                                                echo "</td>";

                                                echo "<td >";
                                                echo "<label>Cuisine :</label>";
                                                echo "<input type='text' id='c' name='cuisine' placeholder='".$_SESSION['cuisine']."' onkeyup='validateCuisine()'/>";
                                                echo "</td>";
                                            echo "</tr>";


                                            echo "<tr>";
                                                echo "<td >";
                                                echo "<label>Manager Name :</label>";
                                                echo "<input type='text' id='n' name='Mname' placeholder='".$_SESSION['manager_name']."' onkeyup='validateName()'/>";
                                                echo "</td>";

                                                echo "<td >";
                                                echo "<label>Email :</label>";
                                                echo "<input type='email' name='email' placeholder='".$_SESSION['email']."' />";
                                                echo "</td>";
                                            echo "</tr>";
                                            echo "<tr>
                                                    <td>
                                                        <label>Change Password :</label>
                                                        <input type='password' onchange='validatePassword()' id='password' placeholder='●●●●●●●●' name='password' minlength='8' size='25'>
                                                    </td>
                                                    <td>
                                                        <label>Confirm Password :</label>
                                                        <input type='password' onkeyup='validatePassword()' id='rpassword' placeholder='●●●●●●●●' name='rpassword' size='25' type='text'>
                                                    </td>
                                                </tr>";
                                            echo "<tr>";
                                                echo "<td >";
                                                echo "<label id='name'>Phone Number :</label><br>";
                                                echo "<input type='text' maxlength=11 name='phone' id='phone' onkeyup='validatePhone()' placeholder='".$_SESSION['phone']."'/>";
                                                echo "</td>";
                                            echo "</tr>";
                                            echo "<tr>";

                                                echo "<td align='center' colspan='2'><br><input class=shitButton type='submit' name='RS_INFO_EDIT' value='Save'/></td>";
                                            echo "</tr>";
                                        echo "</table>";
                                        echo "</fieldset>";
                                        echo "</form>";
                                    echo "</td>";
                                echo "</tr>";

                                //Location Info
                                echo "<tr>";
                                    echo "<td><br><br>";
                                    echo "<form method='post' action='validate.php' >";
                                        echo "<fieldset>";
                                        echo "<legend><strong><font size='4'>Location Info</font></strong></legend>";
                                        echo "<table border='0' width='640' class='info_table'>";
                                                echo "<tr>";
                                                    echo "<td>";
                                                    echo "<label>Road :</label><br>"; //road
                                                    echo "<input type='text' id='road' name='road' onkeyup='validateRoad()' value='".$_SESSION['road']."' />";
                                                    echo "</td>";

                                                    echo "<td width='300'>";
                                                    echo "<label>Area :</label><br>"; //area
                                                    echo "<select name='area' id='area' onchange='checkAC()' required=''>
                                                            <option value='noarea'>Select Area:</option>
                                                        </select>";
                                                    echo "</td>";
                                                echo "</tr>";

                                                echo "<tr>";
                                                    echo "<td>";
                                                    echo "<label>House :</label><br>"; //house
                                                    echo "<input type='text' id='house' name='house' onkeyup='validateHouse()' value='".$_SESSION['house']."' />";
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<label>City :</label><br>"; //city
                                                     echo "<select name='city' id='city' onchange='addItem(); checkAC();' required=''>
                                                            <option value='nocity'>Select City:</option>
                                                            <option value='Dhaka'>Dhaka</option>
                                                            <option value='Chittagong'>Chittagong </option>
                                                            <option value='Rajshahi'>Rajshahi </option>
                                                            <option value='Khulna'>Khulna</option>
                                                            <option value='Sylhet'>Sylhet</option>
                                                        </select>";
                                                    echo "</td>";
                                                echo "</tr>";
                                            }
                                else {
                                    //no location set
                                    echo "<tr>";
                                        echo "<td >";
                                        echo "<label>Raod :</label>"; //road
                                        echo "<input type='text' id='road' value='' onkeyup='validateRoad()'/>";
                                        echo "<label><span>*Required</span></label>";
                                        echo "</td>";

                                        echo "<td >";
                                        echo "<label>Area :</label>"; //area
                                        echo "<input type='text' id='area' value='' onkeyup='validateArea()'/>";
                                        echo "<label><span>*Required</span></label>";
                                        echo "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                        echo "<td >";
                                        echo "<label>House :</label>"; //house
                                        echo "<input type='text' id='house' value=''/>";
                                        echo "<label><span>*Required</span></label>";
                                        echo "</td>";

                                        echo "<td >";
                                        echo "<label>City :</label>"; //city
                                        echo "<input type='text' id='city' value='' onkeyup='validateCity()'/>";
                                        echo "<label><span>*Required</span></label>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "<tr>";
                                    echo "<td  colspan='2' align='center'><br><input class=shitButton type='submit' name='RSLOC_INFO_EDIT' value='Save'/></td>";
                                echo "</tr>";
                            echo "</table>";
                            echo "</fieldset>";
                            echo "</form>";
                        echo "</td>";
                    echo "</tr>";

                    //food info

                    echo "<tr>";
                        echo "<td><br><br>";
                            echo "<fieldset>";
                            echo "<legend><strong><font size='4'>Food Info</font></strong></legend>";
                            echo "<table id=FOOOD border=0 width='640' class='info_table'>";
                                echo "<tr>";
                                 echo "<form action='validate.php' method='post'>";
                                    echo "<td>";
                                    echo "<label id='name'>Food Name :</label>";
                                    echo "<input type='text' id='food' name='FoodName' onkeyup='CHECK_FP()' placeholder='eg: Chicken Burger'/>";
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<label>Price :</label>";
                                    echo "<input type='text' name='Price' id='price' onkeyup='validatePrice(); CHECK_FP();' placeholder='eg: 2.0'/>";
                                    echo "</td>";
                                echo "</tr>";
                                    echo "<td  colspan='2' align='center'><input class=shitButton type='submit' name='FOOD_ADD' value='Add'/></td>";
                                echo "</tr>";
                                   echo "</form>";

                                $con = mysqli_connect("localhost","root","","restaurant_system");
                                $str = "SELECT * FROM foods WHERE `foods`.`res_id` = '".$_SESSION['res_id']."' ;";
                                $res=mysqli_query($con,$str);

                                if (mysqli_num_rows($res) > 0) {
                                   echo "<tr>
                                        <td align='center' colspan='2'>
                                            <br>
                                            <table border=1 id='f_data' class='data'>
                                                <tr>
                                                    <th>NAME</th>
                                                    <th>PRICE</th>
                                                    <th>OPERATION</th>
                                                </tr>";

                                                for($i=0;$i<mysqli_num_rows($res);$i++)
                                                {
                                                    $row[$i]=mysqli_fetch_array($res);
                                                    echo "<tr>
                                                        <td>
                                                            ".$row[$i]['food_name']."
                                                        </td>
                                                        <td>
                                                            TK. ".$row[$i]['food_price']."
                                                        </td>
                                                        <td>
                                                            <button class='myBtn' id='".$row[$i]['food_id']."' onclick='foodRemove(this.id)'>REMOVE</button>
                                                        </td></tr>";
                                                }
                                            echo "
                                            </table>
                                        </td>
                                    </tr>";
                                }

                            echo "</table>";
                            echo "</fieldset>";
                        echo "</td>";
                    echo "</tr>";

                    // services
                    echo "<tr>";
                        echo "<td><br><br>";
                        echo "<fieldset>";
                        echo "<legend><strong><font size='4'>Service Info</font></strong></legend>";
                        echo "<table id='SERVICE' border='0' width='640' class='info_table'>";
                            echo "<tr>";
                             echo "<form method='post' action='validate.php'>";
                                echo "<td align='center'>";
                                echo "<label>Add Services :</label><br>";
                                echo "<input type='text' name='ServiceName' placeholder='Service Name' required/>";
                                echo "</td>";
                            echo "</tr>";

                            echo "<tr>";
                                echo "<td align='center' ><input class=shitButton type='submit' name=ADD_SERVICE value='Add'/></td>";
                                echo "</form>";
                            echo "</tr>";
                        if (strlen($_SESSION['services']) > 0) {
                            echo "<tr>
                                        <td align='center' colspan='2'>
                                            <br>
                                            <table border=1 id='s_data' class='data'>
                                                <tr>
                                                    <th>NAME</th>
                                                    <th>OPERATION</th>
                                                </tr>";

                            $go = explode('%', $_SESSION['services']);
                            for ($i = 0; $i < count($go); $i++) {
                                echo "<tr>
                                        <td>
                                            ".$go[$i]."
                                        </td>
                                        <td>
                                            <button class='myBtn' id='".$go[$i]."' onclick='serviceRemove(this.id)'>REMOVE</button>
                                        </td>
                                    </tr>";
                            }
                            echo "</table>";
                        }
                        echo "</fieldset>";
                        echo "</td>";
                    echo "</tr>";
                    echo "</table>";

            echo "</td>";
        echo "</tr>";
    echo "</table><br><br>";
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
                                            $str = "SELECT * FROM location WHERE `location`.`location_id` = '".$_SESSION['location_id']."' ;";
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
                                            <h2 align='center'>FOOD</h2>";

                                                $con = mysqli_connect("localhost","root","","restaurant_system");
                                                $str = "SELECT * FROM foods WHERE `foods`.`res_id` = '".$_SESSION['res_id']."' ;";
                                                $res = mysqli_query($con,$str);

                                                if (mysqli_num_rows($res) == 0) {
                                                    echo "NONE";
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
                                                    echo "</table>";
                                                }

                                            echo "
                                          </div>
                                          <div style='border: 0px solid;' class='service'>
                                            <h2 align='center'>SERVICE</h2>
                                            <h4 align='center' style='font-weight: normal;'>";

                                                if ($_SESSION['services']=='') echo 'NONE';
                                                else {
                                                    echo "<table border=0 style='margin-top: -39px;' id='f_data' class='data' height=200 width=200>
                                                    <tr>
                                                        <th>NAME</th>
                                                    </tr>";
                                                    $go = explode('%', $_SESSION['services']);
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
            var id = <?php echo json_encode($_SESSION['res_id']); ?>;
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
            var id = <?php echo json_encode($_SESSION['res_id']); ?>;
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
            var id = <?php echo json_encode($_SESSION['res_id']); ?>;
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
    <script>
        var table = document.getElementById('f_data');
        table.addEventListener('mouseenter', editTableData);
        function editTableData() {
            var v;
            for (var i = 0; i < table.rows.length; i++) {
                for (var j = 0; j < table.rows[i].cells.length - 1; j++) {
                    table.rows[i].cells[j].ondblclick = function () { //onclick
                        prop(this.innerHTML);
                        //alert(this.innerHTML);
                    };
                }
            }
        }

        function prop(str) {
            var v, flag = "food_name";
            str = str.trim();
            if (str.includes("TK.")) {
                flag = "food_price";
                str = str.substr(3);
                v = prompt('Enter food price: ', str);
            }
            else v = prompt('Enter food name: ', str);
            v = v.trim();
            if (v != null && v.length !=0) {
                edit(v, str, flag);
            }
            else return;
        }

        function edit(val, str, what) {
            var id = <?php echo json_encode($_SESSION['res_id']); ?>;
            var xhttp = new XMLHttpRequest();
            xhttp.open('GET', "validate.php?q=edit&id="+id+"&val="+val+"&org="+str+"&what=" + what, true);
            xhttp.send();
            location.reload();
        }

        var t = document.getElementById('s_data');
        t.addEventListener('mouseenter', editServices);
        function editServices()
        {
            //alert('ok');
            var v;
            for (var i = 0; i < t.rows.length; i++) {
                for (var j = 0; j < t.rows[i].cells.length-1; j++) {
                    t.rows[i].cells[j].onclick = function () { //onclick
                        propS(this.innerHTML);
                        //alert(this.innerHTML);
                    };
                }
            }
        }
        function propS(str)
        {
            str=str.trim();
            var v = prompt('Enter Services:',str);
            v=v.trim();
            if(v!=null && v.length!=0){
                editS(v,str);
            }
            else return;
        }
        function editS(val, str) {
            var id = <?php echo json_encode($_SESSION['res_id']); ?>;
            var xhttp = new XMLHttpRequest();
            xhttp.open('GET', "validate.php?q=edit_Service&id="+id+"&val="+val+"&org="+str, true);
            xhttp.send();
            location.reload();
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjeDZmz2dgDazm9AadXqbLTUoOw07H0C4"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjeDZmz2dgDazm9AadXqbLTUoOw07H0C4&callback=initMap"></script>
</body>

</html>

<?php
    if ($_SESSION['RSproblem'] != "nope") {
        // Printing a session variable into a javascript alert.
        echo '<script>
            alert("'.$_SESSION['RSproblem'].'");
        </script>';
        $_SESSION['RSproblem'] = "nope";
    }
?>