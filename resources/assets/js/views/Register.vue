<template>
	<div class="wrapper">
		<div class="section page-header">
			<div class="container md-layout">
				<div class="md-layout-item md-size-66 md-small-size-100 md-xsmall-size-100 md-medium-size-80 mx-auto">
					<md-card class="md-card-login">
						<md-card-header class="md-card-header-green">
							<h4 class="card-title">SIGN UP</h4>
						</md-card-header>
						<md-card-content>
							<p class="description">Host or Guest Register</p>
							<div class="md-layout">
								<div class="md-layout-item md-size-50 md-small-size-100">								
									<md-field class="md-form-group">
										<md-icon>face</md-icon>
										<label>Name</label>
										<md-input type="email"></md-input>
									</md-field>
									<md-field class="md-form-group">
										<md-icon>email</md-icon>
										<label>Email</label>
										<md-input type="email"></md-input>
									</md-field>
									<md-field class="md-form-group">
										<md-icon>lock_outline</md-icon>
										<label>Password</label>
										<md-input ></md-input>
									</md-field>
									<md-field class="md-form-group">
										<md-icon>check</md-icon>
										<label>Password Confirm</label>
										<md-input ></md-input>
									</md-field>
									<md-field class="md-form-group">
										<md-icon>phone</md-icon>
										<label>Phone Number</label>
										<md-input ></md-input>
									</md-field>
								</div>
								<div class="md-layout-item">
									<div class="picture-container">
										<div class="picture">
											<div v-if="!image">
												<img :src="avatar" class="picture-src" title="">
											</div>
											<div v-else>
												<img :src="image" />
											</div>
											<input type="file" @change="onFileChange">
										</div>
										<h6 class="description">Choose Picture</h6>
									</div>
									<div class="text-center">
										<md-checkbox v-model="array" value="1">I need to register of host</md-checkbox>
									</div>
								</div>
							</div>
						</md-card-content>
						<md-card-actions>
							<md-button class="md-simple md-success">
								register
							</md-button>
						</md-card-actions>
						

					</md-card>
				</div>
			</div>
		</div>
	</div>
	<!-- </div> -->
</template>

<script>
import { WidgetCard } from "@/components";
export default {
	bodyClass: "register-page",
	components: {
		WidgetCard
	},
	data() {
		return {
			image: '',
			array:[]
		};
	},
	props: {
		avatar: {
			type: String,
			default: require("@/../images/default-avatar.png")
		}
	},
	computed: {

	},
	methods: {
		onFileChange(e) {
			var files = e.target.files || e.dataTransfer.files;
			if (!files.length)
			return;
			this.createImage(files[0]);
		},
		createImage(file) {
			var reader = new FileReader();
			var vm = this;

			reader.onload = (e) => {
			vm.image = e.target.result;
			};
			reader.readAsDataURL(file);
		}
	}
};
</script>

<style lang="scss" scoped>

.md-card-header {
	width: fit-content;
	margin-top: -20px;
	padding: 20px;
}
.card-title {
	padding: 0px 20px;
	margin: 0px; 
}

.picture-container {
	margin-top: 50px;
    cursor: pointer;
    position: relative;
    text-align: center;
}
.picture {
    -webkit-transition: all .2s;
    background-color: #999;
    border: 4px solid #ccc;
    border-radius: 50%;
    color: #fff;
    height: 140px;
    margin: 5px auto;
    overflow: hidden;
    transition: all .2s;
    width: 140px;
}

.picture-src {
    width: 100%;
}

.picture input[type=file] {
    cursor: pointer;
    display: block;
    height: 100%;
    left: 0;
    opacity: 0!important;
    position: absolute;
    top: 0;
    width: 100%;
}
</style>
