<template>
    <div >
    <!-- navbar -->
        <Navbar />
        <div id="layoutSidenav">
        <Sidebar/>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">CASE</h1>
                            <div class="breadcrumb mb-4 mt-3">
                                <Breadcrumb>
                                    <BreadcrumbItem to="/reports" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                                    <!-- <BreadcrumbItem  to="#" class="breadcrumb-item"  @click="goBack" >My cases</BreadcrumbItem> -->
                                    <BreadcrumbItem :to="`/reports/progress/${data.caseId}`"  class="breadcrumb-item active">Case Analysisdetails</BreadcrumbItem>
                                    
                                </Breadcrumb>
                            </div>
                    <CaseDetails :case_id="data.caseId" :role="data.role" :Rstatus="data.Rstatus" :stage="data.stage"
                    :Astatus="data.Astatus" :Fstatus="data.Fstatus" :username="data.username" :Path="data.LocPath"
                    :actionTitle="data.actionTitle" />
                    </div>
                </main>
                <Footer></Footer>
            </div>
            </div>
        </div>

    </template>
<script>
import Footer from '../../components/footer.vue'
import Sidebar from '../../components/sidebar.vue'
import Navbar from '../../components/navbar.vue'
import CaseDetails from '../../components/pages/casedetails'

export default {
data(){
    return{
        data:{
            caseId: this.$route.params.caseId,
            Rstatus:'-1',
            Fstatus:'4',
            Astatus: '5',
            stage:'Details',
            LocPath:'/reports',
            actionTitle:'REPORT',
            username:this.$store.state.user.USER_NAME,
            role: this.$store.state.userRole,


        },
    };
},
methods : {
      goBack() {
      this.$router.go(-1);
    },
    },
    components : {
        Footer,
        Sidebar,
        Navbar,
        CaseDetails

    },
    }
</script>
<style scoped>
.breadcrumb-item {
  /* Add your custom styling for inactive breadcrumb item */
  cursor: pointer;
  /* Additional styles */
}
</style>