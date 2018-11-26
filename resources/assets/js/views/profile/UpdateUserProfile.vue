<template>
	<div class="wrapper">
		<div class="section page-header">
			<div class="container md-layout">
				<div class="md-layout-item md-size-66 md-small-size-100 md-xsmall-size-100 md-medium-size-80 mx-auto">
					<md-card class="md-card-login">
						<md-card-header class="md-card-header-green title-header">
							<h4 class="card-title">UPDATE PROFILE</h4>
						</md-card-header>
						<md-card-content>
							<form class="md-layout">
								<div class="md-layout-item md-size-50 md-small-size-100">
									<md-field class="md-form-group" :class="[{'md-valid': !errors.has('first_name')},{'md-error': errors.has('first_name')}]">
										<md-icon>face</md-icon>
										<label>First Name*</label>
										<md-input
											v-model="user.first_name"
											data-vv-name="first_name"
											name="first_name"
											v-validate="{required: true, min: 2}"></md-input>
											<md-icon class="error" v-show="errors.has('first_name')">close</md-icon>
											<md-icon class="success" v-show="!errors.has('first_name')">done</md-icon>
									</md-field>
									<md-field class="md-form-group">
										<md-icon></md-icon>
										<label>Last Name</label>
										<md-input
											v-model="user.last_name"
											data-vv-name="last_name"
											name="last_name"></md-input>
									</md-field>

									<md-field class="md-form-group" :class="[{'md-valid': !errors.has('password')},{'md-error': errors.has('password')}]">
										<md-icon>lock_outline</md-icon>
										<label>Input Password</label>
										<md-input
											v-model="password"
											data-vv-name="password"
											name="password"
											type="password"
											v-validate="{required: true, min: 5}"></md-input>
									</md-field>

									<h6>Reset Password</h6>

									<md-field class="md-form-group" :class="[{'md-valid': !errors.has('new_password')},{'md-error': errors.has('new_password')}]">
										<md-icon></md-icon>
										<label>New Password</label>
										<md-input
											v-model="new_password"
											data-vv-name="new_password"
											name="new_password"
											ref="new_password"
											type="password"
											v-validate="{required: false, min: 5}"></md-input>
									</md-field>
									<md-field class="md-form-group" :class="[{'md-valid': !errors.has('pw_confirm')},{'md-error': errors.has('pw_confirm')}]">
										<md-icon></md-icon>
										<label>Confirm Password</label>
										<md-input
											v-model="pw_confirm"
											data-vv-name="pw_confirm"
											name="pw_confirm"
											data-vv-as="new_password"
											type="password"
											v-validate="{confirmed: 'new_password'}"></md-input>
									</md-field>
								</div>
								<div class="md-layout-item">
									<div class="picture-container">
										<div class="picture">
											<div>
												<img :src="user.avatar" class="picture-src" title="">
											</div>
											<input  type="file" @change="onFileChange" name="avatar">
										</div>
										<h6 class="description">Choose Picture</h6>
									</div>
									<div class="text-center">
										<md-checkbox v-model="user.type" true-value="1" false-value="0">I would like to host</md-checkbox>
									</div>
								</div>
							</form>
						</md-card-content>
						<md-card-actions>
							<md-button class="md-danger" to="/profile">
								back
							</md-button>
							<md-button class="md-success" @click="validate">
								Update
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
			user: helper.getUser(),
			isHost: false,
			password: '',
			new_password: '',
			pw_confirm: '',
			avatarName: ""
		};
	},
	mounted() {
		helper.check();
		this.isHost = this.user.type;
		this.avatarName = "";
	},
	computed: {

	},
	methods: {

		getError(fieldName) {
			console.log(fieldName);
			return this.errors.first(fieldName);
		},
		validate() {
            return this.$validator.validateAll().then(res => {
                if (res) {
					this.submit(this.user);
				}
                return res
            })
		},
		
		submit(data) {
			if (this.avatarName === "") {
				this.avatarName = this.user.avatar;
			}

			var formElement = document.querySelector("form");
			var formdata = new FormData(formElement);
			formdata.append('type', this.user.type);
			formdata.append('email', data.email);
			formdata.append('avatarName', this.avatarName);

			axios.post('/api/user/update', formdata, {headers: { 'Content-Type': 'multipart/form-data' }})
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
						toast({type: 'success',title: 'Update successfully'});
						// helper.check();
						this.$router.push('/profile');
					} else {
						this.$swal({
							type: 'error',
							title: 'Update fail',
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
			if (this.avatarName == "") {
				this.avatarName = this.user.avatar;
			}
			// this.user.avatar = files[0];
			this.createImage(files[0]);
		},
		createImage(file) {
			var reader = new FileReader();
			var vm = this;

			reader.onload = (e) => {
				vm.user.avatar = e.target.result;
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
