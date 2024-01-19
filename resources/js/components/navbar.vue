<template>
 <!-- <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark"> -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color:#151918">
    
    <!-- Navbar Brand-->
        <div class="" style="margin-right:100px !important;">
            <img src="/images/insight.png" alt="user-image" style="margin-top:30px; margin-left:20px;
            margin-bottom:20px;
            " width="100%" height="50px" />
        </div> 
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 f-s-18" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto  ms-md-0 me-3 my-2 me-lg-4">
        <!-- <li class="nav-item float-right">
               
                <span class="nav-link" style="cursor:pointer" @click="switchRole">
                    <i class="fas fa-history"></i>
                    switch role
                </span>
        </li>
        <li class="nav-item float-right">
            <router-link class="nav-link" :to="`${messagePath}`">
                <i class="fas fa-bell"></i>
                <span class="bg-danger badge " style="margin-top:-24px !important;">
                    {{data.totalMessages}}
                </span>
            </router-link>
        </li> -->
        <li class="nav-item float-right">
                <span class="text-center text-danger nav-link"
                style="cursor:pointer"  @click="confirmModal">
                    <i class="fas fa-power-off"></i>
                </span>
        </li>
       
    </ul>
    <!-- role modal -->
    <!-- role modalends -->
    </nav>
</template>
<script>
export default {
    props:['messagePath'],
    data(){
        return {
            data:{
                totalMessages: '0',
            },

        }
    },
    methods: {
        switchRole() {
            this.warning('switch role is still in development')
        },
        // async logout() {
            // document.cookie.split(";").forEach(function(c) {
            // document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
            // });
            // location.href = `/api/logout`;
        // },
        confirmModal () {
            this.$Modal.confirm({
                title: 'Confirm Logout',
                content: '<p>Are you Sure You want to logout?</p>',
                okText: 'Logout',
                cancelText: 'Cancel',

                loading: true,
                onOk: () => {
                    this.logout()
                    
                    setTimeout(() => {
                        this.$Modal.remove();
                        this.success('logout success');
                    }, 1000);
                }
            });
            }
           
      
    },
   
    async created() {
       
        // const  res = this.callApi('get', `/api/unreadMessages/${this.$store.state.user.USER_NAME}`)
        // if(res.status==200){
        //     this.data.totalMessages = res.data
        // }
       
    }
   
}
            // $(document).ready(function() {
            //         App.init();
            //         TableManageCombine.init();
            //         TableManageRowReorder.init();
            //         TableManageScroller.init();
            //         FormWizardValidation.init();
            //         FormWysihtml5.init();
            //     });

            // // Auto Logout
            // (function() {
            //     const idleDurationSecs = 200;
            //     const redirectUrl = `/api/logout`;
            //     let idleTimeout;
            //             // document.cookie.split(";").forEach(function(c) { 
            //             // document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
            //         // });

            //     const resetIdleTimeout = function() {
            //         if (idleTimeout) clearTimeout(idleTimeout);
                   
            //         // redirect
            //         idleTimeout = setTimeout(() => location.href = redirectUrl, idleDurationSecs * 1000);
            //     };

            //     // Key events for reset time
            //     resetIdleTimeout();
            //     // destroy cookies
               
                
            //     window.onmousemove = resetIdleTimeout;
            //     window.onkeypress = resetIdleTimeout;
            //     window.click = resetIdleTimeout;
            //     window.onclick = resetIdleTimeout;
            //     window.touchstart = resetIdleTimeout;
            //     window.onfocus = resetIdleTimeout;
            //     window.onchange = resetIdleTimeout;
            //     window.onmouseover = resetIdleTimeout;
            //     window.onmouseout = resetIdleTimeout;
            //     window.onmousemove = resetIdleTimeout;
            //     window.onmousedown = resetIdleTimeout;
            //     window.onmouseup = resetIdleTimeout;
            //     window.onkeypress = resetIdleTimeout;
            //     window.onkeydown = resetIdleTimeout;
            //     window.onkeyup = resetIdleTimeout;
            //     window.onsubmit = resetIdleTimeout;
            //     window.onreset = resetIdleTimeout;
            //     window.onselect = resetIdleTimeout;
            //     window.onscroll = resetIdleTimeout;

            // })();



</script>

<style scoped>
img {
 display: block; 
 margin-left: auto; 
 margin-right: auto; 

}
</style>