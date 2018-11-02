<template>
	<div class="section">
		<div class="container">
			<md-card>
				<md-card-header class="md-card-header-green title-header">
					<h4 class="card-title">Booking List</h4>
				</md-card-header>
				<md-card-content>
					<md-table v-model="searched" md-sort="date" md-sort-order="asc" md-fixed-header class="sort-table">
						<md-table-toolbar>
							<div class="md-toolbar-section-start">
								<h4 class="parking-info">{{parkingInfo.name}}</h4>
								<!-- <h5>{{parkingInfo.}}</h5> -->
								<h4 class="parking-info">Spots<small>({{parkingInfo.capacity}})</small></h4>
								<h4 class="parking-info">Rate<small>({{parkingInfo.rate}})</small></h4>
								<h4 class="parking-info">Total<small>({{searched.length}})</small></h4>
							</div>

							<md-field md-clearable class="md-toolbar-section-end" style="margin-left: 20px;">
								<md-input placeholder="Search by plate number..." v-model="search" @input="searchOnTable" />
							</md-field>
						</md-table-toolbar>

						<md-table-empty-state
							md-label="No users found"
							:md-description="`No user found for this '${search}' query. Try a different search term or create a new user.`">
							<md-button class="md-primary md-raised" @click="newUser">Create New User</md-button>
						</md-table-empty-state>

						<md-table-row slot="md-table-row" slot-scope="{ item }">
							<md-table-cell md-label="Date" md-sort-by="date">{{ item.parking_date }}</md-table-cell>
							<md-table-cell md-label="Amount" md-sort-by="amount">$ {{ item.amount}}</md-table-cell>
							<md-table-cell md-label="Name" md-sort-by="name">{{ item.user.first_name }} {{ item.user.last_name}}</md-table-cell>
							<md-table-cell md-label="Plate Number" md-sort-by="plate_number">{{ item.vehicle.plate_number }}</md-table-cell>
							<md-table-cell md-label="Brand" md-sort-by="brand">{{ item.vehicle.brand }}</md-table-cell>
							<md-table-cell md-label="Model" md-sort-by="model">{{ item.vehicle.model }}</md-table-cell>
							<md-table-cell md-label="Image">
								<div style="width: 100px;">
									<img :src="item.vehicle.photo" />
								</div>
							</md-table-cell>
						</md-table-row>
					</md-table>
				</md-card-content>
				<md-card-actions>
					<md-button class="md-success" to="/profile">
						BACK
					</md-button>
				</md-card-actions>
			</md-card>
		</div>
	</div>
</template>
<script>

	const toLower = text => {
		return text.toString().toLowerCase()
	}
	const searchByName = (items, term) => {
		if (term) {			
			return items.filter(item => toLower(item.vehicle.plate_number).includes(toLower(term)))
		}
		return items
	}

export default {
	components: {

	},
	bodyClass: "profile-page",
	data() {
		return {
			id:this.$route.params.id,
			search: null,
			parkingInfo:{},
			searched: [],
			dataList: [], 
		};
	},

	mounted() {
		console.log(this.id);
		axios.get("/api/booking/status/" + this.id)
            .then(response => {                
                if (response.data.status) {
					console.log(response.data.data);
					this.dataList = response.data.data.items;
					this.parkingInfo = response.data.data.parking_info;
					this.searched = this.dataList;
                }
            });
	},
	methods: {
		newUser () {
			window.alert('Noop')
		},
		searchOnTable () {
			this.searched = searchByName(this.dataList, this.search)
		}
    }
};
</script>

<style lang="scss" scoped>
.section {
	padding: 0;
}

.container {
	padding-top: 100px;
}

.md-toolbar.md-theme-default {
	padding-top: 10px;
	color: #555555 !important;
}

.parking-info {
	font-weight: bolder;
	padding-right: 20px;
	text-transform: uppercase;
}


</style>
