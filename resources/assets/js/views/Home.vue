<template>
	<div class="wrapper">
		<div class="section">
			<img :src="bgImg"/>

			<div class="context-home">
				<div class="md-layout">
					<div class="md-layout-item md-size-40">
						<h1 class="home-title">Welcome to</h1>
						<h1 class="gv-title">GOVALET</h1>
					</div>	
					<div class="md-layout-item md-size-60 booking-item" @click="searchParking">
						<img :src="itemsImg"/>
					</div>
				</div>

			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			bgImg: require("@/../images/bg.jpg"),
			itemsImg: require("@/../images/items.png")
		};
	},

	methods: {
		searchParking() {
			this.$router.push('/search-parking');
		}
	}
};
</script>

<style lang="scss" scoped>
.section {
	padding: 0;
}
.context-home {
	margin-top: -250px;

	padding-right: 15px;
    padding-left: 15px;
    display: flex; 
    justify-content: space-between;
    width: 70%;
    margin-left: auto;
    margin-right: auto;
    position: relative;
}
.home-title {
	color: #ffffff;
	font-weight: bolder;
	font-size: 72px;
	// font-style: italic;
}

.gv-title {
	color: #ffffff;
    font-weight: bolder;
    font-size: 80px;
    text-shadow: 5px 2px 5px #ad7d7d; 
}
.md-subhead {
	margin-left: 20px;
}

.bg-img {
	background: #ffffff;
}

.booking-item:hover {
	transform: translate3d(0, -20px, 0);
}

.booking-item {
	cursor: pointer;
}
</style>
