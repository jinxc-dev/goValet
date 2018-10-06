<template>
	<div class="wrapper">
		<div class="section">
			<div class="section container">
				<div class="md-layout-item md-size-80 md-small-size-100 md-xsmall-size-100 md-medium-size-80 mx-auto">
					<md-card>
						<h3 class="text-center">Register Vehicle</h3>
						<md-card-content>
							<div class="md-layout">
								<div class="md-layout-item md-size-60 md-small-size-100">
									<div class="pic-container">
										<div class="pic">
											<div v-if="!image">
												<img :src="avatar" class="pic-src" title="">
											</div>
											<div v-else>
												<img :src="image" />
											</div>
											<input type="file" @change="onFileChange">
										</div>
										<h6 class="description">Choose Vehicle Photo</h6>
									</div>
								</div>
								<div class="md-layout-item">								
									<md-field class="md-form-group" >
										<md-icon>perm_media</md-icon>
										<label>Brand</label>
										<md-input v-model="brand"></md-input>
            <md-icon class="error">close</md-icon>
									</md-field>
									<md-field class="md-form-group" >
										<md-icon>directions_car</md-icon>
										<label>Model</label>
										<md-input v-model="model"></md-input>
									</md-field>
									<md-field class="md-form-group" >
										<md-icon>crop_7_5</md-icon>
										<label>Plate Number</label>
										<md-input v-model="plate_number"></md-input>
									</md-field>

									<md-datepicker v-model="expire_date" >
										<label>Expire Date</label>
									</md-datepicker>

								</div>

							</div>
						</md-card-content>

						<md-card-actions>
							<md-button class="md-simple md-danger" to="/vehicle_profile">
								cancel
							</md-button>
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
export default {
	bodyClass: "vehicle-register",
	components: {
		
	},
	data() {
		return {
			image: '',
			brand: 'Kia',
			model: 'Rondo',
			plate_number: 'BEZ2685',
			expire_date: new Date()
		};
	},
	props: {
		avatar: {
			type: String,
			default: require("@/../images/image-empty.jpg")
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

.pic-container {
	// margin-top: 50px;
    cursor: pointer;
    position: relative;
    text-align: center;
}
.pic {
    -webkit-transition: all .2s;
    background-color: #999;
    border: 1px solid #ccc;
    color: #fff;
    // height: 400px;
    margin: 5px auto;
    overflow: hidden;
    transition: all .2s;
    width: 100%;
}

.pic-src {
    width: 100%;
}

.pic input[type=file] {
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
