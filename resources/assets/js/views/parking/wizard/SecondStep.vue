<template>
	<div>
		<h5 class="info-text"> Please park up a Parking Type</h5>
		<div class="md-layout">
			<div class="md-layout-item md-size-50 md-small-size-100">
				<md-field>
					<label>Lot Type</label>
					<md-select v-model="lot_type" >
						<md-option value="1">Commericial</md-option>
						<md-option value="3">House</md-option>
						<md-option value="4">Condo/Apartment</md-option>
						<md-option value="5">Empty Lot</md-option>
					</md-select>
				</md-field>
				<md-field>
					<label>Types</label>
					<md-select v-model="type">
						<md-option value="2">Monthly-24 hours</md-option>
						<md-option value="3">Monthly-Daylight hours only</md-option>
						<md-divider></md-divider>
						<md-option value="4">Daily</md-option>
						<md-divider></md-divider>
						<md-option value="5">Hourly</md-option>
					</md-select>
				</md-field>
				<div class="md-layout">
					<div class="md-layout-item md-size-50">
						<md-field class="md-form-group"> 
							<md-icon>access_time</md-icon>
							<label>From Time(08:30:AM)</label>
							<md-input v-model="from" name="from_time"></md-input>
						</md-field>
					</div>
					<div class="md-layout-item md-size-50">
						<md-field class="md-form-group">
							<md-icon>access_time</md-icon>
							<label>To Time(06:30:PM)</label>
							<md-input v-model="to" name="to_time"></md-input>
						</md-field>
					</div>
				</div>
				<md-field 
					:class="[
						{'md-valid': !errors.has('rate')},
						{'md-error': errors.has('rate')}]">
					<label>Rate</label>
					<span class="md-prefix">$</span>
					<md-input 
						v-model="rate"
						data-vv-name="rate"
						name="rate"
						type="number"
						required
						v-validate="'required|min_value:1'"></md-input>
				</md-field>
			</div>
			<div class="md-layout-item md-size-50 md-small-size-100">
				<md-field
					:class="[
						{'md-valid': !errors.has('parking_spots')},
						{'md-error': errors.has('parking_spots')}]">
					<label>Parking Spots</label>
					<md-input 
						v-model="parking_spots"
						data-vv-name="parking_spots"
						name="parking_spots"
						type="number"
						required
						v-validate="'required|min_value:1'"></md-input>
				</md-field>
				<md-field
					:class="[
						{'md-valid': !errors.has('description')},
						{'md-error': errors.has('description')}]">
					<label>Description</label>
					<md-textarea  
						v-model="description"
						data-vv-name="description"
						name="description"
						required
						v-validate="'required'" rows="6"></md-textarea >
				</md-field>
			</div>
		</div>
	</div>
</template>
<script>
	import {IconCheckbox} from '@/components'
	export default {
		components: {
			IconCheckbox,
		},
		data() {
			return {
				type:4,
				from: '08:30:AM',
				to: '06:30:PM',
				rate:1,
				lot_type: 1,
				parking_spots: 1,
				description: 'description'
			}
		},
		methods: {
			// validate() {
			// 	this.$emit('on-validated', true, this.model)
			// 	return Promise.resolve(true)
			// },
			validate() {
				return this.$validator.validateAll().then(res => {
					if (res) {
						this.$emit('on-validated', res, {'lot_type': this.lot_type, 'type':this.type})
					}
					return res
				})
			},
		}
	}
</script>
<style>
</style>
