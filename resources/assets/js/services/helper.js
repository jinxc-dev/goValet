import store from '../store'
// import router from '../routes'

export default {
    logout(){
        return axios.post('/api/user/logout').then(response => response.data).then(response =>  {
            toastr.success(response.message);
        }).catch(error => {
            this.showDataErrorMsg(error);
        });
    },

    check(){
        return axios.post('/api/user/check').then(response => response.data).then(response =>  {
            
            if(response.authed){
                store.dispatch('setAuthUserDetail', response.user);
                store.dispatch('setAuthStatus');
                // store.dispatch('setPermission',response.permissions);
                // store.dispatch('setDefaultRole',response.default_role);
            } else {                
                store.dispatch('resetAuthUserDetail');
            }

            return response.authed;
        }).catch(error =>{
            console.log(error);
            // store.dispatch('resetAuthUserDetail');
            // store.dispatch('resetConfig');
        });
    },

    authedStatus() {
        console.log(store.getters.getAuthStatus)
        return store.getters.getAuthStatus;
    },

    initUser() {
        store.dispatch('resetAuthUserDetail');
    },
    getUser() {
        return store.getters.getUserProfile;
    }
}