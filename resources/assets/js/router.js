import Vue from "vue";
import Router from "vue-router";
import Login from "./views/Login.vue";
import SignUp from "./views/Signup.vue";
import MainNavbar from "./layout/MainNavbar.vue";
import MainFooter from "./layout/MainFooter.vue";

import Profile from "./views/profile/Profile.vue";
import VehicleProfile from "./views/vehicle/Vehicle.vue";
import VehicleRegister from "./views/vehicle/VehicleRegister.vue";
import ParkingRegister from "./views/parking/ParkingRegister.vue";
import Home from './views/Home.vue';
import SearchParking from "./views/booking/SearchParking";

Vue.use(Router);

const router = new Router({
	routes: [
		{
			path: "/",
			name: "index",
			components: { default: Home, header: MainNavbar},
		},
		{
			path: "/signup",
			name: "user-signup",
			components: { default: SignUp, header: MainNavbar, footer: MainFooter },
		},
		{
			path: "/signup",
			name: "signup",
			components: { default: SignUp, header: MainNavbar, footer: MainFooter },
		},
		{
			path: "/login",
			name: "login",
			components: { default: Login, header: MainNavbar, footer: MainFooter },
		},
		{
			path: "/profile",
			name: "profile",
			components: { default: Profile, header: MainNavbar, footer: MainFooter },
		},
		{
			path: "/vehicle_profile",
			name: "vehicle-profile",
			components: { default: VehicleProfile, header: MainNavbar, footer: MainFooter },
		},
		{
			path: "/add_vehicle",
			name: "add-profile",
			components: { default: VehicleRegister, header: MainNavbar, footer: MainFooter },
		},
		{
			path: "/add-parking",
			name: "addParking",
			components: { default: ParkingRegister, header: MainNavbar, footer: MainFooter },
		},
		{
			path: "/logout",
			name: "logout",
			redirect: '*',
			// components: { default: ParkingRegister, header: MainNavbar, footer: MainFooter },

		},{
			path:'/search-parking',
			name:'search-parking',
			components: { default: SearchParking, header: MainNavbar, footer: MainFooter },
		}

	],
	scrollBehavior: to => {
		if (to.hash) {
			return { selector: to.hash };
		} else {
			return { x: 0, y: 0 };
		}
	}
});

router.beforeEach((to, from, next) => {
	// console.log(to);
	// helper.check();
	return next();
	// return next();
	// helper.check()
	// 	.then(response => {
	// 		console.log(response);
	// 		return next();
	// 	}).catch(error=>{

	// 	});
});
export default router;
