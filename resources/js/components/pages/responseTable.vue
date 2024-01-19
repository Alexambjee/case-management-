<template>
<div>
<!-- table card -->
    <div class="card">
        <div class="card-body  table-responsive">
    <table  class="table table-striped table-bordered table-hover m-2" style="width:100%">
    <thead>
        <tr>
            <th>CASE ID</th>
            <th>PIN</th>
            <th>TAXPAYER NAME</th>
            <th>ASSESSMENT NUMBER</th>
            <th>OBJECTION AMOUNT</th>
            <th>STATUS</th>
            <th>DATE CONTACTED</th>
            <th>RESPONSE DEADLINE</th>
            <th v-if="action =='View' || action=='Invalidate'">ACTION</th>                                
            <th v-if="action =='Yes'">RESPONDED?</th>                                
        </tr>
    </thead>
        <tbody>
            <tr v-for="(c, i) in Responses" :key="i">
                <td>{{c.CASE_ID}}</td>
                <td>{{c.TAXPAYER_PIN}}</td>
                <td>{{c.TP_NAME}}</td>
                <td>{{c.ASSESSMENT_NUMBER}}</td>
                <td>{{c.OBJECTION_AMOUNT}}</td>
                <td :class="c.STATUS == 7 ?'text-warning': c.STATUS == -3 ?'text-danger' :''">
                {{c.STATUS_NAME}}</td>
                <td>{{moment(c.CONTACTED_ON).format('lll')}}</td>
                <td>{{moment(c.RESPONSE_ON).format('lll')}}</td>
                    <!-- (<span class="text-danger" >{{targetTime1 }} </span> ) -->
                <td v-if="action =='View'">
                <router-link :to="`${path + c.CASE_ID}`">
                    <button class="btn btn-circle btn-success text-white btn-sm "
                        style="display: flex;align-items: center;justify-content: center;gap: 5px;">
                        <i class="fa fa-eye mr-3"></i>
                        {{ action }}
                        </button>
                </router-link>

               
                </td>
                <td v-if="action =='Invalidate'">
                   <button class="btn btn-circle btn-danger text-white btn-sm"
                        style="display: flex;align-items: center;justify-content: center;gap: 5px;"
                        @click="showInformModal(c,i)" :disabled="isLoading">
                        <i class="fa fa-eye mr-3"></i>
                        {{ action }}
                </button>
                </td>
                <td v-if="action =='Yes'">
                <Button type="primary" size="small" 
                @click="submitResponse(c, i)">
                {{ isLoading ?'Please wait...':`Yes` }}
                </Button>
                    
                </td>
            </tr>
        </tbody>
    </table>
    <!-- invalidate modal -->
        <Modal
            v-model="InvalidateModal"
            title="Message Taxpayer"
            :mask-closable="false"
            width="500"
            :styles="{ top: '60px' }"
            :closable="true">
            <!-- new message body -->
            <div class="card">
                <div class="">
                <!-- reason -->
                <div class="form-group mt-2 col-9">
                        <label class="label">Reason for Invalidation
                            <span class="text-danger ml-2">*</span>
                        </label>
                    <div class="">
                       <Select v-model="InvalidateData.reason" placeholder="Select Invalidation reason.." style="width:100%;">
                            <Option  :value="r.SELECT_OPTION_NAME" v-for="(r, i) in reasons" :key="i">{{r.SELECT_OPTION_NAME}}</Option>
                        </Select>
                        <small id="error"></small>
                    </div>
                </div>
                <!-- reason ends-->
                   
                    <!-- time bad option -->
                    <div class="card-body" v-if="InvalidateData.SELECT_OPTION_NAME =='Time bad' ">
                        <form>
                            <div class="form-group d-flex mt-2">
                                <div class="col-3">
                                    <label class="label">To 1
                                        <span class="text-danger ml-2">*</span>
                                    </label>
                                </div>
                                <div class="col-9">
                                    <Input type="email" placeholder="Recipient.." class="input" 
                                    style="color:#ccc !important;" v-model="InvalidateData.taxpayerEmail" id="to" disabled/>
                                    <small id="error"></small>
                                </div>
                            </div>
                            <div class="form-group d-flex mt-2">
                                <div class="col-3">
                                    <label class="label">cc</label>
                                </div>
                                <div class="col-9">
                                    <Input type="email" placeholder="cc.."  v-model="InvalidateData.cc" id="cc"/>
                                </div>
                            </div>
                            

                            <div class="form-group d-flex mt-2">
                                <div class="col-3">
                                    <label class="label"
                                        >Subject
                                        <span class="text-danger ml-2">*</span></label>
                                </div>
                                <div class="col-9">
                                    <Input type="textarea" placeholder="Subject" id="subject"
                                     v-model="InvalidateData.subject" :rows="2" />
                                    <small id="error"></small>
                                </div>
                            </div>

                            <div class="form-group d-flex mt-2">
                                <div class="col-3">
                                    <label class="label">Message
                                        <span class="text-danger ml-2">*</span></label>
                                </div>
                                <div class="col-9">
                                    <Input type="textarea" placeholder="message..." 
                                    :rows="6" id="body" v-model="InvalidateData.body" />oppoo
                                    <small id="error"></small>
                                </div>
                            </div>
                           
                        </form>
                    </div>
                    <!-- time bad option ends-->
                    <!-- not responded -->
                    <div class="card-body" v-if="InvalidateData.SELECT_OPTION_NAME !='Time bad' ">
                        <form>
                            <div class="form-group d-flex mt-2">
                                <div class="col-3">
                                    <label class="label">To
                                        <span class="text-danger ml-2">*</span>
                                    </label>
                                </div>
                                <div class="col-9">
                                    <Input type="email" placeholder="Recipient.." class="input" 
                                    style="color:#ccc !important;" v-model="InvalidateData.taxpayerEmail" id="to" disabled/>
                                    <small id="error"></small>
                                </div>
                            </div>
                            <div class="form-group d-flex mt-2">
                                <div class="col-3">
                                    <label class="label">cc</label>
                                </div>
                                <div class="col-9">
                                    <Input type="email" placeholder="cc.."  v-model="InvalidateData.cc" id="cc"/>
                                </div>
                            </div>
                            

                            <div class="form-group d-flex mt-2">
                                <div class="col-3">
                                    <label class="label"
                                        >Subject
                                        <span class="text-danger ml-2">*</span></label>
                                </div>
                                <div class="col-9">
                                 
                                    <Input type="textarea" placeholder="Subject" disabled class="f-w-bold" :rows="2" v-model="InvalidateData.subject"
                                    id="subject" />
                                    <small id="error"></small>
                                </div>
                            </div>

                            <div class="form-group d-flex mt-2">
                                <div class="col-3">
                                    <label class="label">Message
                                        <span class="text-danger ml-2">*</span></label>
                                </div>
                                <div class="col-9">
                                    <Input type="textarea" placeholder="message..." :rows="12" id="body" v-model="InvalidateData.body" />
                                    <small id="error"></small>
                                </div>
                            </div>
                           
                        </form>
                    </div>
                    <!-- not responded ends-->
                    
                </div>
            </div>
            <!--new  message body  ends-->
            <div slot="footer">
                <Button type="success" :loading="isLoading" @click="invalidate()" size="small">
                     {{ isLoading ?'Please wait...' :'Send' }}</Button>
                <Button type="error" @click="InvalidateModal = false" size="small">Close</Button>
            </div>
        </Modal>
    <!-- invalidate modal ends -->
      </div>
    </div>

