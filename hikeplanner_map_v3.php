<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
		<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
		<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
		<link rel="stylesheet" type="text/css" href="./projet_css/map.css"/>
        <title>Map</title>
    </head>
    <body>
		<?php session_start() ?>

        <div id="map">
	    <!-- Here we will have the map -->
		</div>

        <!-- Javascript files -->
        <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
		<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
		<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
		<script type="text/javascript">
			// General parameters
			const saveBaseUrl = 'save.php';
			const mapboxApiKey = 'pk.eyJ1IjoiZml0ejQ1IiwiYSI6ImNqbGM4aTllaTJoeGMza3FraHRkYml4MHoifQ.VCdlDhvEJrxsOBlG1QqEBQ';
			const belfort_lat = 47.639674;
			const belfort_lon = 6.863849;
			const montbeliard_lat = 47.5101551;
			const montbeliard_lon = 6.798201;
			
			// Test URL: hikeplanner_map.html?lat=47.639674&lat=47.5101551&lng=6.863849&lng=6.798201

			
			// Find waypoints in URL
			let urlParams = new URLSearchParams(window.location.search);
			if(urlParams.has('lat') && urlParams.has('lng')) {
				let lat = urlParams.getAll('lat');
				let lng = urlParams.getAll('lng');
				start_waypoint_lat = lat[0];
				start_waypoint_lon = lng[0];
				waypoints = lat.map(function(it, index) { return L.latLng(it, lng[index]); });
			} else {
				// Initializing with latitude and longitude of Belfort (center of the map)
				start_waypoint_lat = belfort_lat;
				start_waypoint_lon = belfort_lon;
				waypoints = [L.latLng(belfort_lat, belfort_lon), L.latLng(montbeliard_lat, montbeliard_lon)];
			}
            
            var my_map = null;
            // Initialize the map
            function initMap() {
                // Create "my_map" and insert it in the HTML element with ID "map"
                my_map = L.map('map').setView([start_waypoint_lat, start_waypoint_lon], 11);
                // Set up Leaflet to use OpenStreetMap with Mapbox for routing
                L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                    attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                    minZoom: 1,
                    maxZoom: 20
                }).addTo(my_map);
				
				const router = L.Routing.mapbox(mapboxApiKey, {
					profile : 'mapbox/walking',
					language: 'en'
				});
				
				let routingControl = L.Routing.control({
					waypoints: waypoints,
					routeWhileDragging: true,
					router: router,
					geocoder: L.Control.Geocoder.nominatim()
				});
				routingControl.addTo(my_map);

				// Create additional buttons
				let container = document.getElementsByClassName('leaflet-routing-container')[0];
				let confirmButton = L.DomUtil.create('button', 'btn-routing-save', container);
				document.getElementsByClassName('btn-routing-save')[0].textContent = 'Save';
				L.DomEvent.on(confirmButton, 'click', function() {
					let customWaypoints = routingControl.getWaypoints();
					let customWaypointsLatLng = customWaypoints.map(function(it) { return it.latLng; });
					let saveUrl = saveBaseUrl + '?';
					// Concat latitudes
					saveUrl += ('lat[]=' + customWaypointsLatLng[0].lat);
					for (let i = 1; i < customWaypointsLatLng.length; i++) {
						saveUrl += ('&lat[]=' + customWaypointsLatLng[i].lat);
					}
					// Concat longitudes
					for (let i = 0; i < customWaypointsLatLng.length; i++) {
						saveUrl += ('&lng[]=' + customWaypointsLatLng[i].lng);
					}
					let textMetaData = document.querySelector('.leaflet-routing-alt').children[1].textContent;
					let distance = textMetaData.substring(0, textMetaData.indexOf(' '));
					let time = textMetaData.substring(textMetaData.indexOf(',') + 2).replace(/\s/g, '');

					saveUrl += '&distance=' + distance;
					saveUrl += '&time=' + time;
					localStorage.setItem('link',saveUrl);
					
					console.log(saveUrl);


					// document.write("<div id='name_run' class='overlay'> <div class='content'> <form method='post'> <label for='name'>Name for your run</label>	<input id='name' name='name' type='text' placeholder='Best run ever !'/> <input name='run_name' type='submit' value='New run'/>	</form>	<a href='save.php' class='cross'>&times;</a> </div> </div>");
					
					document.location.href = "#name_run";
					// document.location.href = saveUrl;
				});

            }
            window.onload = function(){
				// Initialize the map once the DOM is loaded
				initMap(); 
            };

			function save() {
				let link = localStorage.getItem('link');
				link += '&name=';
				link += document.getElementById("name").value.replace(/ /i, '_');
				document.location.href = link;
				return false;
			}
        </script>

		<div id="name_run" class="overlay">
			<div class="content">
				<form method="post" action="" onsubmit="return save();">
					<label for="name"> Name for your run </label>
					<input id="name" name="name" type="text" placeholder="Best run ever !"/>
					<input name="run_name" type="submit" value="New run"/>
				</form>
				<a href="#" class="cross">&times;</a>
			</div>
		</div>
    </body>
</html>