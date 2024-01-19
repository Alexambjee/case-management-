<template>
<div>
    <div class="card">
        <!-- headers -->
        <div class="d-flex justify-content-around">
            <div class=" col-md-3 text-center ml-auto mr-5" id="headingOne">
                <h5 class="mb-0 shadow" style="border:1px solid orange;">
                    <button class="btn" data-toggle="collapse" data-target="#awaiting"
                    aria-expanded="true" aria-controls="collapseOne">
                    <i class="fas fa-refresh text-warning me-1"></i>
                        Pending Requests
                    <span class=" badge" style="font-size:13px; width:22px !important; height:22px !important;
                    background:orange !important; color:#fff ;  align-items:center; text-align:center;
                    position:absolute; border-radius:50%; margin-top:-5px;">
                   1
                    </span>
    
                    </button>
                </h5>
            </div>
    
            <div class=" col-md-3 text-center  mr-auto ml-5" id="">
                <h5 class="mb-0 shadow" style="border:1px solid skyblue;">
                    <button class="btn collapsed" data-toggle="collapse"
                    data-target="#Response" aria-expanded="false" aria-controls="#Response">
                     <i class="fa fa-check-circle text-success fa-1x me-1"></i>
                      Approved Requests
                    <span class=" badge" style="font-size:14px; width:22px !important; height:22px !important;
                    background:skyblue !important; color:#fff ;  align-items:center; text-align:center;
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
                     Rejected Requests
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
    
                    <div class="card-header bg-dark text-muted d-flex justify-content-between">
                        <span>
                            <i class="fas fa-refresh text-warning me-1"></i>
                            Pending Requests
                           </span>
                          <span class="text-right"> <Button type="info" ghost 
                            @click="requestModal = true">Request</Button></span>
                           
                    </div>
                    <!-- card-header ends -->
                    <roleTable :path="path" :username="username" 
                    :caseStatus="pendingStatus" :approveAction="approveAction" :column="column" :role="role" :rejectAction="rejectAction" />
                    <!-- awaiting response table ends -->
    
                </div>
            </div>
            <!-- awaiting taxpayer response ends-->
            <!--taxpayer responded -->
            <div class="card shadow">
                <div id="Response" class="collapse" aria-labelledby="Response" data-parent="#accordion">
                  <div class="card-header bg-dark text-muted  ">
                        <i class="fas fa-check-circle text-success fa-1x me-1"></i>
                       Approved Requests
                    </div>
                    <!-- card header ends -->
                      <!-- taxpayer responded table -->
                      <roleTable :path="path" :username="username" :caseStatus="approvedStatus"
                       :column="column" :role="role" />
    
    
                    <!-- taxpayer responded table ends -->
                </div>
            </div>
            <!-- taxpayer responded -->
            <!--taxpayer responded -->
            <div class="card shadow">
                <div id="Manual" class="collapse" aria-labelledby="Manual" data-parent="#accordion">
                  <div class="card-header bg-dark text-muted text-center">
                        <i class="fas fa-times-circle text-danger fa-1x me-1"></i>
                        Reverted Requests
                    </div>
                    <!-- card header ends -->
                      <!-- taxpayer responded table -->
                      <roleTable :path="path" :username="username" 
                      :caseStatus="rejectedStatus"  :column="column" :role="role" />
    
    
                    <!-- taxpayer responded table ends -->
                </div>
            </div>
            <!-- taxpayer responded -->
    
            
    
        </div>
    </div>
    

    <!-- request modal -->
    <Modal
    title="Request Temporal Role Change"
    :mask-closable="false"
    v-model="requestModal" 
    width="700px"
    >
    <div class="card-body">
     <form>
         <div class="form-content">
             <div class="form-group d-flex">
                 <div class="col-3">
                     <label class="label">Assign To <span class="ml-2 text-danger">*</span></label>
                 </div>
                 <div class="col-8 text-muted" >
                    <Select clearable filterable  v-model="data.obligation" 
                    placeholder="select account manager...">
                        <Option value="K00123321"> K00123321</Option>
                        <Option value="K0003322">K0003322</Option>
                    </Select>
                 </div>
             </div>
             <div class="form-group d-flex ">
                 <div class="col-3">
                     <label class="label">Start Date <span class="ml-2 text-danger">*</span></label>
                 </div>
                 <div class="col-8">
                   <DatePicker type="date" v-model="data.period" clearable
                   :options="preventedDate"
                 
                    style="width:100%" placeholder="select period...."
                   ></DatePicker>
                 </div>
             </div>
             <div class="form-group d-flex ">
                 <div class="col-3">
                     <label class="label">End Date <span class="ml-2 text-danger">*</span></label>
                 </div>
                 <div class="col-8">
                   <DatePicker type="date" v-model="data.period2" clearable
                   :options="preventedDate"
                    style="width:100%" placeholder="select period...."
                   ></DatePicker>
                 </div>
             </div>
             <div class="form-group d-flex">
                 <div class="col-3">
                     <label class="label">Reason<span class="ml-3 text-danger">*</span></label>
                 </div>
                 <div class="col-8">
                     <Select clearable  filterable  v-model="data.obligation" 
                     style="width:100%"  placeholder="select reason...">
                         <Option value="Maternity Leave"> Maternity Leave</Option>
                         <Option value="On Sick Leave">On Sick Leave</Option>
                         <Option value="Other">Other</Option>
                     </Select>
                 </div>
             </div>
           
             <div class="form-group d-flex mt-2">
                 <div class="col-3">
                     <label class="label">Remarks <span class="ml-2 text-muted">(optional)</span></label>
                 </div>
                 <div class="col-8" style="text-align:justify;">
                 <Input type="textarea" placeholder="Enter Remarks...."
                 :rows="6"  class="input"
                 v-model="data.remark"
                 maxlength="200" minlength="5" show-word-limit />

                 </div>


             </div>
            
         </div>
         <!-- content form ends-->
        </form>
       
    </div>
    <div slot="footer">
        <Button type="error" ghost  size="medium" @click="requestModal = false" >Cancel</Button>
        <Button type="info" size="medium"
         @click="contactTaxpayer()" :loading="isLoading">
         {{ isLoading ?'Please wait...' :'Submit' }}
         </Button>
    </div>
</Modal>
    <!-- request modal ends -->
</div>
</template>

<script>
import roleTable from './roleTable.vue'
export default {
    props:['path','username','role','approveAction','approvedStatus','rejectedStatus','pendingStatus','rejectAction','column'],
    data(){
        return {
            data: {
                obligation:'',
            },
            
            // disable past dates
            preventedDate: {
                    disabledDate (date) {
                        return date && date.valueOf() < Date.now() - 86400000;
                    }
                },

            requestModal:false,
            casesCompleted:[],
        }
    },
    components: {
        roleTable
    },


   async created(){
        //  const res = await this.callApi('get',`/api/getAdminProgress`)
        // //  const res = await this.callApi('get',`/api/getProgress/${[this.column,this.username]}`)

        // if(res.status===200){
        //     this.casesProgress = res.data
        // }
        // else{
        //     this.swr('something went wrong')

        // }
   }

}
</script>gg