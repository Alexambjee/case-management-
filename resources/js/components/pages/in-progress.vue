<template>
<div>
<!-- table card -->
 <div class="card-body table-responsive">
    <table  class="table table-striped table-bordered table-hover" style="width:100%">
    <thead>
        <tr>
            <th>CASE ID</th>
            <th>TAXPAYER PIN</th>
            <th>TAXPAYER NAME</th>
            <th>ASSESSMENT NUMBER</th>
            <th>OBJECTION AMOUNT</th>
            <th v-if="($store.state.userRole =='Report')">OFFICER</th> 
            <th v-if="($store.state.userRole=='Report' || $store.state.userRole=='report')">MANAGER</th>
            <th v-if="($store.state.userRole=='Report'|| $store.state.userRole=='report' )"> CHIEF MANAGER</th> 
            <th>DATE CREATED</th>
            <th>OBJECTION DATE</th>
            <th>REMINDER COUNT DOWN</th>
            <th>STATUS</th>


            <!-- <th>ACTION</th>                                 -->
        </tr>
    </thead>
        <tbody>
                 <tr v-for="(c, i) in caseProgress" :key="i">

                <td>{{c.CASE_ID}}</td>
                <td>{{c.TAXPAYER_PIN}}</td>
                <td>{{c.TP_NAME}}</td>
                <td>{{c.ASSESSMENT_NUMBER}}</td>
                <td>{{c.OBJECTION_AMOUNT}}</td>
                 <td v-if="($store.state.userRole=='Report')">{{c.OFFICER_PNO}}</td>
                <td v-if="($store.state.userRole=='Report' || $store.state.userRole=='report')">{{c.MANAGER_PNO}}</td>
                <td v-if="($store.state.userRole=='Report'|| $store.state.userRole=='report')">{{c.CM_PNO}}</td>
                <td>{{moment(c.created_at).format('lll')}}</td>
                <td>{{moment(c.DATE_OF_OBJECTION).format('lll')}}</td>
                <!-- <td>{{(moment(String(c.EXPECTED_COMPLETION_DATE)) - moment(String(c.DATE_OF_OBJECTION)))}}</td> -->
                <td>{{c.REMAINDER_DURATION}}</td>
                 <td>{{c.STATUS_NAME}}</td>




               
                <!-- <td>
                <router-link :to="`${path + c.CASE_ID}`">
                    <button class="btn btn-circle btn-success text-white btn-sm "
                        style="display: flex;align-items: center;justify-content: center;gap: 5px;">
                        <i class="fa fa-eye mr-3"></i>
                        View
                        </button>
                </router-link>

               
                </td> -->
                
                
            </tr>
        </tbody>
        <!-- `${c.CASE_ID}`' -->
        </table>

    </div>
<!-- table card ends-->
</div>
</template>

<script>
export default {
    props:['channel','column','username'],
    data(){
        return{
            data:{
                // column: this.column,
                // username: this.username
                // caseStatus:[this.caseStatus]
            },
            caseProgress:[],
        }
    },

//    async created(){
//           const resProgress = await this.callApi('get',`/api/getAdminProgress`)

//         if(resProgress.status===200){
//             this.caseProgress = resProgress.data
//             console.log(resProgress.data)
//         }
//         else{
//             this.swr('something went wrong')

//         }
        
     
//    }
  async created() {
 const res = await this.callApi('get',`/api/fetchInProgress`)
    // status
    if (res.status === 200) {
      this.caseProgress = res.data;
      
    } else {
      this.swr("something went wrong");
    }

  },

}
</script>