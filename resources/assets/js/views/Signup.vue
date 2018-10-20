<template>
	<div class="wrapper">
		<div class="section page-header">
			<div class="container md-layout">
				<div class="md-layout-item md-size-66 md-small-size-100 md-xsmall-size-100 md-medium-size-80 mx-auto">
					<md-card class="md-card-login">
						<md-card-header class="md-card-header-green title-header">
							<h4 class="card-title">SIGN UP</h4>
						</md-card-header>
						<md-card-content>
							<div class="md-layout">
								<div class="md-layout-item md-size-50 md-small-size-100">
									<md-field class="md-form-group" v-for="item in inputsConfig" :key="item.name" 
										:class="[
											{'md-valid': !errors.has(item.name)},
											{'md-error': errors.has(item.name)}]">
										<md-icon>{{item.icon}}</md-icon>
										<label v-if=item.vv>{{item.label}}*</label>
										<label v-else>{{item.label}}</label>										
										<md-input 
											v-model="dataModel[item.name]"
											:data-vv-name="item.name"
											:ref="item.ref"
											:data-vv-as="item.as"
											:name="item.name"
											:type="item.type"
											v-validate="item.vv"></md-input>
										<div v-if=item.vv>
											<md-icon class="error" v-show="errors.has(item.name)">close</md-icon>
											<md-icon class="success" v-show="!errors.has(item.name)">done</md-icon>
										</div>
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
											<input  type="file" @change="onFileChange">
										</div>
										<h6 class="description">Choose Picture</h6>
									</div>
									<div class="text-center">
										<md-checkbox v-model="dataModel.isHost" value="1">I would like to host</md-checkbox>
									</div>
								</div>
							</div>
							<div style="padding-left: 20px;">
								<md-checkbox class="md-form-group" v-model="isAgree">
									By checking, you agree to our <a href="/help/Terms and Conditions.pdf">Terms and Conditions</a>.
								</md-checkbox>
							</div>
						</md-card-content>
						<md-card-actions>
							<md-button class="md-success" @click="validate">
								sign up
							</md-button>
						</md-card-actions>
						

					</md-card>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	bodyClass: "register-page",
	data() {
		return {			
			isAgree: true,
			image: '',
			dataModel:{
				first_name: 'Jin',
				last_name: 'ZhenFeng',
				email:'zxhdkdk@126.com',
				password: 'rlawkdgur15814',
				pw_confirm:'rlawkdgur15814',
				phone:'0123456789',
				isHost: false,
				avatar: ''
			},
			inputsConfig: [
				{ 
					icon: 'face', 
					label: 'First Name', 
					name: 'first_name', 
					type:'text', 
					vv: {required: true, min: 2}
				},{ 
					label: 'Last Name', 
					name: 'last_name', 
					type:'text'
				},{ 
					icon: 'email', 
					label: 'Email', 
					name: 'email', 
					type:'email', 					
					vv: {required: true, email:true}
				},{ 
					icon: 'lock_outline', 
					label: 'Password', 
					name: 'password', 
					type:'password', 
					ref: 'password',
					vv: {required: true, min: 5}
				},{ 
					icon: 'check', 
					label: 'Password Confirm', 
					name: 'pw_confirm',

					type:'password', 
					as: 'password',
					vv: {required: true, confirmed: 'password'}
				},{ 
					icon: 'phone', 
					label: 'Phone Number', 
					name: 'phone',
					type:'text', 
					vv: {required: true, min: 7}
				},
			],
      
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
		getError(fieldName) {
			return this.errors.first(fieldName);
		},
		validate() {
            return this.$validator.validateAll().then(res => {
                if (res && this.isAgree) {
					this.submit(this.dataModel);
				}
                return res
            })
		},
		
		submit(data) {
			data.user_type = 0;
			if (data.isHost) {
				data.user_type = 1;
			}

			var formdata = new FormData();
			for (var k in data) {
				formdata.append(k, data[k]);
			}
			axios.post('/api/user/register', formdata, {headers: { 'Content-Type': 'multipart/form-data' }})
				.then(response => {
					console.log(response);
					var res_data = response.data;
					if (res_data.status) {
						var toast = this.$swal.mixin({
							toast: true,
							position:'bottom',
							showConfirmButton: false,
							timer:3000,
						});
						toast({type: 'success',title: 'Sign Up successfully'});
						this.$router.push('/login');
					} else {
						this.$swal({
							type: 'error',
							title: 'Sign up fail',
							text: res_data.message,
							confirmButtonClass: 'md-button md-success',
							buttonsStyling: false
						})
					}
				}).catch(error => {
					console.log(error);
				})

		},
		onFileChange(e) {
			var files = e.target.files || e.dataTransfer.files;
			console.log(files);
			if (!files.length)
				return;
			this.dataModel.avatar = files[0];
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
	},
	watch: {

	}
};
</script>

<style lang="scss" scoped>



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
