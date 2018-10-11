<template>
	<div class="wrapper">
		<div class="section page-header header-filter">
			<div class="container">
				<div class="md-layout">
					<div class="md-layout-item md-size-33 md-small-size-66 md-xsmall-size-100 md-medium-size-40 mx-auto">
						<login-card header-color="green">
							<h4 slot="title" class="card-title">Login</h4>
							<md-button slot="buttons" class="md-just-icon md-simple md-white">
								<i class="fab fa-facebook-square"></i>
							</md-button>
							<md-button slot="buttons" class="md-just-icon md-simple md-white">
								<a href="/auth/instagram">
								<i class="fab fa-google-plus-g"></i>
								</a>
							</md-button>
							<md-button slot="buttons" class="md-just-icon md-simple md-white">
								<a href="/auth/instagram">
									<i class="fab fa-instagram"></i>
								</a>
							</md-button>
							<p slot="description" class="description">Or Be Classical</p>
							<md-field class="md-form-group" slot="inputs"
								:class="[
									{'md-valid': !errors.has('email')  && touched.email},
									{'md-error': errors.has('email')}]">
								<md-icon>lock_outline</md-icon>
								<label>Email</label>
								<md-input 
									v-model="email"
									data-vv-name="email"
									required
									name="email"
									v-validate="{required: true, email:true}"></md-input>
								<md-icon class="error" v-show="errors.has('email')">close</md-icon>
								<md-icon class="success" v-show="!errors.has('email') && touched.email">done</md-icon>
							</md-field>

							<md-field class="md-form-group" slot="inputs"
								:class="[
									{'md-valid': !errors.has('password')  && touched.password},
									{'md-error': errors.has('password')}]">
								<md-icon>lock_outline</md-icon>
								<label>Password</label>
								<md-input 
									v-model="password"
									data-vv-name="password"
									required
									name="password"
									type="password"
									v-validate="'required'"></md-input>
							</md-field>
							<md-button slot="footer" class="md-simple md-success" @click="validate">
								Log In
							</md-button>
							<md-button slot="footer" to="/signup" class="md-simple md-success">
								Sign Up
							</md-button>
						</login-card>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { LoginCard } from "@/components";

export default {
	components: {
		LoginCard
	},
	data() {
		return {
			email:'zxhdkdk@126.com',// null,
			password: 'rlawkdgur15814', // null,
		    touched: {
				email: false,
				password: false
			},
		};
	},
	methods: {
		validate () {
			this.$validator.validateAll().then(isValid => {
				if (isValid) {
					this.loginAction();
				}
			})
			this.touched.email = true
			this.touched.password = true
		},

		loginAction() {
			var data = {
				email: this.email,
				password: this.password
			}
			axios.post('/api/user/login', data)
				.then(response => {
					helper.check();
					if (response.data.authed) {
						this.$router.push('/');					
					} else {
						console.log('faile');
					}
				}).catch(error => {
					console.log(error);
				});
		},
	},
	watch: {
        email () {
            this.touched.email = true
        },
        password() {
            this.touched.password = true;
        },
    }
};
</script>

<style lang="css">
</style>
