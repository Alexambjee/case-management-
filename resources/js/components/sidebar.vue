<template>
    <div id="layoutSidenav_nav">
        <!-- <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion"> -->
        <nav class="sb-sidenav accordion sb-sidenav-dark d-flex flex-column justify-content-between"
            style="background-color:#151918" id="sidenavAccordion">
            <!-- <div  class="sb-sidenav-menu-heading">Dashboard</div> -->
            <div class="nav">
                <router-link v-if="data.role == 'reports'" to="/reports/filtered" class="nav-link">
                    <a class="nav-link d-flex flex-row text-left text-white" href="#" data-bs-target="#collapseLayouts"
                        aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-filter"></i></div>
                        Filter

                    </a>
                </router-link>



                <!-- test pages-->

                <!-- 

                <div class="collapse" id="messages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <router-link to="/initiator" class="nav-link ">
                            <span> Initiator</span>
                        </router-link>
                        <router-link to="/Admin" class="nav-link ">
                            <span>Admin </span>
                        </router-link>
                        <router-link :to="'/department/' + department" class="nav-link">
                            <span>Departments</span>
                        </router-link>
                    </nav>
                </div> -->
                <!-- test pages ends-->

                <!-- Report begins -->



                <div>
                    <!-- <div> -->
                    <!-- <br/>
                        <br/>
                        <a class="nav-link collapsed d-flex flex-row text-left text-white" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Reports
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a> -->
                    <!-- <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <router-link :to="`${progressPath}`" class="nav-link">
                                        <span>Cases Progress</span>
                                </router-link>
                                <router-link to="/"  class="nav-link">
                                        <span>Cases summary</span>
                                </router-link>
                                <router-link :to="`${closedPath}`"  class="nav-link">
                                        <span>Closed Cases</span>
                                </router-link>
                                
                            </nav>
                        </div>
                </div> -->
                    <!-- report ends -->

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <span>{{ $store.state.user.last_name }}</span>
                <br />
                <span>{{ $store.state.userRole }}</span>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    props: ['user', 'messagePath', 'channel', 'manualPath', 'role', 'RolePath', 'progressPath', 'closedPath'],
    data() {
        return {
            // department:this.$route.params.department,
            department: 'library',
            data: {
                // totalMessages:''
                role: this.$store.state.userRole,
                manualTotal: "1"
            }
        }
    },
    created() {
        //console.log(this.$store.state)
        // const  res = this.callApi('get', `/api/unreadMessages/${this.$store.state.user.USER_NAME}`)
        // if(res.status==200){
        //     this.data.totalMessages = res.data
        // }

    }
}
</script>

<style scoped>
.nav {
    /* Set background color to white */
    padding: 50px;
    /* Add padding for spacing */
    display: flexbox;
    /* Use flexbox for vertical alignment */
    flex-direction: column;
    /* Align items vertically */
    align-items: left;
    /* Center items horizontally */
}

.nav-link {
    color: white;
    /* Set text color to white */
    text-decoration: none;
    /* Remove default underline */
    margin: 5px 0;
    /* Add margin for spacing between links */
    font-weight: bold;
    /* Make the text bold */
    font-size: 16px;
    /* Set the desired font size */
}
</style>
