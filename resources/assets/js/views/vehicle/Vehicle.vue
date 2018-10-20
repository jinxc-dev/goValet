<template>
	<div class="wrapper">
		<div class="section">
			<div class="container">
				<h3>Vehicle Profile</h3>
				<div>
					<md-button class="md-round md-success" to="/add_vehicle" v-show="showAddButton">
						Add Vehicle
					</md-button>
				</div>
				<div class="md-layout">
					<div class="md-layout-item md-size-33 md-medium-size-100 md-xsmall-size-100" v-for="item in dataModel" :key=item.id>
						<md-card>
							<md-card-media>
								<img :src="item.photo" alt="car">
							</md-card-media>
							<md-card-content>
									<div class="md-title">Brand</div>
									<div class="md-subhead">{{item.brand}}</div>
									<div class="md-title">Model</div>
									<div class="md-subhead">{{item.model}}</div>
									<div class="md-title">Plate Number</div>
									<div class="md-subhead">{{item.plate_number}}</div>
									<div class="md-title">Expire Date</div>
									<div class="md-subhead">{{item.expire_date}}</div>
							</md-card-content>
							<md-card-actions>
								<md-button class="md-just-icon md-round md-danger" @click="removeItem(item.id)">
									<md-icon>delete</md-icon>
								</md-button>
							</md-card-actions>

						</md-card>						
					</div>
				
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { Tabs } from "@/components";
export default {
	components: {
		Tabs
	},
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

// .profile-tabs /deep/ {
// 	.md-card-tabs .md-list {
// 		justify-content: center;
// 	}

// 	[class*="tab-pane-"] {
// 		margin-top: 3.213rem;
// 		padding-bottom: 50px;

// 		img {
// 			margin-bottom: 2.142rem;
// 		}
// 	}
// }
</style>
