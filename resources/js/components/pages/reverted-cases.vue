<template>
<div>
<!-- table card -->
<div class="card">
    <!-- headers -->
    <div class="d-flex justify-content-around">
        <div class=" col-md-3 text-center ml-auto mr-5" id="headingOne">
            <h5 class="mb-0 shadow" style="border:1px solid crimson;">
                <button class="btn" data-toggle="collapse" data-target="#awaiting"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-times-circle text-danger me-1"></i>
                    Reverted Preliminary Report
                <span class=" badge" style="font-size:13px; width:22px !important; height:22px !important;
                background:crimson !important; color:#fff ;  align-items:center; text-align:center;
                position:absolute; border-radius:50%; margin-top:-5px;">
               1
                </span>

                </button>
            </h5>
        </div>

        <div class=" col-md-3 text-center  mr-auto ml-5" id="">
            <h5 class="mb-0 shadow" style="border:1px solid crimson;">
                <button class="btn collapsed" data-toggle="collapse"
                data-target="#Response" aria-expanded="false" aria-controls="#Response">
                 <i class="fa fa-times-circle text-danger fa-1x me-1"></i>
                  Reverted Findings
                <span class=" badge" style="font-size:14px; width:22px !important; height:22px !important;
                background:crimson !important; color:#fff ;  align-items:center; text-align:center;
                position:absolute; border-radius:50%; margin-top:-5px;">
                1</span>
                </button>
            </h5>
        </div>
        <div class=" col-md-3 text-center  mr-auto ml-5" id="">
            <h5 class="mb-0 shadow" style="border:1px solid crimson;">
                <button class="btn collapsed" data-toggle="collapse"
                data-target="#Manual" aria-expanded="false" aria-controls="#Response">
                 <i class="fa fa-times-circle text-danger fa-1x me-1"></i>
                 Reveted Manual Case
                <span class=" badge" style="font-size:14px; width:22px !important; height:22px !important;
                background:crimson !important; color:#fff ;  align-items:center; text-align:center;
                position:absolute; border-radius:50%; margin-top:-5px;">
                1</span>
                </button>
            </h5>
        </div>
        
    </div>
    <!-- headers ends -->
    <div id="accordion" class="col-lg-12 mt-3" style="width:100%">
        <!-- awaiting taxpayer response -->
        <div class="card shadow">
            <div id="awaiting" class="collapse" aria-labelledby="awaiting" data-parent="#accordion">

                <div class="card-header bg-dark text-muted ">
                        <i class="fas fa-times-circle text-danger me-1"></i>
                        Reverted Preliminary Report
                </div>
                <!-- card-header ends -->
                <caseTable :path="path" :username="username" 
                :caseStatus="caseStatus" :action="ApprovedAction" :column="column" />
                <!-- awaiting response table ends -->

            </div>
        </div>
        <!-- awaiting taxpayer response ends-->
        <!--taxpayer responded -->
        <div class="card shadow">
            <div id="Response" class="collapse" aria-labelledby="Response" data-parent="#accordion">
              <div class="card-header bg-dark text-muted text-center">
                    <i class="fas fa-times-circle text-danger fa-1x me-1"></i>
                    Reverted Findings
                </div>
                <!-- card header ends -->
                  <!-- taxpayer responded table -->
                  <caseTable :path="path" :username="username" :caseStatus="caseStatus"
                   :action="ApprovedAction" :column="column" />


                <!-- taxpayer responded table ends -->
            </div>
        </div>
        <!-- taxpayer responded -->
        <!--taxpayer responded -->
        <div class="card shadow">
            <div id="Manual" class="collapse" aria-labelledby="Manual" data-parent="#accordion">
              <div class="card-header bg-dark text-muted text-center">
                    <i class="fas fa-times-circle text-danger fa-1x me-1"></i>
                    Reverted Manual Cases
                </div>
                <!-- card header ends -->
                  <!-- taxpayer responded table -->
                  <caseTable :path="path" :username="username" 
                  :caseStatus="caseStatus" :action="ApprovedAction" :column="column" />


                <!-- taxpayer responded table ends -->
            </div>
        </div>
        <!-- taxpayer responded -->

        

    </div>
</div>

<!-- table card ends-->
</div>
</template>

<script>
import caseTable from './caseTable.vue'

export default {
    props:['path','username','caseStatus','column','ApprovedAction',],
    data(){
        return{
            data:{
                username: this.username,
            },
            casesCompleted:[],
        }
    },
    components: {
        caseTable
    },

   async created(){
         const res = await this.callApi('get',`/api/fetchCompletedCases`)
        //  const res = await this.callApi('get',`/api/getProgress/${[this.column,this.username]}`)

        // if(res.status===200){
        //     this.casesProgress = res.data
        // }
        // else{
        //     this.swr('something went wrong')

        // }
   }

}
</script>