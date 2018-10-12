<template>
	<div>
		<div class="md-layout">
			<div class="md-layout-item md-size-80">
				<md-field class="md-form-group">
					<md-icon>search</md-icon>
					<gmap-autocomplete @place_changed="setPlace" class="md-input"></gmap-autocomplete>				
				</md-field>
			</div>
			<div class="md-layout-item md-size-20">
				<md-button class="md-success" @click="getAddress">set location</md-button>
			</div>			
		</div>
				
		<gmap-map class="google-map"
			ref="mapRef"
			:center="center"
			:zoom="13"
			@bounds_changed="mapChange">
			<gmap-marker
				:position="marker"
				:clickable="true"
				@click="center=marker"
			/>
		</gmap-map>
		<md-field :class="[
                {'md-valid': !errors.has('address') && touched.address},
                {'md-error': errors.has('address')}]">
			<label>Address</label>				
			<md-input  
				v-model="address" 
				required
				data-vv-name="address"
				name="address" 
				readonly
				v-validate="'required'"></md-input >
				<md-icon class="error" v-show="errors.has('address')">close</md-icon>
                <md-icon class="success" v-show="!errors.has('address') && touched.address">done</md-icon>
		</md-field>
		<input type='hidden' name='latitude' v-model="marker.lat"/>
		<input type='hidden' name='longitude' v-model="marker.lng"/>
	</div>
</template>
<script>

export default {
	data() {
		return {
			center: { lat: 45.508, lng: -73.587 },
			marker:{ lat: 45.508, lng: -73.587 },
			address: '',
			touched: {
				address: false
			}
		}
	},
	mounted() {
		this.$refs.mapRef.$mapPromise.then((map) => {
			this.geocoder = new google.maps.Geocoder();
		});
	},
	methods: {
		setPlace(place) {
			this.currentPlace = place;
			this.center = this.currentPlace.geometry.location;
		},

		mapChange(a) {
			this.address = '';
			var centObj = this.$refs.mapRef.$mapObject.getCenter();
			this.marker = {
				lat: centObj.lat(),
				lng: centObj.lng()
			};
		},
		getAddress() {
			var obj = this;
			this.geocoder.geocode({'latLng': this.marker}, function(results, status){
				if (status) {
					if (results != null) {
						obj.address = results[0].formatted_address;
					}
				}
			});
		},
		validate() {			
			return this.$validator.validateAll().then(res => {				
				if (res) {
					console.log(res);
					console.log(this.marker);
					this.$emit('on-validated', res, this.marker);
				}
				return res
			})
		},
	},
	watch: {
		address() {
			this.touched.address = true;
		}
	}
}
</script>
<style>
	#map {
		height: 400px;
	}

	.google-map {
		height: 400px;
		width: 100%;
		margin-bottom: 30px;
	}
</style>
