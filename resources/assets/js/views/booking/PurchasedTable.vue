<template>
	<md-table v-model="data" class="table-parking">
		<md-table-row slot="md-table-row" slot-scope="{ item }">
			<md-table-cell md-label="Date" class="td-name booking-date">{{ item.parking_date }}</md-table-cell>
			<md-table-cell >
				<div class="img-container">
					<img :src="item.vehicle.photo" alt="products"/>
				</div>
			</md-table-cell>
			<md-table-cell md-label="Plate Number" class="td-name">{{ item.vehicle.plate_number}}</md-table-cell> 
			<md-table-cell >
				<div class="img-container">
					<img :src="item.parking.image" alt="products"/>
				</div>
			</md-table-cell>
			<md-table-cell md-label="Address">{{ item.parking.address }}</md-table-cell>
			<md-table-cell md-label="Time">{{ item.parking.from_time }} ~ {{ item.parking.to_time }}</md-table-cell>
			<md-table-cell md-label="Amount" class="td-name">$ {{ item.amount }}</md-table-cell>
			<md-table-cell md-label="Action"><md-button class="md-info md-ripple">Cancel</md-button></md-table-cell>
		</md-table-row>
	</md-table>
</template>
<script>
export default {
	name: "purchased-table",
	props: {
		data: {
			type: Array,
			default: []
		}
	}
};
</script>
<style lang="scss" scoped>
.td-name {
	min-width: unset;
}
.booking-date {
	min-width: 150px;
}
</style>
