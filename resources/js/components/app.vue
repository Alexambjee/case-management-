<template>
  <div>
    
    <router-view :user="user" :role="this.data.role" />
  </div>
</template>
<script>
export default {
  props:['user'],
    data(){
      return {
          data:{
            role:localStorage.getItem('role'),
            role:'',
          }
        }
  },
  created() {
      const role = localStorage.getItem('role');
      const x = localStorage.getItem("primary-permission")

      this.$store.commit('setUpdatedUser', this.user)
      this.$store.commit('setUserRole', role)
  }
   
}
</script>