<!-- table card ends-->
</div>
</template>

<script>
export default {
    props:['path','username','caseStatus','action','column'],
    data(){
        return{
            data:{
                username:this.$store.state.user.USER_NAME,
            },
            Responses: [],
            editData: {
                caseId: '',
                username:this.$store.state.user.USER_NAME,
            },
            InvalidateModal:false,
            assessment_no:[],
            UserName:this.$store.state.user.USER_NAME,

            InvalidateData: {
                caseId: '',
                body: '',
                subject: '',
                cc:'',
                subject:'',
                username:this.$store.state.user.USER_NAME
            },
            reasons: [],
            Type:'invalidation',
            index: -1,
            isLoading:false,
        }
    },
    methods: {
       
        async submitResponse(c, index) {
            let obj = {
                caseId: c.CASE_ID,
                username:this.$store.state.user.USER_NAME,
            }
            this.index = index
            this.editData = obj

            this.isLoading =true
            const res = await this.callApi('post', '/api/changeResponseStatus', this.editData)
            if (res.status === 200) {
                this.success('Case changed successfully')
                window.location =`${this.path}`
            }
            else {
                this.swr()
            }
            this.isLoading=false
        },
        async invalidate() {
            if(this.InvalidateData.subject =='') return this.error('Subject Is Required')
            if(this.InvalidateData.body=='') return this.error('Message Is Required')
            
            this.isLoading = true
            const res = await this.callApi('post', '/api/invalidateCase', this.InvalidateData)
            if (res.status === 200) {
                this.success('Case Invalidated successfully')
                window.location =`${this.path}`
            }
            else {
                this.swr()
            }
            this.isLoading=false
            
        },
        showInformModal(c, index) {
            let obj = {
                caseId: c.CASE_ID,
                username: this.username,
                taxpayerEmail:c.TP_EMAIL,
                subject:'OBJECTION TO ASSESSMENT NUMBER' + c.ASSESSMENT_NUMBER ,
                body:"Dear Taxpayer, Your Assessment Number: " +c.ASSESSMENT_NUMBER+ " , has been declined due to your failure to provide the requested documents, within the stipulated statutory period of 14 days.Kindly note that the assessment is therefore held and taxes are payerable. Regards,  " +c.OFFICER_PNO+""
            }
            this.index = index
            this.InvalidateData = obj
            this.assessment_no =obj.assessment_no
            this.InvalidateModal=true
        }
     
    },

    async created() {
     
        
        const [res, resReason] = await Promise.all([
            this.callApi('get', `/api/getResponsedCases/${[this.caseStatus, this.$store.state.user.USER_NAME]}`),
            this.callApi('get', `/api/fetchSelectOption/${this.Type}`),

        ])
        if(res.status===200){
            this.Responses = res.data
        }
        else{
            this.swr('something went wrong')

        }
        if(resReason.status===200){
            this.reasons = resReason.data
        }
        else{
            this.swr('something went wrong')

        }
  }

}
</script>