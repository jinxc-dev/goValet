<template>
	<div class="wrapper">
		<div class="section page-header">
			<div class="container">
				<div class="container">					
						<div class="md-layout-item md-size-66 md-small-size-100 md-xsmall-size-100 md-medium-size-80 mx-auto">
							<widget-card header-color="green">
								<h4 slot="title" class="card-title">Register</h4>
								<p slot="description" class="description">Host or Guest Register</p>

								<md-field class="md-form-group" slot="inputs">
									<md-icon>face</md-icon>
									<label>Name</label>
									<md-input v-model="firstname" type="email"></md-input>
								</md-field>
								<md-field class="md-form-group" slot="inputs">
									<md-icon>email</md-icon>
									<label>Email</label>
									<md-input v-model="email" type="email"></md-input>
								</md-field>
								<md-field class="md-form-group" slot="inputs">
									<md-icon>lock_outline</md-icon>
									<label>Password</label>
									<md-input v-model="password"></md-input>
								</md-field>
								<md-field class="md-form-group" slot="inputs">
									<md-icon>check</md-icon>
									<label>Password Confirm</label>
									<md-input v-model="passwordconfirm"></md-input>
								</md-field>
								<md-field class="md-form-group" slot="inputs">
									<md-icon>phone</md-icon>
									<label>Phone Number</label>
									<md-input v-model="phone"></md-input>
								</md-field>
								<md-button slot="footer" class="md-simple md-success">
									LETS GO
								</md-button>
							</widget-card>
						</div>
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

		};
	},
	props: {

	},
	computed: {

	}
};
</script>

<style lang="scss" scoped>

</style>
