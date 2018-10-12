import './bootstrap.js';
import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";

import MaterialKit from "./plugins/material-kit";
import VueSweetalert2 from 'vue-sweetalert2';
import * as VueGoogleMaps from 'vue2-google-maps';

Vue.config.productionTip = false;

Vue.use(MaterialKit);
Vue.use(VueSweetalert2);
Vue.use(VueGoogleMaps, {
	load: {
		key: 'AIzaSyAUfciCLFycnIUlrUUwjApQyhRyNr01o7g',
		libraries: 'places'
	}
});

const NavbarStore = {
	showNavbar: false
};

Vue.mixin({
	data() {
		return {
			NavbarStore
		};
	}
});

new Vue({
	router,
	store,
	render: h => h(App)
}).$mount("#app");
