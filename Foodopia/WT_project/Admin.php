<?php
    session_start();
    if(!isset($_SESSION['loggedIn'])){
        //if ($_SESSION['loggedIn'] != 1) {
            //echo "lol";
            header("location:login.php");
        //}
    } 
    if (isset($_POST['logout'])) {
        session_destroy();
        header("location: login.php");
    
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_SESSION['name']; ?> - Foodopia</title>
    <script>
    	var reviewers=0;
        var restaurant=0;
        var rev=0;
    	function reviewer()
		{

    		if(reviewers==1)
    		{
        		document.getElementById('td').style.display = "none";
        		reviewers=0;
                restaurant=0;
                rev=0;
    		}
    		else
    		{
                document.getElementById("td").innerHTML="";
        		document.getElementById('td').style.display = "block";
        		reviewers=1;
                restaurant=0;
                rev=0;
    		}
		    var xhttp= new XMLHttpRequest();
		    xhttp.onreadystatechange = function()
		    {
		        if(this.readyState==4 && this.status==200)
		        {
		            document.getElementById("td").innerHTML=this.responseText;
		        }
		    };
		        xhttp.open("GET","Data.php?key=reviewers",true);
		        xhttp.send();    
		}

        function restaurants()
        {
            if(restaurant==1)
            {
                document.getElementById('td').style.display = "none";
                reviewers=0;
                restaurant=0;
                rev=0;
            }
            else
            {
                document.getElementById("td").innerHTML="";
                document.getElementById('td').style.display = "block";
                restaurant=1;
                reviewers=0;
                rev=0;
            }

            var xhttp= new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if(this.readyState==4 && this.status==200)
                {
                    document.getElementById("td").innerHTML=this.responseText;
                }
            };
                xhttp.open("GET","Data.php?key=restaurant",true);
                xhttp.send(); 
        }

        function reviews()
        {

            if(rev==1)
            {
                document.getElementById('td').style.display = "none";
                reviewers=0;
                restaurant=0;
                rev=0;
            }
            else
            {
                document.getElementById("td").innerHTML="";
                document.getElementById('td').style.display = "block";
                rev=1;
                reviewers=0;
                restaurant=0;
            }

            var xhttp= new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if(this.readyState==4 && this.status==200)
                {
                    document.getElementById("td").innerHTML=this.responseText;
                }
            };
                xhttp.open("GET","Data.php?key=rev",true);
                xhttp.send();    
        }
    </script>
</head>
<style>
    {
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

    .buttonStyle {
        width: 5%;
        color: white;
        cursor: pointer;
        font-weight: bold;
        border: 1px solid;
        text-align: center;
        border-radius: 4px;
        background: white;
        padding: 7px 10px 10px 10px;
        font-family: "Roboto Condensed";
    }

    .buttonStyle_1 {
        width: 60%;
        color: white;
        cursor: pointer;
        font-size: 20px;
        margin-top: 15px;
        margin-bottom: 15px;
        font-weight: bold;
        border: 1px solid;
        text-align: center;
        border-radius: 4px;
        background: black;
        padding: 12px 18px 13px;
        font-family: "Roboto Condensed";
    }

    .searchTerm {
        width: 70%;
        border: 3px solid white;
        padding: 5px;
        height: 20px;
        border-radius: 5px;
        outline: none;
        color: black;
    }

    .searchTerm:focus {
        color: #000000;
    }

    a {
        text-decoration: none;
    }

    div.buttons
    {
		width: 5%;
        color: white;
        cursor: pointer;
        font-weight: bold;
        border: 2px solid;
        text-align: center;
        border-radius: 5px;
        background: white;
        padding: 7px 10px 10px 10px;
        font-family: "Roboto Condensed";
    }

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}
td.rev {
    text-align: center;
    padding: 8px;
}

tr:nth-child(even){background-color: #c4c6c6}

th {
    background-color: #000000;
    color: white;
}


    @import "https://fonts.googleapis.com/css?family=Source+Sans+Pro:700";
*,
*::before,
*::after {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

html, body {
  height: 100%;
  width: 100%;
}

body {
  padding: 0px;
  margin: 0;
  font-family: "Source Sans Pro", sans-serif;
  background: #F5F0FF;
  -webkit-font-smoothing: antialiased;
}

.dark {
  background: #24252A;
}

.flex {
  min-height: 15vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

a.bttn {

    cursor: pointer;
  color: #3d29a0;
  text-decoration: none;
  -webkit-transition: 0.3s all ease;
  transition: 0.3s ease all;
}
a.bttn:hover {
  color: #FFF;
}
a.bttn:focus {
  color: #FFF;
}

.bttn {
  font-size: 15px;
  letter-spacing: 1px;
  text-transform: uppercase;
  text-align: center;
  width: 150px;
  font-weight: bold;
  padding: 10px 0px;
  border: 2px solid #3d29a0;
  border-radius: 6px;
  position: relative;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.1);
}
.bttn:before {
  -webkit-transition: 0.5s all ease;
  transition: 0.5s all ease;
  position: absolute;
  top: 0;
  left: 50%;
  right: 50%;
  bottom: 0;
  opacity: 0;
  content: '';
  background-color: #3d29a0;
  z-index: -2;
}
.bttn:hover:before {
  -webkit-transition: 0.5s all ease;
  transition: 0.5s all ease;
  left: 0;
  right: 0;
  opacity: 1;
}
.bttn:focus:before {
  transition: 0.5s all ease;
  left: 0;
  right: 0;
  opacity: 1;
}
.Bbtt {
    display: block;
    width: 80px;
    height: 35px;
    background: #ef0e0e;
    padding: 7px;
    text-align: center;
    border-radius: 50px;
    color: white;
    font-weight: bold;
}
.UBbtt {
    display: block;
    width: 80px;
    height: 35px;
    background: #119b13;
    padding: 7px;
    text-align: center;
    border-radius: 50px;
    color: white;
    font-weight: bold;
}

</style>

<body>
    <div class="header">
        <a href="#default" class="logo">FOODOPIA</a>
        <div class="header-right">
            <a href="validate.php?q=logout">LOG OUT</a>
        </div>
    </div>

	
		
    <div class="flex" >
    	<a value="Reviewer" id="reviewer" onclick="reviewer()" class="bttn">Reviewer</a>
        &nbsp; &nbsp;
        <a value="Restaurants" id="res" onclick="restaurants()" class="bttn">Restaurants</a>
        &nbsp; &nbsp;
        <a value="Reviews" id="rev" onclick="reviews()" class="bttn">Reviews</a>
    </div>
    
    <div style='margin-left: 200px; margin-right: 100px;' align="center">
        <table border="0" align="center" id="td"  style="display:none;" >
              
        </table>
    </div>
    
	<?php
	if(isset($_SESSION['reviewer']))
    {
    	echo "<script> reviewer(); </script>";
    }
    else if(isset($_SESSION['rev']))
    {
        echo "<script> reviews(); </script>";
    }
    else if(isset($_SESSION['restaurant']))
    {
        echo "<script> restaurants(); </script>";   
    }
	?>
    

</body>

</html>


