<template>

    <div id="layoutSidenav" >
          <div id="layoutSidenav_content">
            <div class="container-fluid px-4">
                <main>
                
                    <div class="container">
                        <div class="w3-display-middle">
                            <h1 class="w3-jumbo w3-animate-top w3-center text-uppercase">
                                🚫 Access Denied
                            </h1>
                            <hr class="w3-border-white w3-animate-left" 
                            style="margin:auto;width:50%">
                            <h3 class="w3-center w3-animate-right text-light">You dont have
                                 permission to view this Page.</h3>
                            <h3 class="w3-center w3-animate-zoom mt-2">🚫🚫🚫🚫</h3>
                            <h6 class="w3-center w3-animate-zoom mt-2">error code:403 forbidden</h6>
                          
                        </div>
                    </div>
                </main>
         </div>
    </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            data:{
                username:'',
                password:''
            },
            isLoading:false
            

        }
    },
    created() {
        // console.log(this.store.state.user)
    }
  
    
}
</script>
<style scoped>


    
  
    
.container-fluid{
    background-color: black;
    color: white;
    width: 100%;
    height: 100vh;
    position: relative;


}
h1 {
    color: red !important;
    background:transparent !important;
    }
    
    h6{
    color: red;
    text-decoration: underline;
    }
    



</style>
