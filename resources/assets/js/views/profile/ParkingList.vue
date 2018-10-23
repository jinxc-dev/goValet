<template>
	<md-card>
		<md-card-header class="md-card-header-green title-header">
            <h4 class="card-title">Parking Places</h4>
        </md-card-header>
		<md-card-content>
			<md-table v-model="dataModel" class="table-parking">
				<md-table-row slot="md-table-row" slot-scope="{ item }">
					<md-table-cell md-label="Photo">
						<div class="img-container">
							<img :src="item.image" alt="products"/>
						</div>
					</md-table-cell>
					<md-table-cell md-label="Name" class="td-name">{{ item.name }}</md-table-cell>
					<md-table-cell md-label="Address">{{ item.address }}</md-table-cell>
					<md-table-cell md-label="Type">{{ typeString[item.availability] }}</md-table-cell>
					<md-table-cell md-label="Rate" >$ {{ item.rate }}</md-table-cell>
					<md-table-cell md-label="Time">{{ item.from_time }} ~ {{ item.to_time }}</md-table-cell>					
					
					<md-table-cell md-label="Spot">{{ item.capacity }}</md-table-cell>
				</md-table-row>
			</md-table>
		</md-card-content>
		<md-card-actions>
			<md-button class="md-success" to="/add-parking" v-show="showAddButton">
				Add Parking
			</md-button>
		</md-card-actions>
	</md-card>
</template>

<script>
export default {
	data() {
		return {
			dataModel: [],
			showAddButton: true,
			typeString: {
                2 : "Monthly-24 hours",
                3 : "Monthly-Daylight hours only",
                4 : "Daily",
                5 : "Hourly"
            },
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

				console.log(this.dataModel);
				
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
		}
	}
};
</script>

<style lang="scss" scoped>

.table-parking {
	.img-container {
		display: block;
		max-height: 160px;
		overflow: hidden;
		width: 120px;
	}

	.td-name {
		min-width: 200px;
		font-size: 1.5em!important;
		font-weight: 400;
		line-height: 1.42857143;
		color: #3C4858;
	}
	
}

.table-parking table>thead>tr>th {
		font-size: .75rem;
		text-transform: uppercase;		
	}

</style>
