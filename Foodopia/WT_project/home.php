<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Foodopia</title>
    <div class="header">
        <a href="#default" class="logo">FOODOPIA</a>
        <div class="header-right">
           <a href="login.php">SIGN IN</a>
            <a href="opt_reg.php">SIGN UP</a>';
        </div>
    </div>

</head>

<style type="text/css">
    body {
        background-image: url("upload/home.jpg");
        background-size: 1024px 768px;
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
        
    #search {
        margin-left: 450;
        top: -150px;
        position: relative;
    }

    #BOARD {
        margin-left: 450;
        margin-top: -170;
        height: 100%;
        width: 50%;
    }

    .buttonStyle {
        width: 15%%;
        height: 8%;
        color: white;
        cursor: pointer;
        font-size: 20px;
        margin-top: -10px;
        margin-bottom: 20px;
        font-weight: bold;
        border: 1px solid;
        text-align: center;
        border-radius: 4px;
        padding: 12px 18px 13px;
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

</script>

<body>
    <br><br><br>
    <div>
        <input type="text" size="50" maxlength="80" style='margin-left: 550px; margin-right: 200px; margin-top: 200px; font-family: Roboto Condensed; line-height: 30px;' placeholder="Search" onkeyup="getsearch(this.value)" />
    </div>
     <table border="0" style="margin-top: 7px; position: fixed; z-index: 0;"  width="100%" align="center" border="0">
        <tr>   
            <td width="115">
            </td>
            <td colspan="1" align="left">
                <div  id="search-result-container" style="background-color: white; border: 1px solid; margin-left: 427px; display:none; width: 322px;  z-index: 2;">
                </div>
            </td>
        </tr>
    </table>
</body>
</html>