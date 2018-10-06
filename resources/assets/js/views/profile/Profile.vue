<template>
	<div class="wrapper">
		<div class="section page-header" :style="headerStyle"></div>
		<div class="section">
			<div class="container">
				<div class="md-layout">
					<div class="md-layout-item md-size-50 mx-auto">
						<div class="profile">
							<div class="avatar">
								<img :src="img" alt="Circle Image" class="img-raised rounded-circle img-fluid">
							</div>
							<div class="name">
								<h3 class="title">Carla Hortensia</h3>
								<h6>Designer</h6>
							</div>
						</div>
					</div>
				</div>
				<div class="description text-center">
					<p>Test user profile. </p>
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
			tabPane1: [
				{ image: require("@/../images/examples/studio-1.jpg") },
				{ image: require("@/../images/examples/studio-2.jpg") },
				{ image: require("@/../images/examples/studio-4.jpg") },
				{ image: require("@/../images/examples/studio-5.jpg") }
			],
			tabPane2: [
				{ image: require("@/../images/examples/olu-eletu.jpg") },
				{ image: require("@/../images/examples/clem-onojeghuo.jpg") },
				{ image: require("@/../images/examples/cynthia-del-rio.jpg") },
				{ image: require("@/../images/examples/mariya-georgieva.jpg") },
				{ image: require("@/../images/examples/clem-onojegaw.jpg") }
			],
			tabPane3: [
				{ image: require("@/../images/examples/mariya-georgieva.jpg") },
				{ image: require("@/../images/examples/studio-3.jpg") },
				{ image: require("@/../images/examples/clem-onojeghuo.jpg") },
				{ image: require("@/../images/examples/olu-eletu.jpg") },
				{ image: require("@/../images/examples/studio-1.jpg") }
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

.profile-tabs /deep/ {
	.md-card-tabs .md-list {
		justify-content: center;
	}

	[class*="tab-pane-"] {
		margin-top: 3.213rem;
		padding-bottom: 50px;

		img {
			margin-bottom: 2.142rem;
		}
	}
}
</style>
