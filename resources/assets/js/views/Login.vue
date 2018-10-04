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
								<i class="fab fa-google-plus-g"></i>
							</md-button>
							<md-button slot="buttons" class="md-just-icon md-simple md-white">
								<i class="fab fa-instagram"></i>
							</md-button>
							<p slot="description" class="description">Or Be Classical</p>
							<md-field class="md-form-group" slot="inputs">
								<md-icon>email</md-icon>
								<label>Email...</label>
								<md-input v-model="email" type="email"></md-input>
							</md-field>
							<md-field class="md-form-group" slot="inputs">
								<md-icon>lock_outline</md-icon>
								<label>Password...</label>
								<md-input v-model="password"></md-input>
							</md-field>
							<md-button slot="footer" class="md-simple md-success">
								Log In
							</md-button>
							<md-button slot="footer" to="/register" class="md-simple md-success">
								Register
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
	bodyClass: "login-page",
	data() {
		return {
			email: null,
			password: null
		};
	},
	props: {
	},
	computed: {
	}
};
</script>

<style lang="css">
</style>
