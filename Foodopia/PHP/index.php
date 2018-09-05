<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Map</title>
	<style>
		#map{
			height: 500px;
			width: 50%;
		}
	</style>
</head>
<body>
	<div >
	</div>
	<div id="map"></div>

	<script >
		var geocoder;
		var x;
		function initMap(){
			geocoder = new google.maps.Geocoder();
			codeAddress();
		}


		function codeAddress(){
			
			var address="<?php session_start();
			echo $_SESSION['address'];
		?>";
			//address='Dhaka, Bangladesh';
			//alert(address);
			//address="Banani, Bogra, Bangladesh";
			//alert(address);
			var loc=[];
			geocoder.geocode( { 'address': address}, function(results, status) {
      				if (status == 'OK') {
        				//alert(results[0].geometry.location);
        				//map.setCenter(results[0].geometry.location);

        				loc[0]=results[0].geometry.location.lat();
        				loc[1]=results[0].geometry.location.lng();
        				if(x!=1)
        				
        				//alert( loc[0] );
        				//alert( loc[1] );
        				var xhttp= new XMLHttpRequest();
            			

            			//xhttp.open("POST", "../WT_project/getData.php", true);
						//xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
						//xhttp.send("lat="+loc[0]+"&lng="+loc[1]);
            			window.location = "../WT_project/getData.php?lat="+loc[0]+"&lng="+loc[1];
      			} else {
        		alert('Geocode was not successful for the following reason: ' + status);
      			}
    				});

			}
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjeDZmz2dgDazm9AadXqbLTUoOw07H0C4&callback=initMap"></script>

	
</body>
</html>