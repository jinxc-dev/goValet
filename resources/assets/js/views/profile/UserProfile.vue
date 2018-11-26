<template>
    <md-card class="profile">
        <div class="avatar">
            <!-- <a href="#pablo"> -->
                <img class="img-raised rounded-circle img-fluid" :src="user.avatar" />
            <!-- </a> -->
        </div>
        <md-card-content>
            <div class="name">
                <h3 class="title">{{user.first_name}}  {{user.last_name}}</h3>
                <!-- <md-divider></md-divider> -->
                <div class="card-content">
                    <div class="md-layout">
                        <div class="md-layout-item md-size-40 ">
                            <h4 class="card-title pull-right">EMAIL</h4>
                        </div>
                        <div class="md-layout-item md-size-60">
                            <h5 class="card-title pull-left">{{user.email}}</h5>
                        </div>
                    </div>
                    <div class="md-layout">
                        <div class="md-layout-item md-size-40 ">
                            <h4 class="card-title pull-right">PHONE</h4>
                        </div>
                        <div class="md-layout-item md-size-60">
                            <h5 class="card-title pull-left">{{user.phone}}</h5>
                        </div>
                    </div>
                </div>            
            </div>
        </md-card-content>
        <md-card-actions>
            <md-button class=" md-success" to="/user_update">Update</md-button>
        </md-card-actions>
    </md-card>
</template>
<script>
    export default {
        data() {
            return {
                user: helper.getUser(),
            };
        },
    }

</script>
<style lang="scss" scoped>

.profile-page .profile img {
    width: 160px;
	height: 160px;
}

</style>