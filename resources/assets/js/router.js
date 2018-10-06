import Vue from "vue";
import Router from "vue-router";
import Landing from "./views/Landing.vue";
import Login from "./views/Login.vue";
import Register from "./views/Register.vue";
import MainNavbar from "./layout/MainNavbar.vue";
import MainFooter from "./layout/MainFooter.vue";

import Profile from "./views/profile/Profile.vue";
import VehicleProfile from "./views/vehicle/Vehicle.vue";
import VehicleRegister from "./views/vehicle/VehicleRegister.vue";
import ParkingRegister from "./views/parking/ParkingRegister.vue";

Vue.use(Router);

export default new Router({
	routes: [
		{
			path: "/",
			name: "index",
			components: { default: Register, header: MainNavbar, footer: MainFooter },
			props: {
				header: { colorOnScroll: 100 },
				footer: { backgroundColor: "black" }
			}
		},
		{
			path: "/register",
			name: "user-signup",
			components: { default: Register, header: MainNavbar, footer: MainFooter },
			props: {
				header: { colorOnScroll: 100 },
				footer: { backgroundColor: "black" }
			}
		},
		{
			path: "/landing",
			name: "landing",
			components: { default: Landing, header: MainNavbar, footer: MainFooter },
			props: {
				header: { colorOnScroll: 100 },
				footer: { backgroundColor: "black" }
			}
		},
		{
			path: "/login",
			name: "login",
			components: { default: Login, header: MainNavbar, footer: MainFooter },
			props: {
				header: { colorOnScroll: 100 }
			}
		},
		{
			path: "/profile",
			name: "profile",
			components: { default: Profile, header: MainNavbar, footer: MainFooter },
			props: {
				header: { colorOnScroll: 100 },
				footer: { backgroundColor: "black" }
			}
		},
		{
			path: "/vehicle_profile",
			name: "vehicle-profile",
			components: { default: VehicleProfile, header: MainNavbar, footer: MainFooter },
			props: {
				header: { colorOnScroll: 100 },
				footer: { backgroundColor: "black" }
			}
		},
		{
			path: "/add_vehicle",
			name: "add-profile",
			components: { default: VehicleRegister, header: MainNavbar, footer: MainFooter },
			props: {
				header: { colorOnScroll: 100 },
				footer: { backgroundColor: "black" }
			}
		},
		{
			path: "/add-parking",
			name: "addParking",
			components: { default: ParkingRegister, header: MainNavbar, footer: MainFooter },
			// props: {
			// 	header: { colorOnScroll: 100 },
			// 	footer: { backgroundColor: "black" }
			// }
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
