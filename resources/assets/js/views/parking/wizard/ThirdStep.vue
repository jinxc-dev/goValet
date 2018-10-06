<template>
	<div class="md-layout">
		<div class="md-layout-item md-size-70">
			<md-field>
				<label>Search</label>
				<md-input id="input-location">
				</md-input>
            </md-field>
			<div id="map"></div>
		</div>
		<div class="md-layout-item">
			<md-field>
				<label>Location</label>
				<md-input>
				</md-input>
            </md-field>
			<md-field>
				<label>Spots</label>
				<md-input>
				</md-input>
            </md-field>

		</div>
	</div>
</template>
<script>
import GoogleMapsLoader from 'google-maps'
	export default {
		methods: {
			initMap (google) {
				var myLatlng = new google.maps.LatLng(40.748817, -73.985428)
				var mapOptions = {
					zoom: 13,
					center: myLatlng,
					scrollwheel: false
				};
				var map = new google.maps.Map(document.getElementById('map'), mapOptions);

				var marker = new google.maps.Marker({
					position: myLatlng,
					title: 'Hello World!'
				});
				marker.setMap(map)
			}			
		},
		mounted () {
			GoogleMapsLoader.KEY = 'AIzaSyAUfciCLFycnIUlrUUwjApQyhRyNr01o7g'
			GoogleMapsLoader.load((google) => {
				this.initMap(google)
			})
		}
	}
</script>
<style>
	#map {
		height: 400px;
	}
</style>
