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
									<md-field class="md-form-group" 
										:class="[
											{'md-valid': !errors.has('brand') && touched.brand},
											{'md-error': errors.has('brand')}]">
										<md-icon>perm_media</md-icon>
										<label>Brand</label>
										<md-input 
											v-model="brand"
											data-vv-name="brand"
											name="brand"
											required
											v-validate="'required'"></md-input>
										<md-icon class="error" v-show="errors.has('brand')">close</md-icon>
										<md-icon class="success" v-show="!errors.has('brand') && touched.brand">done</md-icon>
									</md-field>
									<md-field class="md-form-group" 
										:class="[
											{'md-valid': !errors.has('model') && touched.model},
											{'md-error': errors.has('model')}]">
										<md-icon>directions_car</md-icon>
										<label>Model</label>
										<md-input 
											v-model="model"
											data-vv-name="model"
											name="model"
											required
											v-validate="'required'"></md-input>
										<md-icon class="error" v-show="errors.has('model')">close</md-icon>
										<md-icon class="success" v-show="!errors.has('model') && touched.model">done</md-icon>
									</md-field>
									<md-field class="md-form-group" 
										:class="[
											{'md-valid': !errors.has('plate_number') && touched.plate_number},
											{'md-error': errors.has('plate_number')}]">
										<md-icon>crop_7_5</md-icon>
										<label>Plate Number</label>
										<md-input 
											v-model="plate_number"
											required
											data-vv-name="plate_number"
											name="plate_number"
											v-validate="'required'"></md-input>
										<md-icon class="error" v-show="errors.has('plate_number')">close</md-icon>
										<md-icon class="success" v-show="!errors.has('plate_number') && touched.plate_number">done</md-icon>
									</md-field>
									<md-datepicker v-model="expire_date" format="yyyy-mm-dd">
										<label>Expire Date</label>
									</md-datepicker>

								</div>

							</div>
						</md-card-content>

						<md-card-actions>
							<md-button class="md-simple md-danger" to="/profile">
								cancel
							</md-button>
							<md-button class="md-simple md-success" @click="validate">
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
			brand: '',
			model: '',
			plate_number: '',
			expire_date: new Date(),
			photo: '',

			touched: {
				brand: false,
				model: false
			}
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
	watch: {
		brand() {
			this.touched.brand = true;
		},
		model() {
			this.touched.model = true
		},
		plate_number() {
			this.touched.plate_number = true;
		}
	},
	methods: {
		onFileChange(e) {
			var files = e.target.files || e.dataTransfer.files;
			if (!files.length)
				return;
			this.photo = files[0];
			this.createImage(files[0]);
		},
		createImage(file) {
			var reader = new FileReader();
			var vm = this;
			reader.onload = (e) => {
				vm.image = e.target.result;
			};
			reader.readAsDataURL(file);
		},
		validate() {
			return this.$validator.validateAll().then(res => {
				if (res)
					this.submit();
				return res
			})
		},

		submit() {
			var formData = new FormData();
			formData.append('brand', this.brand);
			formData.append('model', this.model);
			formData.append('plate_number', this.plate_number);
			formData.append('expire_date', this.expire_date.toISOString().substring(0, 10));
			formData.append('photo', this.photo);

			if (this.photo == '') {
				return;
			}

			axios.post('/api/vehicle/register', formData, {headers: { 'Content-Type': 'multipart/form-data' }})
				.then(response => {
					var r_data = response.data;
					console.log(r_data);
					if (r_data.status == true) {
						this.$router.push('/profile');
						this.$swal({
							position: 'top-end',
							type: 'success',
							title: 'Your vehicle has been deleted',
							showConfirmButton: false,
							timer: 1000
						})
					} else {
						this.$swal({
							type: 'error',
							title: 'Register is failed.',
							text: r_data.message,
							confirmButtonClass: 'md-button md-success',
							buttonsStyling: false
						})
					}
				}).catch(error => {
					console.log(error);
				})
		}
	},


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


</style>
