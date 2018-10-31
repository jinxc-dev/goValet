<template>
	<md-card>
		<md-card-header class="md-card-header-green title-header">
            <h4 class="card-title">Parking Places</h4>
        </md-card-header>
		<md-card-content>
			<md-table v-model="dataModel" class="table-parking">
				<md-table-row slot="md-table-row" slot-scope="{ item }">
					<md-table-cell >
						<div class="img-container">
							<img :src="item.image" alt="products"/>
						</div>
					</md-table-cell>
					<md-table-cell md-label="Name" class="td-name" style="min-width: 150px;">{{ item.name }}</md-table-cell>
					<md-table-cell md-label="Address">{{ item.address }}</md-table-cell>
					<md-table-cell md-label="Type">{{ typeString[item.availability] }}</md-table-cell>
					<md-table-cell md-label="Rate" class="td-name" style="min-width: unset;">$ {{ item.rate }}</md-table-cell>
					<md-table-cell md-label="Time">{{ item.from_time }} ~ {{ item.to_time }}</md-table-cell>
					<md-table-cell md-label="Spot">{{ item.capacity }}</md-table-cell>
					<md-table-cell md-label="Action">
						<md-button class="md-just-icon md-round md-info" @click="showUpdateDlg(item.id)">
							<md-icon>edit</md-icon>
						</md-button>
						<md-button class="md-just-icon md-round md-danger" style="margin-left: 10px">
							<md-icon>delete</md-icon>
						</md-button>
					</md-table-cell>
				</md-table-row>
			</md-table>
		</md-card-content>
		<md-card-actions>
			<md-button class="md-success" to="/add-parking" v-show="showAddButton">
				Add Parking
			</md-button>
		</md-card-actions>

		<div>
		    <md-dialog :md-active.sync="showDialog">
				<md-dialog-title>Parking Update</md-dialog-title>
				<md-dialog-content>
					<form class="form-horizontal" action="" method="post">
					<div class="parking-img">
						<div class="pic-container" style="width: 300px;">
							<div class="pic">
								<div><img :src="selectedInfo.image" /></div>
								<input type="file" name="image" @change="onFileChange"/>
							</div>
							<h6 class="description">Choose Parking Photo</h6>
						</div>
					</div>
					<div class="md-layout">
						<label class="md-layout-item md-size-35 md-form-label">Parking Spots</label>
						<div class="md-layout-item md-size-60">
							<md-field :class="[{'md-valid': !errors.has('spots')},{'md-error': errors.has('spots')}]">
								<md-input name="availability" v-model="selectedInfo.availability" data-vv-name="spots" v-validate="'required|min_value:1'"></md-input>
							</md-field>
						</div>
					</div>
					<div class="md-layout">
						<label class="md-layout-item md-size-35 md-form-label">Rate</label>
						<div class="md-layout-item md-size-60">
							<md-field :class="[{'md-valid': !errors.has('rate')},{'md-error': errors.has('rate')}]">
								<md-input name="rate" v-model="selectedInfo.rate" data-vv-name="rate" v-validate="'required|min_value:1'"></md-input>
							</md-field>
						</div>
					</div>
					<div class="md-layout">
						<label class="md-layout-item md-size-35 md-form-label">Time</label>
						<div class="md-layout-item md-size-60">
							<md-field class="md-form-group"> 
								<md-icon>access_time</md-icon>
								<label>From Time(08:30:AM)</label>
								<md-input v-model="selectedInfo.from_time" name="from_time"></md-input>
							</md-field>
							<md-field class="md-form-group">
								<md-icon>access_time</md-icon>
								<label>To Time(06:30:PM)</label>
								<md-input v-model="selectedInfo.to_time" name="to_time"></md-input>
							</md-field>
						</div>
					</div>
					</form>
				</md-dialog-content>
				<div class="dlg-action-group">
					<md-button class="pull-left" @click="showDialog = false">Close</md-button>
					<md-button class='md-success pull-right' @click='updateSelectedParking'>Update</md-button>
				</div>
			</md-dialog>
		</div>
	</md-card>
</template>

<script>

export default {
	components: {
	},
	data() {
		return {
			dataModel: [],
			showAddButton: true,
			showDialog: false,
			selectedInfo:{},
			typeString: {
                2 : "Monthly-24 hours",
                3 : "Monthly-Daylight hours only",
                4 : "Daily",
                5 : "Hourly"
			},
			p_id: 0
		};
	},
	computed: {

	},
	mounted() {
		axios.get('/api/parking/getByUser')
			.then(response => {
				console.log(response.data);
				if (response.data.status) {
					this.dataModel = response.data.data;
				}
			
				this.isShowAddButton();
			}).catch(error => {
				console.log(error);
			})
	},
	methods: {
		removeItem(id) {
			// this.$swal({
			// 	title: 'Are you sure?',
			// 	type: 'warning',
			// 	showCancelButton: true,				
			// 	confirmButtonClass: 'md-button md-success',
			// 	cancelButtonClass: 'md-button md-danger',
			// 	confirmButtonText: 'Yes, delete it!',
			// 	buttonsStyling: false				
			// }).then((result) => {
			// 	console.log(result);
			// 	if (result.value) {
			// 		axios.delete('/api/vehicle/delete/' + id)
			// 			.then(response => {
			// 				console.log(response.data);
			// 				this.$swal({
			// 					position: 'top-end',
			// 					type: 'success',
			// 					title: 'Your vehicle has been deleted',
			// 					showConfirmButton: false,
			// 					timer: 1000
			// 				})
			// 				this.dataModel = response.data;
			// 				this.isShowAddButton();
			// 			}).catch(error => {
			// 				console.log(error);
			// 			})
			// 	}
			// });
		},

		isShowAddButton() {
			this.showAddButton = false
			if(this.dataModel.length < 6)
				this.showAddButton = true;
		},
		showUpdateDlg(id) {
			this.p_id = id;
			this.showDialog = true;
			this.getSelectedInfo(id);
			
		},
		closeUpdateDlg() {
			console.log('close dlg');
			this.showDialog = false;
		},
		updateSelectedParking() {
			var formElement = document.querySelector("form");
			console.log(formElement);
            var data = new FormData(formElement);

            axios.post('/api/parking/update', data, {headers: { 'Content-Type': 'multipart/form-data' }})
				.then(response => {
					this.$swal({
							type: 'success',
							title: "Registration of parking place is successful",
							showConfirmButton: false,
							timer: 1000
                        })
                    this.$router.push('/profile');
				}).catch(error => {

				})			
		},
		getSelectedInfo(id) {
			axios.get('/api/parking/get?id=' + this.p_id)
                .then(response => {
                    if (response.data.status) {
                        this.selectedInfo = response.data.data;
                    }
                });
		},
		onFileChange(e) {
			var files = e.target.files || e.dataTransfer.files;
			if (!files.length)
				return;
			this.photo = files[0];
			this.createImage(files[0]);
		},
		createImage(file) {
			var reader = new FileReader();
			var vm = this;
			reader.onload = (e) => {
				vm.selectedInfo.image = e.target.result;
			};
			reader.readAsDataURL(file);
		},
	}
};
</script>

<style lang="scss" scoped>
.dlg-action-group {
    padding: 10px 30px;
}
.parking-img {
	display: flex;
    justify-content: center;
}
.md-dialog {
	width: 400px;
	// height: 700px;
}

.md-form-label {
    color: #aaa;
    font-size: inherit;
    font-weight: 400;
    line-height: 1.5;
    margin-bottom: 0;
    padding: 20px 5px 0 0;
    text-align: right;
}
</style>
