<?php
	$latitude1 = -5.364289;
	$longitude1 = 105.243187;
	if(strtoupper($_GET['destination'])=="BANDARA") {

		$latitude2 = -5.242469;
		$longitude2 = 105.175889;

		$dataJson = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$latitude1.",".$longitude1."&destinations=".$latitude2.",".$longitude2."&key=AIzaSyBCx0yZKvuXFS6QawkRgVvmSw_xL7eDS_4");

		$data = json_decode($dataJson,true);
		$nilaiJarak = $data['rows'][0]['elements'][0]['distance']['text'];
		$durasi = $data['rows'][0]['elements'][0]['duration']['text'];
		?>
		<!DOCTYPE html>
	<html>
	<head>
		<title>Proyek GIS</title>
		<style type="text/css">
			html, body {
				margin: 0px;
				padding: 0px;
			}
			#map {
				width: 100%;
				height: 550px;
			}
			#jarak tr td {
				border:1px solid black;
				padding: 10px 0px;
				text-align: right;
				padding-left: 200px;
				padding-right: 15px;
			}
		</style>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		<h1 style="text-align: center;">Sistem Informasi Pesebaran Asal Mahasiswa Unila</h1>
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
			<a class="navbar-brand" href="index.html">Home</a>

			  <!-- Links -->
			  <ul class="navbar-nav">
			  	<li class="nav-item">
	      			<a class="nav-link" href="top3.html">TOP 3</a>
	    		</li>
			    <!-- Dropdown -->
			    <li class="nav-item dropdown">
			      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
			        Fakultas
			      </a>
			      <div class="dropdown-menu">
			        <a class="dropdown-item" href="fmipa.html">FMIPA</a>
			        <a class="dropdown-item" href="fkip.html">FKIP</a>
			        <a class="dropdown-item" href="fisip.html">FISIP</a>
			        <a class="dropdown-item" href="fp.html">FP</a>
			        <a class="dropdown-item" href="ft.html">FT</a>
			        <a class="dropdown-item" href="fh.html">FH</a>
			        <a class="dropdown-item" href="fk.html">FK</a>
			        <a class="dropdown-item" href="feb.html">FEB</a>
			      </div>
			    </li>
			    <li class="nav-item">
	      			<a class="nav-link" href="about.html">About</a>
	    		</li>
	    		<li class="nav-item">
      				<a class="nav-link" href="overlay.html">Unila</a>
    			</li>
	    		<li class="nav-item">
	      			<form method="GET" action="index.html" style="margin-top: 5px; margin-left: 20px;">
	      				<input type="text" name="search" placeholder="Search data" style="padding: 0px 10px;">
	      			</form>
	    		</li>
	    		<li class="nav-item">
	      			<form method="GET" action="jarak.php" style="margin-top: 5px; margin-left: 20px;">
	      				<select name="destination" style="padding: 0px 10px;">
	      					<option value="bandara">Bandara Raden Intan</option>
	      					<option value="stasiun">Stasiun KAI Tj. Karang</option>
	      					<option value="pelabuhan">Pelabuhan Bakauheni</option>
	      					<option value="terminal">Terminal Rajabasa</option>
	      				</select>
	      				<input type="submit" value="Kalkulasi">
	      			</form>
	    		</li>
			  </ul>
		</nav>

		<div style="margin: 20px 25%;">
			<table id="jarak">
				<tr>
					<td colspan="2" style="padding: 0px;">
						<div id="map"></div>
					</td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Origins</b></td>
					<td>Universitas Lampung</td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Destination</b></td>
					<td>Bandara Raden Intan</td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Jarak</b></td>
					<td><?= $nilaiJarak; ?></td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Waktu Tempuh</b></td>
					<td><?= $durasi; ?></td>
				</tr>
			</table>
			
		</div>
		<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCx0yZKvuXFS6QawkRgVvmSw_xL7eDS_4&callback=initMap"></script>
		<script type="text/javascript" src="direction.js"></script>
		<script type="text/javascript">

			var latUnila = -5.364289;
			var lngUnila = 105.243187;
			var latBandara = -5.242469;
			var lngBandara = 105.175889;
			var map = null;

			var center = {lat: -4.991099, lng: 105.051365}
			function initMap(){
				map = new google.maps.Map(document.getElementById('map'),{
		        	zoom:5,
		        	center:center,
		        	disableDefaultUI: true,
		        	draggable: false,
		        	maxZoom: 9,
		        	minZoom: 9,
		    	});
		    	info_window = new google.maps.InfoWindow({
		    		'Content': 'Loading...'
		    	});

		    	var markers = [['Unila', latUnila, lngUnila],['Bandara Raden Intan', latBandara, lngBandara]];

		    	var infowindow = new google.maps.InfoWindow(), marker, i;
			    var bounds = new google.maps.LatLngBounds(); // diluar looping
			    for (i = 0; i < markers.length; i++) {  
			    pos = new google.maps.LatLng(markers[i][1], markers[i][2]);
			    bounds.extend(pos); // di dalam looping
			    marker = new google.maps.Marker({
			        position: pos,
			        map: map
			    });
			    google.maps.event.addListener(marker, 'click', (function(marker, i) {
			        return function() {
			            infowindow.setContent(markers[i][0]);
			            infowindow.open(map, marker);
			        }
			    })(marker, i));
			    map.fitBounds(bounds); // setelah looping
			    }
 
			}

		</script>

		</html>

		<?php
	}else if(strtoupper($_GET['destination'])=="STASIUN"){
		$latitude2 = -5.408862;
		$longitude2 = 105.259956;

		$dataJson = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$latitude1.",".$longitude1."&destinations=".$latitude2.",".$longitude2."&key=AIzaSyBCx0yZKvuXFS6QawkRgVvmSw_xL7eDS_4");

		$data = json_decode($dataJson,true);
		$nilaiJarak = $data['rows'][0]['elements'][0]['distance']['text'];
		$durasi = $data['rows'][0]['elements'][0]['duration']['text'];
		?>
		<!DOCTYPE html>
	<html>
	<head>
		<title>Proyek GIS</title>
		<style type="text/css">
			html, body {
				margin: 0px;
				padding: 0px;
			}
			#map {
				width: 100%;
				height: 550px;
			}
			#jarak tr td {
				border:1px solid black;
				padding: 10px 0px;
				text-align: right;
				padding-left: 200px;
				padding-right: 15px;
			}
		</style>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		<h1 style="text-align: center;">Sistem Informasi Pesebaran Asal Mahasiswa Unila</h1>
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
			<a class="navbar-brand" href="index.html">Home</a>

			  <!-- Links -->
			  <ul class="navbar-nav">
			  	<li class="nav-item">
	      			<a class="nav-link" href="top3.html">TOP 3</a>
	    		</li>
			    <!-- Dropdown -->
			    <li class="nav-item dropdown">
			      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
			        Fakultas
			      </a>
			      <div class="dropdown-menu">
			        <a class="dropdown-item" href="fmipa.html">FMIPA</a>
			        <a class="dropdown-item" href="fkip.html">FKIP</a>
			        <a class="dropdown-item" href="fisip.html">FISIP</a>
			        <a class="dropdown-item" href="fp.html">FP</a>
			        <a class="dropdown-item" href="ft.html">FT</a>
			        <a class="dropdown-item" href="fh.html">FH</a>
			        <a class="dropdown-item" href="fk.html">FK</a>
			        <a class="dropdown-item" href="feb.html">FEB</a>
			      </div>
			    </li>
			    <li class="nav-item">
	      			<a class="nav-link" href="about.html">About</a>
	    		</li>
	    		<li class="nav-item">
      				<a class="nav-link" href="overlay.html">Unila</a>
    			</li>
	    		<li class="nav-item">
	      			<form method="GET" action="index.html" style="margin-top: 5px; margin-left: 20px;">
	      				<input type="text" name="search" placeholder="Search data" style="padding: 0px 10px;">
	      			</form>
	    		</li>
	    		<li class="nav-item">
	      			<form method="GET" action="jarak.php" style="margin-top: 5px; margin-left: 20px;">
	      				<select name="destination" style="padding: 0px 10px;">
	      					<option value="bandara">Bandara Raden Intan</option>
	      					<option value="stasiun">Stasiun KAI Tj. Karang</option>
	      					<option value="pelabuhan">Pelabuhan Bakauheni</option>
	      					<option value="terminal">Terminal Rajabasa</option>
	      				</select>
	      				<input type="submit" value="Kalkulasi">
	      			</form>
	    		</li>
			  </ul>
		</nav>

		<div style="margin: 20px 25%;">
			<table id="jarak">
				<tr>
					<td colspan="2" style="padding: 0px;">
						<div id="map"></div>
					</td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Origins</b></td>
					<td>Universitas Lampung</td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Destination</b></td>
					<td style="padding-left: 180px;">Stasiun K.A.I. Tanjung Karang</td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Jarak</b></td>
					<td><?= $nilaiJarak; ?></td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Waktu Tempuh</b></td>
					<td><?= $durasi; ?></td>
				</tr>
			</table>
			
		</div>
		<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCx0yZKvuXFS6QawkRgVvmSw_xL7eDS_4&callback=initMap"></script>
		<script type="text/javascript" src="direction.js"></script>
		<script type="text/javascript">

			var latUnila = -5.364289;
			var lngUnila = 105.243187;
			var latStasiun = -5.408862;
			var lngStasiun = 105.259956;
			var map = null;

			var center = {lat: -4.991099, lng: 105.051365}
			function initMap(){
				map = new google.maps.Map(document.getElementById('map'),{
		        	zoom:5,
		        	center:center,
		        	disableDefaultUI: true,
		        	draggable: false,
		        	maxZoom: 9,
		        	minZoom: 9,
		    	});
		    	info_window = new google.maps.InfoWindow({
		    		'Content': 'Loading...'
		    	});

		    	var markers = [['Unila', latUnila, lngUnila],['Stasiun K.A.I. Tj. Karang', latStasiun, lngStasiun]];

		    	var infowindow = new google.maps.InfoWindow(), marker, i;
			    var bounds = new google.maps.LatLngBounds(); // diluar looping
			    for (i = 0; i < markers.length; i++) {  
			    pos = new google.maps.LatLng(markers[i][1], markers[i][2]);
			    bounds.extend(pos); // di dalam looping
			    marker = new google.maps.Marker({
			        position: pos,
			        map: map
			    });
			    google.maps.event.addListener(marker, 'click', (function(marker, i) {
			        return function() {
			            infowindow.setContent(markers[i][0]);
			            infowindow.open(map, marker);
			        }
			    })(marker, i));
			    map.fitBounds(bounds); // setelah looping
			    }
 
			}

		</script>

		</html>

		<?php
	}else if(strtoupper($_GET['destination'])=="PELABUHAN"){
		$latitude2 = -5.870155;
		$longitude2 = 105.754309;

		$dataJson = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$latitude1.",".$longitude1."&destinations=".$latitude2.",".$longitude2."&key=AIzaSyBCx0yZKvuXFS6QawkRgVvmSw_xL7eDS_4");

		$data = json_decode($dataJson,true);
		$nilaiJarak = $data['rows'][0]['elements'][0]['distance']['text'];
		$durasi = $data['rows'][0]['elements'][0]['duration']['text'];
		?>
		<!DOCTYPE html>
	<html>
	<head>
		<title>Proyek GIS</title>
		<style type="text/css">
			html, body {
				margin: 0px;
				padding: 0px;
			}
			#map {
				width: 100%;
				height: 550px;
			}
			#jarak tr td {
				border:1px solid black;
				padding: 10px 0px;
				text-align: right;
				padding-left: 200px;
				padding-right: 15px;
			}
		</style>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		<h1 style="text-align: center;">Sistem Informasi Pesebaran Asal Mahasiswa Unila</h1>
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
			<a class="navbar-brand" href="index.html">Home</a>

			  <!-- Links -->
			  <ul class="navbar-nav">
			  	<li class="nav-item">
	      			<a class="nav-link" href="top3.html">TOP 3</a>
	    		</li>
			    <!-- Dropdown -->
			    <li class="nav-item dropdown">
			      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
			        Fakultas
			      </a>
			      <div class="dropdown-menu">
			        <a class="dropdown-item" href="fmipa.html">FMIPA</a>
			        <a class="dropdown-item" href="fkip.html">FKIP</a>
			        <a class="dropdown-item" href="fisip.html">FISIP</a>
			        <a class="dropdown-item" href="fp.html">FP</a>
			        <a class="dropdown-item" href="ft.html">FT</a>
			        <a class="dropdown-item" href="fh.html">FH</a>
			        <a class="dropdown-item" href="fk.html">FK</a>
			        <a class="dropdown-item" href="feb.html">FEB</a>
			      </div>
			    </li>
			    <li class="nav-item">
	      			<a class="nav-link" href="about.html">About</a>
	    		</li>
	    		<li class="nav-item">
      				<a class="nav-link" href="overlay.html">Unila</a>
    			</li>
	    		<li class="nav-item">
	      			<form method="GET" action="index.html" style="margin-top: 5px; margin-left: 20px;">
	      				<input type="text" name="search" placeholder="Search data" style="padding: 0px 10px;">
	      			</form>
	    		</li>
	    		<li class="nav-item">
	      			<form method="GET" action="jarak.php" style="margin-top: 5px; margin-left: 20px;">
	      				<select name="destination" style="padding: 0px 10px;">
	      					<option value="bandara">Bandara Raden Intan</option>
	      					<option value="stasiun">Stasiun KAI Tj. Karang</option>
	      					<option value="pelabuhan">Pelabuhan Bakauheni</option>
	      					<option value="terminal">Terminal Rajabasa</option>
	      				</select>
	      				<input type="submit" value="Kalkulasi">
	      			</form>
	    		</li>
			  </ul>
		</nav>

		<div style="margin: 20px 25%;">
			<table id="jarak">
				<tr>
					<td colspan="2" style="padding: 0px;">
						<div id="map"></div>
					</td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Origins</b></td>
					<td>Universitas Lampung</td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Destination</b></td>
					<td>Pelabuhan Bakauheni</td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Jarak</b></td>
					<td><?= $nilaiJarak; ?></td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Waktu Tempuh</b></td>
					<td><?= $durasi; ?></td>
				</tr>
			</table>
			
		</div>
		<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCx0yZKvuXFS6QawkRgVvmSw_xL7eDS_4&callback=initMap"></script>
		<script type="text/javascript" src="direction.js"></script>
		<script type="text/javascript">

			var latUnila = -5.364289;
			var lngUnila = 105.243187;
			var latPel = -5.870155;
			var lngPel = 105.754309;
			var map = null;

			var center = {lat: -4.991099, lng: 105.051365}
			function initMap(){
				map = new google.maps.Map(document.getElementById('map'),{
		        	zoom:5,
		        	center:center,
		        	disableDefaultUI: true,
		        	draggable: false,
		        	maxZoom: 8,
		        	minZoom: 8,
		    	});
		    	info_window = new google.maps.InfoWindow({
		    		'Content': 'Loading...'
		    	});

		    	var markers = [['Unila', latUnila, lngUnila],['Pelabuhan Bakauheni', latPel, lngPel]];

		    	var infowindow = new google.maps.InfoWindow(), marker, i;
			    var bounds = new google.maps.LatLngBounds(); // diluar looping
			    for (i = 0; i < markers.length; i++) {  
			    pos = new google.maps.LatLng(markers[i][1], markers[i][2]);
			    bounds.extend(pos); // di dalam looping
			    marker = new google.maps.Marker({
			        position: pos,
			        map: map
			    });
			    google.maps.event.addListener(marker, 'click', (function(marker, i) {
			        return function() {
			            infowindow.setContent(markers[i][0]);
			            infowindow.open(map, marker);
			        }
			    })(marker, i));
			    map.fitBounds(bounds); // setelah looping
			    }
 
			}

		</script>

		</html>

		<?php
	}else if(strtoupper($_GET['destination'])=="TERMINAL"){
		$latitude2 = -5.368241;
		$longitude2 = 105.237018;

		$dataJson = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$latitude1.",".$longitude1."&destinations=".$latitude2.",".$longitude2."&key=AIzaSyBCx0yZKvuXFS6QawkRgVvmSw_xL7eDS_4");

		$data = json_decode($dataJson,true);
		$nilaiJarak = $data['rows'][0]['elements'][0]['distance']['text'];
		$durasi = $data['rows'][0]['elements'][0]['duration']['text'];

		?>
		<!DOCTYPE html>
	<html>
	<head>
		<title>Proyek GIS</title>
		<style type="text/css">
			html, body {
				margin: 0px;
				padding: 0px;
			}
			#map {
				width: 100%;
				height: 550px;
			}
			#jarak tr td {
				border:1px solid black;
				padding: 10px 0px;
				text-align: right;
				padding-left: 200px;
				padding-right: 15px;
			}
		</style>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		<h1 style="text-align: center;">Sistem Informasi Pesebaran Asal Mahasiswa Unila</h1>
		<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
			<a class="navbar-brand" href="index.html">Home</a>

			  <!-- Links -->
			  <ul class="navbar-nav">
			  	<li class="nav-item">
	      			<a class="nav-link" href="top3.html">TOP 3</a>
	    		</li>
			    <!-- Dropdown -->
			    <li class="nav-item dropdown">
			      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
			        Fakultas
			      </a>
			      <div class="dropdown-menu">
			        <a class="dropdown-item" href="fmipa.html">FMIPA</a>
			        <a class="dropdown-item" href="fkip.html">FKIP</a>
			        <a class="dropdown-item" href="fisip.html">FISIP</a>
			        <a class="dropdown-item" href="fp.html">FP</a>
			        <a class="dropdown-item" href="ft.html">FT</a>
			        <a class="dropdown-item" href="fh.html">FH</a>
			        <a class="dropdown-item" href="fk.html">FK</a>
			        <a class="dropdown-item" href="feb.html">FEB</a>
			      </div>
			    </li>
			    <li class="nav-item">
	      			<a class="nav-link" href="about.html">About</a>
	    		</li>
	    		<li class="nav-item">
      				<a class="nav-link" href="overlay.html">Unila</a>
    			</li>
	    		<li class="nav-item">
	      			<form method="GET" action="index.html" style="margin-top: 5px; margin-left: 20px;">
	      				<input type="text" name="search" placeholder="Search data" style="padding: 0px 10px;">
	      			</form>
	    		</li>
	    		<li class="nav-item">
	      			<form method="GET" action="jarak.php" style="margin-top: 5px; margin-left: 20px;">
	      				<select name="destination" style="padding: 0px 10px;">
	      					<option value="bandara">Bandara Raden Intan</option>
	      					<option value="stasiun">Stasiun KAI Tj. Karang</option>
	      					<option value="pelabuhan">Pelabuhan Bakauheni</option>
	      					<option value="terminal">Terminal Rajabasa</option>
	      				</select>
	      				<input type="submit" value="Kalkulasi">
	      			</form>
	    		</li>
			  </ul>
		</nav>

		<div style="margin: 20px 25%;">
			<table id="jarak">
				<tr>
					<td colspan="2" style="padding: 0px;">
						<div id="map"></div>
					</td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Origins</b></td>
					<td>Universitas Lampung</td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Destination</b></td>
					<td>Terminal Rajabasa</td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Jarak</b></td>
					<td><?= $nilaiJarak; ?></td>
				</tr>
				<tr>
					<td style="text-align: left; padding: 10px 0px; padding-right: 300px; padding-left: 15px;"><b>Waktu Tempuh</b></td>
					<td><?= $durasi; ?></td>
				</tr>
			</table>
			
		</div>
		<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCx0yZKvuXFS6QawkRgVvmSw_xL7eDS_4&callback=initMap"></script>
		<script type="text/javascript" src="direction.js"></script>
		<script type="text/javascript">

			var latUnila = -5.364289;
			var lngUnila = 105.243187;
			var latTer = -5.368241;
			var lngTer = 105.237018;
			var map = null;

			var center = {lat: -4.991099, lng: 105.051365}
			function initMap(){
				map = new google.maps.Map(document.getElementById('map'),{
		        	zoom:5,
		        	center:center,
		        	disableDefaultUI: true,
		        	draggable: false,
		        	maxZoom: 9,
		        	minZoom: 9,
		    	});
		    	info_window = new google.maps.InfoWindow({
		    		'Content': 'Loading...'
		    	});

		    	var markers = [['Unila', latUnila, lngUnila],['Terminal Rajabasa', latTer, lngTer]];

		    	var infowindow = new google.maps.InfoWindow(), marker, i;
			    var bounds = new google.maps.LatLngBounds(); // diluar looping
			    for (i = 0; i < markers.length; i++) {  
			    pos = new google.maps.LatLng(markers[i][1], markers[i][2]);
			    bounds.extend(pos); // di dalam looping
			    marker = new google.maps.Marker({
			        position: pos,
			        map: map
			    });
			    google.maps.event.addListener(marker, 'click', (function(marker, i) {
			        return function() {
			            infowindow.setContent(markers[i][0]);
			            infowindow.open(map, marker);
			        }
			    })(marker, i));
			    map.fitBounds(bounds); // setelah looping
			    }
 
			}

		</script>

		</html>

		<?php
	}
?>