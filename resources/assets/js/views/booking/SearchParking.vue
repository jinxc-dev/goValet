
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
                                    <md-radio v-model="type" :value="1">Monthly</md-radio>
                                    <md-radio v-model="type" :value="2">Daily</md-radio>
                                    <md-radio v-model="type" :value="3">Houly</md-radio>
                                </div>
                                <md-field class="md-form-group">
                                    <md-icon>search</md-icon>
                                    <gmap-autocomplete @place_changed="setPlace" class="md-input"></gmap-autocomplete>				
                                </md-field>
                                <gmap-map class="google-map"
                                    ref="mapRef"
                                    :center="center"
                                    :zoom="15">
                                    <gmap-marker
                                        :position="center"
                                        :clickable="true"
                                    />
                                    <gmap-marker
                                        :key="index"
                                        v-for="(m, index) in markers"
                                        :position="m.position"
                                        :clickable="true"
                                        icon="/images/map/map-marker.png"
                                        @click="selectParking(m.id)"></gmap-marker>
                                    <gmap-marker                                        
                                        v-for="(m, idx) in otherMarkers"
                                        :key="m.id"
                                        :index=idx
                                        :position="m.position"
                                        icon="/images/map/yellow-dot.png"></gmap-marker>
                                </gmap-map>
                            </div>
                            <div class="md-layout-item md-size-40 md-medium-size-100">
                                <h4 class="title">Selected parking information</h4>
                                <div class="parking-info-form">
                                    <img :src="parkingInfo.photo" class="mx-auto">
                                    <h5 class="name text-center">{{parkingInfo.name}}</h5>
                                    <div class="md-layout">
                                        <div class="md-layout-item md-size-30">
                                            <h6 class="sub-title">Address</h6>
                                        </div>
                                        <div class="md-layout-item md-size-70">
                                            <div class="sub-content">{{parkingInfo.address}}</div>
                                        </div>
                                    </div>
                                    <div class="md-layout">
                                        <div class="md-layout-item md-size-30">
                                            <h6 class="sub-title">Parking Spot</h6>
                                        </div>
                                        <div class="md-layout-item md-size-70">
                                            <div class="sub-content"><small>{{parkingInfo.spotTotal}}</small>/{{parkingInfo.spotCurrent}}</div>
                                        </div>
                                    </div>
                                    <md-divider></md-divider>
                                    <div class="md-layout">
                                        <div class="md-layout-item md-size-30">
                                            <h6 class="sub-title">Parking Type</h6>
                                        </div>
                                        <div class="md-layout-item md-size-70">
                                            <div class="sub-content">{{parkingInfo.type}}</div>
                                        </div>
                                    </div>
                                    <div class="md-layout">
                                        <div class="md-layout-item md-size-30">
                                            <h6 class="sub-title">Rate</h6>
                                        </div>
                                        <div class="md-layout-item md-size-70">
                                            <div class="sub-content">${{parkingInfo.rate}}</div>
                                        </div>
                                    </div>
                                    <div class="md-layout">
                                        <div class="md-layout-item md-size-30">
                                            <h6 class="sub-title">Time</h6>
                                        </div>
                                        <div class="md-layout-item md-size-70">
                                            <div class="sub-content">{{parkingInfo.time}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <md-dialog :md-active.sync="showDialog">
                                <md-dialog-title>Booking and Pay</md-dialog-title>
                                <md-dialog-content>
                                    <md-datepicker 
                                        format="yyyy-mm-dd"
                                        v-model="bookingDate"
                                        :md-disabled-dates="disabledDates">
                                        <label>Booking Date</label>
                                    </md-datepicker>
                                    <div class="md-layout">
                                        <div class="md-layout-item">
                                            <md-field >
                                                <label>Selected Vehicle</label>
                                                <md-select v-model="selectedVehicle">
                                                    <md-option 
                                                        v-for="item in vehicleList"
                                                        :key="item.id"
                                                        :value="item.id">
                                                        {{item.brand}} {{item.model}} ({{item.plate_number}})
                                                    </md-option>
                                                </md-select>
                                            </md-field>
                                        </div>
                                        <div class="md-layout-item">
                                            <md-field >
                                                <label>Parking Spots(Max/Booked)</label>
                                                <md-input  
                                                    readonly
                                                    v-model="parkingSpotLabel"></md-input >
                                            </md-field>
                                        </div>                                        
                                    </div>
                                    <div class="md-layout">
                                        <div class="md-layout-item md-size-60">
                                            <md-field >
                                                <label>Paking type</label>
                                                <md-input  
                                                    name="paking-type" 
                                                    v-model="parkingInfo.type"
                                                    readonly></md-input >
                                            </md-field>
                                        </div>
                                        <div class="md-layout-item md-size-40">
                                            <md-field >
                                                <label>Rate</label>
                                                <span class="md-prefix">$</span>
                                                <md-input  
                                                    name="rate" 
                                                    v-model="parkingInfo.rate"
                                                    readonly ></md-input >
                                            </md-field>
                                        </div>
                                    </div>
                                    <card class="stripe-card"
                                        :class="{complete}"
                                        stripe="pk_test_ynUTEJ283sxZWedZ64yu8yrn"
                                        :options='stripeOptions'
                                        @chanage='complete = $event.complete'/>
                          
                                </md-dialog-content>
                                <div class="dlg-action-group">
                                    <md-button class="pull-left" @click="showDialog = false">Close</md-button>
                                    <md-button class='md-success pull-right' @click='pay' :disabled="!seletedPayBtn">Pay(${{parkingInfo.rate}})</md-button>
                                </div>
                            </md-dialog>
                           
                        </div>
                        <md-card-actions>
                             <md-button class="md-success md-raised" @click="showBookingDlg">Booking</md-button>
                        </md-card-actions>
                    </md-card-content>
                </md-card>
            </div>
        </div>
    </div>
</template>


<script>

import { Card, createToken } from 'vue-stripe-elements-plus'
// import moment from 'moment'

export default {
    components: { Card },
    data() {
        return {
            center: { lat: 33.45, lng: -112.0723 },
            // center: {},
            markers: [],
            otherMarkers:[],
            type: 1, 
            defaultPhoto: require("@/../images/image-empty.jpg"), 
            parkingInfo:{},

            typeString: {
                2 : "Monthly-24 hours",
                3 : "Monthly-Daylight hours only",
                4 : "Daily",
                5 : "Hourly"
            },

            vehicleList: [],
            bookingDate: new Date(),
            disabledDates: date => {
                return date < new Date();
            },
            selectedVehicle: 0,
            parkingSpotLabel: "5/4",

            complete: false,
            stripeOptions: {
                // hidePostalCode:true
            },
            showDialog: false,
            seletedPayBtn: true,
        }
    },

    mounted() {
        if (navigator.geolocation) {
                // navigator.geolocation.getCurrentPosition(this.getCurrentPlace);
        }
		this.$refs.mapRef.$mapPromise.then((map) => {     
            this.service = new google.maps.places.PlacesService(map);
            console.log(map);
            this.center = map.center;
            this.setParkingData();
            this.searchParking();
        });
        var obj = this;
        axios.get("/api/vehicle/get")
            .then(response => {
                console.log(response);
                if (response.data.length > 0) {
                    obj.vehicleList = response.data;
                    obj.selectedVehicle = obj.vehicleList[0].id;
                } else {
                    console.log('error');
                }
            });
        
	},

    watch: {
        type() {
            this.searchParking();
        }
    },

    methods: {
        getCurrentPlace(position) {
            this.center.lat = position.coords.latitude;
            this.center.lng = position.coords.longitude;
        },
        setPlace(place) {
			this.currentPlace = place;
            this.center = this.currentPlace.geometry.location;
            this.nearBySearch();
            this.searchParking();
        },
        pay() {
            if (this.bookingDate == null || this.bookingDate == "") {
                return;
            }
            var parking_date =window.formatDate(this.bookingDate);//  "2018-09-12";// moment(this.bookingDate).format('YYYY-MM-DD');
            
            var obj = this;
            obj.seletedPayBtn = false;
            createToken().then(data => {  
                // obj.seletedPayBtn = false;
                if (data.token != null) {
                    var data = {
                        card_number: "************" + data.token.card.last4,
                        token: data.token.id,
                        vehicle_id: obj.selectedVehicle,
                        booking_date: parking_date,
                        parking_id: obj.parkingInfo.id
                    }
                    axios.post("/api/booking/pay", data)
                        .then(response => {
                            
                            obj.seletedPayBtn = true;
                            if (response.data.status) {
                                obj.showDialog = false;
                                obj.$swal({
                                    type: 'success',
                                    title: "Congratulations on your successful booking",
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            // } else {
                            //     obj.$swal({
                            //         type: 'info',
                            //         title: "Fail is",
                            //         showConfirmButton: false,
                            //         timer: 1000
                            //     });
                            }

                            return;
                        });
                } else {
                    obj.seletedPayBtn = true;    
                }
            });
        },

        showBookingDlg() {
            // this.showDialog = true;
            this.seletedPayBtn = true;
            var msg = "Please select parking place";
            if (this.parkingInfo.rate <= 0 ) {                
                msg = "Please select parking place";
            } else if (this.parkingInfo.spotTotal <= this.parkingInfo.spotCurrent ){
                msg = "Available spots don't exist!";
            } else {
                this.showDialog = true;
                return;
            }
            this.$swal({
                type: 'info',
                title: msg,
                confirmButtonClass: 'md-button md-success',
                buttonsStyling: false
            });
        },

        searchParking() {
            console.log("type:" + this.type);
            var parkingType = [];
            if (this.type == 1) {
                parkingType.push(2);
                parkingType.push(3);
            } else {
                parkingType.push(this.type + 2);
            }
            var data = {};
            data.type = parkingType;
            data.lat = this.center.lat();
            data.lng = this.center.lng();
            var obj = this;

            axios.get('/api/parking/searchParking', {params:data})
                .then(response => {
                    if (response.data.status) {
                        obj.setMarkers(response.data.data);
                    }
                });
        },

        setMarkers(data) {
            console.log(data);
            this.markers = [];
            for (var i = 0; i < data.length; i++) {
                var tmp = {};                
                tmp.position = {
                    lat: data[i].latitude,
                    lng: data[i].longitude
                }
                tmp.id = data[i].id;
                this.markers.push(tmp);
            }

            this.nearBySearch();
            this.setParkingData();
        },

        selectParking(id) {
            var data = {
                id: id
            };
            var obj = this;
            axios.get('/api/parking/get', {params:data})
                .then(response => {
                    if (response.data.status) {
                        var tmp_data = response.data.data;
                        obj.setParkingData(tmp_data);
                    }
                });
        },

        nearBySearch() {
            var obj = this;
            this.service.nearbySearch({
                location: this.center,
                radius: 10000,
                type:['parking']
            }, function(results, status){
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    console.log(results);
                    obj.otherMarkers = [];
                    for (var i = 0; i < results.length; i++) {
                        obj.otherMarkers.push({
                            position: results[i].geometry.location,
                            id: 'near-' + i
                        });
                    }
                }
            });
        },
        setParkingData(data) {
            if (data != null) {
                var info = {
                    id: data.id,
                    name: data.name,                            
                    address: data.address,
                    spotTotal: data.capacity,
                    spotCurrent: 0,
                    type: this.typeString[data.availability],
                    rate: data.rate,
                    time: data.from_time + "~" + data.to_time               
                };
                if (data.image == "" || data.image == null) {
                    info.photo = this.defaultPhoto;
                } else {
                    info.photo = data.image;
                }
                this.parkingInfo = info;
            } else {
                this.parkingInfo = {
                    id: 0,
                    name: "",
                    photo: require("@/../images/image-empty.jpg"),
                    address: "",
                    spotTotal: 0,
                    spotCurrent: 0,
                    type: "",
                    rate: 0,
                    time: ""               
                };
            }
        }
    }
}
</script>

<style lang="scss" scoped>
.md-dialog {
    width: 500px;
}
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

.dlg-action-group {
    padding: 10px 30px;
}
</style>

