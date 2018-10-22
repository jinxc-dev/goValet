<template>
    <md-card class="profile">
        <div class="avatar">
            <!-- <a href="#pablo"> -->
                <img class="img-raised rounded-circle img-fluid" :src="user.avatar" />
            <!-- </a> -->
        </div>
        <md-card-content>
            <div class="name">
                <h2 class="title">{{user.first_name}}  {{user.last_name}}</h2>
                <!-- <md-divider></md-divider> -->
                <div class="card-content">
                    <h4 class="card-title">Email <small>{{user.email}}</small></h4>
                    <h4 class="card-title">Phone <small>{{user.phone}}</small></h4>
                </div>            
            </div>
        </md-card-content>
        <md-card-actions>
            <md-button class=" md-success">Update</md-button>
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
<style>
</style>