<template>
	<md-toolbar id="toolbar" md-elevation="5" class="md-white md-absolute" :class="extraNavClasses" :color-on-scroll="colorOnScroll">
		<div class="md-toolbar-row md-collapse-lateral">
			<div class="md-toolbar-section-start">
				<div class="avatar">
					<img :src="markImg" alt="Mark Image" class="">
				</div>
				<h1 class="md-title">GOVALET</h1>
			</div>
			<div class="md-toolbar-section-end">
				<md-button class="md-just-icon md-simple md-toolbar-toggle" :class="{toggled: toggledClass}" @click="toggleNavbarMobile()">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</md-button>

				<div class="md-collapse">
					<div class="md-collapse-wrapper">
						<mobile-menu nav-mobile-section-start="false">
						</mobile-menu>
						<md-list>
							<md-list-item to="/">
								<p>HOME</p>
							</md-list-item>

							<li class="md-list-item">
								<a href="javascript:void(0)" class="md-list-item-router md-list-item-container md-button-clean dropdown">
									<div class="md-list-item-content">
										<drop-down direction="down">
											<md-button slot="title" class="md-button md-button-link md-white md-simple dropdown-toggle" data-toggle="dropdown">
												<p>PARKING</p>
											</md-button>
											<ul class="dropdown-menu dropdown-with-icons">
												<li>
													<a href="#/landing">
														<md-icon>search</md-icon>
														<p>Search Places</p>
													</a>
												</li>
												<li>
													<a href="#/landing">
														<md-icon>change_history</md-icon>
														<p>Purchased Places</p>
													</a>
												</li>
											</ul>
										</drop-down>
									</div>
								</a>								
							</li>
							<li class="md-list-item">
								<a href="javascript:void(0)" class="md-list-item-router md-list-item-container md-button-clean dropdown">
									<div class="md-list-item-content">
										<drop-down direction="down">
											<md-button slot="title" class="md-button md-button-link md-white md-simple dropdown-toggle" data-toggle="dropdown">
												<p>PROFILE</p>
											</md-button>
											<ul class="dropdown-menu dropdown-with-icons">
												<li>
													<a href="#/profile">
														<md-icon>account_circle</md-icon>
														<p>User</p>
													</a>
												</li>
												<li>
													<a href="#/vehicle_profile">
														<md-icon>directions_car</md-icon>
														<p>Vehicle</p>
													</a>
												</li>
												<li>
													<a href="#/login">
														<md-icon>local_parking</md-icon>
														<p>Parking Spot</p>
													</a>
												</li>
											</ul>
										</drop-down>
									</div>
								</a>								
							</li>
							<md-list-item to="/profile">
								<p>RATE GUIDE</p>
							</md-list-item>
							<md-list-item to="/profile">
								<p>ABOUT</p>
							</md-list-item>
							<md-list-item to="/login">
								<p>LOGIN</p>
							</md-list-item>

						</md-list>
					</div>
				</div>
			</div>
		</div>
	</md-toolbar>
</template>
<style lang="scss" scoped>
	.md-toolbar .md-title {
		font-size: 40px;
		font-weight: bolder;
	}

	.md-list-item a .md-ripple p{
		font-size: 16px;
	}

	.avatar img {
		height: 64px;
	}
	
</style>
<script>
let resizeTimeout;
function resizeThrottler(actualResizeHandler) {
	// ignore resize events as long as an actualResizeHandler execution is in the queue
	if (!resizeTimeout) {
		resizeTimeout = setTimeout(() => {
			resizeTimeout = null;
			actualResizeHandler();

			// The actualResizeHandler will execute at a rate of 15fps
		}, 66);
	}
}

import MobileMenu from "@/layout/MobileMenu";
export default {
	components: {
		MobileMenu
	},
	props: {
		type: {
			type: String,
			default: "white",
		},
		colorOnScroll: {
			type: Number,
			default: 0
		},
		markImg: {
			type: String,
			default: require("@/../images/gv-mark.png")
		}
	},
	data() {
		return {
			extraNavClasses: "",
			toggledClass: false
		};
	},
	computed: {
		showDownload() {
			const excludedRoutes = ["login", "landing", "profile"];
			return excludedRoutes.every(r => r !== this.$route.name);
		}
	},
	methods: {
		bodyClick() {
			let bodyClick = document.getElementById("bodyClick");

			if (bodyClick === null) {
				let body = document.querySelector("body");
				let elem = document.createElement("div");
				elem.setAttribute("id", "bodyClick");
				body.appendChild(elem);

				let bodyClick = document.getElementById("bodyClick");
				bodyClick.addEventListener("click", this.toggleNavbarMobile);
			} else {
				bodyClick.remove();
			}
		},
		toggleNavbarMobile() {
			this.NavbarStore.showNavbar = !this.NavbarStore.showNavbar;
			this.toggledClass = !this.toggledClass;
			this.bodyClick();
		},
		handleScroll() {
			let scrollValue =
				document.body.scrollTop || document.documentElement.scrollTop;
			let navbarColor = document.getElementById("toolbar");
			this.currentScrollValue = scrollValue;
			if (this.colorOnScroll > 0 && scrollValue > this.colorOnScroll) {
				this.extraNavClasses = `md-${this.type}`;
				navbarColor.classList.remove("md-transparent");
			} else {
				if (this.extraNavClasses) {
					this.extraNavClasses = "";
					navbarColor.classList.add("md-transparent");
				}
			}
		},
		scrollListener() {
			resizeThrottler(this.handleScroll);
		},
		scrollToElement() {
			let element_id = document.getElementById("downloadSection");
			if (element_id) {
				element_id.scrollIntoView({ block: "end", behavior: "smooth" });
			}
		}
	},
	mounted() {
		document.addEventListener("scroll", this.scrollListener);
	},
	beforeDestroy() {
		document.removeEventListener("scroll", this.scrollListener);
	}
};
</script>
