<template>
	<md-card>
		<md-card-header class="md-card-header-green title-header">
            <h4 class="card-title">Vehicle Profile</h4>
        </md-card-header>
		<md-card-content>
			<md-card v-for="item in dataModel" :key="item.id" class="vehicle-card">
				<md-card-media-actions>
					<md-card-media>
						<img :src="item.photo" alt="Cover">
					</md-card-media>
					<md-card-content>
						<h4 class="card-title">Brand  <small>{{item.brand}}</small></h4>
						<h4 class="card-title">Model  <small>{{item.model}}</small></h4>
						<h4 class="card-title">Plate Number  <small>{{item.plate_number}}</small></h4>
					</md-card-content>
					<md-card-actions>
						<md-button class="md-just-icon md-round md-danger" @click="removeItem(item.id)">
								<md-icon>delete</md-icon>
						</md-button>
					</md-card-actions>
				</md-card-media-actions>				
			</md-card>
		</md-card-content>
		<md-card-actions>
			<md-button class="md-success" to="/add_vehicle" v-show="showAddButton">
				Add Vehicle
			</md-button>
		</md-card-actions>
	</md-card>
</template>

<script>
export default {
	bodyClass: "profile-page",
	data() {
		return {
			dataModel: [],
			showAddButton: true
		};
	},
	props: {
		header: {
			type: String,
			// default: require("@/../images/city-profile.jpg")
		},
		img: {
			type: String,
			default: require("@/../images/default-avatar.png")
		}
	},
	computed: {

	},
	mounted() {
		axios.get('/api/vehicle/get')
			.then(response => {
				console.log(response.data);
				this.dataModel = response.data;
				this.isShowAddButton();
			}).catch(error => {
				console.log(error);
			})
	},
	methods: {
		removeItem(id) {
			this.$swal({
				title: 'Are you sure?',
				type: 'warning',
				showCancelButton: true,				
				confirmButtonClass: 'md-button md-success',
				cancelButtonClass: 'md-button md-danger',
				confirmButtonText: 'Yes, delete it!',
				buttonsStyling: false				
			}).then((result) => {
				console.log(result);
				if (result.value) {
					axios.delete('/api/vehicle/delete/' + id)
						.then(response => {
							console.log(response.data);
							this.$swal({
								position: 'top-end',
								type: 'success',
								title: 'Your vehicle has been deleted',
								showConfirmButton: false,
								timer: 1000
							})
							this.dataModel = response.data;
							this.isShowAddButton();
						}).catch(error => {
							console.log(error);
						})
				}
			});
		},

		isShowAddButton() {
			this.showAddButton = false
			if(this.dataModel.length < 3)
				this.showAddButton = true;
			console.log(this.showAddButton);
		}
	}
};
</script>

<style lang="scss" scoped>
.section {
	padding: 0;
}
.container {
	padding-top: 84px;
}
.md-subhead {
	margin-left: 20px;
}

.vehicle-card{
	margin: 5px;
	background-color: #fdf7f7
}

</style>
