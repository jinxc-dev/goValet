<template>
	<div class="wrapper">
		<div class="section">
			<div class="container">
                <md-card>
                    <md-card-header class="md-card-header-green title-header">
                        <h4 class="card-title">Search Parking</h4>
                    </md-card-header>
                    <md-card-content>
                        <div class="md-layout">
                            <div class="md-layout-item md-size-60 md-medium-size-100">
                                <h4 class="title">Search</h4>
                                
                                <div>
                                    <!-- <h4>Select parking type</h4> -->
                                    <md-radio v-model="type" :value="1">Monthly</md-radio>
                                    <md-radio v-model="type" :value="2">Daily</md-radio>
                                    <md-radio v-model="type" :value="3">Houly</md-radio>
                                </div>
                                <!-- </md-field> -->
                                <md-field class="md-form-group">
                                    <md-icon>search</md-icon>
                                    <gmap-autocomplete @place_changed="setPlace" class="md-input"></gmap-autocomplete>				
                                </md-field>
                                <gmap-map class="google-map"
                                    ref="mapRef"
                                    :center="center"
                                    :zoom="13">
                                    <gmap-marker
                                        :position="marker"
                                        :clickable="true"
                                        @click="center=marker"
                                    />
                                </gmap-map>
                            </div>
                            <div class="md-layout-item md-size-40 md-medium-size-100">
                                <h4 class="title">Selected parking information</h4>
                                <div class="parking-info-form">
                                    <img :src="parkingInfo.photo" class="mx-auto">
                                    <h5 class="name text-center">Parking Name</h5>
                                    <div class="md-layout">
                                        <div class="md-layout-item md-size-30">
                                            <h6 class="sub-title">Address</h6>
                                        </div>
                                        <div class="md-layout-item md-size-70">
                                            <div class="sub-content">62 Avenue du Mont-Royal E, Mont-Royal, QC H3P 3B8, Canada</div>
                                        </div>
                                    </div>
                                    <div class="md-layout">
                                        <div class="md-layout-item md-size-30">
                                            <h6 class="sub-title">Parking Spot</h6>
                                        </div>
                                        <div class="md-layout-item md-size-70">
                                            <div class="sub-content"><small>5</small>/4</div>
                                        </div>
                                    </div>
                                    <md-divider></md-divider>
                                    <div class="md-layout">
                                        <div class="md-layout-item md-size-30">
                                            <h6 class="sub-title">Parking Type</h6>
                                        </div>
                                        <div class="md-layout-item md-size-70">
                                            <div class="sub-content">Monthly(24Hours)</div>
                                        </div>
                                    </div>
                                    <div class="md-layout">
                                        <div class="md-layout-item md-size-30">
                                            <h6 class="sub-title">Rate</h6>
                                        </div>
                                        <div class="md-layout-item md-size-70">
                                            <div class="sub-content">$200</div>
                                        </div>
                                    </div>
                                    <div class="md-layout">
                                        <div class="md-layout-item md-size-30">
                                            <h6 class="sub-title">Time</h6>
                                        </div>
                                        <div class="md-layout-item md-size-70">
                                            <div class="sub-content">8:30 AM ~ 6:30 PM</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md-layout">
                            <div class="md-layout-item">
                                <md-datepicker format="yyyy-mm-dd">
                                    <label>Expire Date</label>
                                </md-datepicker>
                            </div>
                            <div class="md-layout-item">
                                <md-field >
                                    <label>Rate</label>				
                                    <md-input  
                                        required
                                        name="address" 
                                        readonly ></md-input >
                                </md-field>
                            </div>
                        </div>
                    </md-card-content>
                </md-card>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
        	center: { lat: 45.508, lng: -73.587 },
            marker:{ lat: 45.508, lng: -73.587 },            
            type: 1,
            parkingInfo: {
                photo: require("@/../images/image-empty.jpg")
            }
        }
    },

    methods: {
        setPlace(place) {
			this.currentPlace = place;
			this.center = this.currentPlace.geometry.location;
		},
    }
}
</script>

<style lang="scss" scoped>
.section {
    padding: 0;
    display: flex;
    justify-content: center;
}
.container {
	padding-top: 84px;
}
.google-map {
    height: 400px;
    width: 100%;
    margin-bottom: 30px;
}

.md-radio {
    margin: 5px 20px;
}

.parking-info-form {
    margin-top:15px;
    img {
        width: 300px;
        display: flex;
    }
    .sub-title {
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .sub-content {
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .name {
        text-transform: uppercase;
    }
}
</style>

