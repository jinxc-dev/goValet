<template>
	<div class="wrapper">
		<div class="section page-header" :style="headerStyle"></div>
		<div class="section">
			<div class="container">
				<!-- <div class="md-layout">
					<div class="md-layout-item md-size-30 md-medium-size-50 md-xsmall-size-50 mx-auto">
						<div class="profile">
							<div class="avatar">
								<img :src="user.avatar" alt="Circle Image" class="img-raised rounded-circle">
							</div>
							<div class="name">
								<h3 class="title">{{user.first_name}}  {{user.last_name}}</h3>
								<h4 class="text-left">Email: <span>{{user.email}}</span></h4>
								<h4 class="text-left">Phone: <span>{{user.phone}}</span></h4>
								<h4 class="text-left">Type: 
									<span v-if='user.type==0'>I am guest.</span>
									<span v-else>I am host.</span>
								</h4>
							</div>
						</div>
					</div>
				</div> -->
				<div class="md-layout md-gutter">
					<div class="md-layout-item md-size-40 md-xsmall-size-100">
					<user-profile ></user-profile>
					</div>
					<div class="md-layout-item md-size-60 md-xsmall-size-100">
						<vehicle-list></vehicle-list>
					</div>
				</div>
				<div>
					<parking-list></parking-list>
				</div>
			</div>
		</div>		
	</div>
</template>

<script>
import UserProfile from "./UserProfile.vue";
import VehicleList from "./VehicleList.vue";
import ParkingList from "./ParkingList.vue";
export default {
	components: {
		UserProfile,
		VehicleList,
		ParkingList
	},
	bodyClass: "profile-page",
	data() {
		return {
			user: helper.getUser(),
		};
	},

	mounted() {
		
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

.page-header {
	height: 160px;
}

.profile-page .profile img {
    width: 160px;
	height: 160px;
}



</style>
