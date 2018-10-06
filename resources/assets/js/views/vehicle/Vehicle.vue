<template>
	<div class="wrapper">
		<div class="section">
			<div class="container">
				<h3>Vehicle Profile</h3>
				<div>
					<md-button class="md-round md-success" to="/add_vehicle">
						Add Vehicle
					</md-button>
				</div>
				<div class="md-layout">
					<div class="md-layout-item md-size-33 md-medium-size-66 md-xsmall-size-100">
						<md-card>
							<md-card-media>
								<img :src="cars[0].image" alt="car">
							</md-card-media>
							<md-card-content>
									<div class="md-title">Brand</div>
									<div class="md-subhead">Subtitle here</div>
									<div class="md-title">Model</div>
									<div class="md-subhead">TOYODA</div>
									<div class="md-title">Plate Number</div>
									<div class="md-subhead">ABC123456</div>
									<div class="md-title">Expire Date</div>
									<div class="md-subhead">08/10/2018</div>
							</md-card-content>
							<md-card-actions>
								<md-button class="md-just-icon md-round md-danger">
									<md-icon>delete</md-icon>
								</md-button>
							</md-card-actions>

						</md-card>						
					</div>
					<div class="md-layout-item md-size-33">
						<md-card>
							<md-card-media>
								<img :src="cars[1].image" alt="car">
							</md-card-media>
							<md-card-content>
									<div class="md-title md-size-50">Brand</div>
									<div class="md-subhead md-size-50">Subtitle here</div>
									<div class="md-title">Model</div>
									<div class="md-subhead">TOYODA</div>
									<div class="md-title">Plate Number</div>
									<div class="md-subhead">ABC123456</div>
									<div class="md-title">Expire Date</div>
									<div class="md-subhead">08/10/2018</div>
							</md-card-content>
							<md-card-actions>
								<md-button class="md-just-icon md-round md-danger">
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
			cars: [
				{ image: require("@/../images/cars/car3.jpg") },
				{ image: require("@/../images/cars/car4.jpg") },
				{ image: require("@/../images/cars/car6.jpg") }
			]
		};
	},
	props: {
		header: {
			type: String,
			// default: require("@/../images/city-profile.jpg")
		},
		img: {
			type: String,
			default: require("@/../images/faces/christian.jpg")
		}
	},
	computed: {
		headerStyle() {
			return {
				// backgroundImage: `url(${this.header})`
			};
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
