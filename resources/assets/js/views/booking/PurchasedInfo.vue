
<template>
	<div class="wrapper">
		<div class="section">
			<div class="container">
                <md-card>
                    <md-card-header class="md-card-header-green title-header">
                        <h4 class="card-title">Purchased Places</h4>
                    </md-card-header>
                    <md-card-content>
                        <div v-if="monthlyInfo.length > 0">
                            <h2 class="md-display-1 text-center"> MONTHLY LIST</h2>
                            <md-table v-model="monthlyInfo" class="table-parking">
                                <md-table-row slot="md-table-row" slot-scope="{ item }">
                                    <md-table-cell md-label="Date" class="td-name booking-date" >{{ item.parking_date }}</md-table-cell>
                                    <md-table-cell md-label="Vehicle Image">
                                        <div class="img-container">
                                            <img :src="item.vehicle.photo" alt="products"/>
                                        </div>
                                    </md-table-cell>
                                    <md-table-cell md-label="Plate Number" class="td-name">{{ item.vehicle.plate_number}}</md-table-cell> 
                                    <md-table-cell md-label="parking image">
                                        <div class="img-container">
                                            <img :src="item.parking.image" alt="products"/>
                                        </div>
                                    </md-table-cell>
                                    <md-table-cell md-label="Address">{{ item.parking.address }}</md-table-cell>
                                    <md-table-cell md-label="Type">{{ typeString[item.parking.availability] }}</md-table-cell>
                                    <md-table-cell md-label="Amount" class="td-name">$ {{ item.amount }}</md-table-cell>
                                    <md-table-cell md-label="Action" style="width: 100px">
                                        <md-button v-if="item.is_canceled==0" class="md-danger" @click="doTeminate(item.id)">Teminate</md-button>
                                        <div v-else>{{item.expire_date}}</div>
                                    </md-table-cell>
                                </md-table-row>
                            </md-table>
                        </div>
                        <md-divider></md-divider>
                        <div v-if="dailyInfo.length > 0">
                            <h2 class="md-display-1 text-center"> DAILY LIST</h2>
                            <purchased-table :data="dailyInfo" v-on:on-cancel="doCancel"></purchased-table>
                        </div>

                        <md-divider></md-divider>
                        <div v-if="hourlyInfo.length > 0">
                            <h2 class="md-display-1 text-center"> HOURLY LIST</h2>
                            <purchased-table :data="hourlyInfo" v-on:on-event="doCancel"></purchased-table>
                        </div>
                    </md-card-content>
                </md-card>

                <md-dialog :md-active.sync="showDialog" :md-click-outside-to-close="false">
                    <md-dialog-title style="text-align:center">Processing</md-dialog-title>
                    <md-content>
                        <div style="text-align:center; padding: 20px">
                            <md-progress-spinner md-mode="indeterminate"></md-progress-spinner>
                        </div>
                    </md-content>
                </md-dialog>

                
            </div>
        </div>
    </div>
</template>


<script>
import PurchasedTable from "./PurchasedTable"
export default {
    components: { PurchasedTable },
    data() {
        return {
            monthlyInfo: [],
            dailyInfo: [],
            hourlyInfo: [],
            showDialog: false,
            typeString: {
                2 : "24 hours",
                3 : "Daylight hours only",
                4 : "Daily",
                5 : "Hourly"
            },
        }
    },

    mounted() {
        axios.get("/api/booking/purchased-info/monthly")
            .then(response => {                
                if (response.data.status) {
                    this.monthlyInfo = response.data.data;
                }
            });

        axios.get("/api/booking/purchased-info?type=4")
            .then(response => {                
                if (response.data.status) {
                    this.dailyInfo = response.data.data;
                }
                console.log(this.dailyInfo);
            });
        axios.get("/api/booking/purchased-info?type=5")
            .then(response => {                
                if (response.data.status) {
                    this.hourlyInfo = response.data.data;
                }
                console.log(this.hourlyInfo);
            });        
	},

    methods: {

        getMonthly() {
            axios.get("/api/booking/purchased-info/monthly")
                .then(response => {                
                    if (response.data.status) {
                        this.monthlyInfo = response.data.data;
                    }
                });
        },

        getPurchased() {
            axios.get("/api/booking/purchased-info?type=4")
                .then(response => {                
                    if (response.data.status) {
                        this.dailyInfo = response.data.data;
                    }
                    console.log(this.dailyInfo);
                });
            axios.get("/api/booking/purchased-info?type=5")
                .then(response => {                
                    if (response.data.status) {
                        this.hourlyInfo = response.data.data;
                    }
                    console.log(this.hourlyInfo);
                });     
        },

        doTeminate(id) {
            console.log(id);
            this.$swal({
				title: 'Are you sure?',
				type: 'warning',
				showCancelButton: true,				
				confirmButtonClass: 'md-button md-success',
				cancelButtonClass: 'md-button md-danger',
				confirmButtonText: 'Yes, teminate it!',
				buttonsStyling: false
			}).then((result) => {
				if (result.value) {
                    this.showDialog = true;
					axios.post('/api/booking/teminate', {id: id})
						.then(response => {
                            this.showDialog = false;
                            var type = 'warning';
                            var msg = response.data.message;
							if (response.data.status) {
                                type ='success';
                                msg = "Your expire date is " + response.data.data.expire_date + "\n You paid $" + response.data.data.amount;
								this.getMonthly();
							} 
							console.log(response);
							this.$swal({
								// position: 'top-end',
								type: type,
								title: msg,
								showConfirmButton: false,
								timer: 2000
							});
						}).catch(error => {
                            this.showDialog = false;
							console.log(error);
						})
				}
			});
        },
        doCancel(id) {
            this.$swal({
				title: 'Are you sure?',
				type: 'warning',
				showCancelButton: true,				
				confirmButtonClass: 'md-button md-success',
				cancelButtonClass: 'md-button md-danger',
				confirmButtonText: 'Yes',
				buttonsStyling: false
			}).then((result) => {
                console.log(result);
				if (result.value) {
                    this.showDialog = true;
					axios.post('/api/booking/cancel', {id: id})
						.then(response => {
                            this.showDialog = false;
                            var type = 'warning';
                            var msg = response.data.message;
							if (response.data.status) {
                                type ='success';
                                msg = "Cancellation Success!";
                                // msg = "Your expire date is " + response.data.data.expire_date + "\n You paid $" + response.data.data.amount;
								this.getPurchased();
							} 
							this.$swal({
								// position: 'top-end',
								type: type,
								title: msg,
								showConfirmButton: false,
								timer: 2000
							});
						}).catch(error => {
                            this.showDialog = false;
                            console.log(error);
                            this.$swal({
								// position: 'top-end',
								type: 'warning',
								title: 'Server error',
								showConfirmButton: false,
								timer: 2000
							});
						})
				}
			});
        }
    }
}
</script>

<style lang="scss" scoped>
.container {
	padding-top: 84px;
}
.section {
    padding: 0;
    display: flex;
    justify-content: center;
}

.td-name {
    min-width: unset;
}
.booking-date {
    min-width: 150px;
}

.md-ripple {
	padding: 5px 20px !important;
}
</style>

