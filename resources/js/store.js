import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
    state : {
        user: null,
        userRole:null,
        authenticated:false,
        data: {}
     
        },
        getters:{
            getUserRole(state){
                return state.user.role
            },
        },
        mutations:{
            setUpdatedUser(state, data){
                state.user = {...state.user,...data}
            },
            setUserRole(state, data){
                state.userRole = data
    
            },
            resetFormData(state){
                state.data ={}
            },
            setAuthenticated(state, status) {
                state.authenticated = status
            },

        }

});