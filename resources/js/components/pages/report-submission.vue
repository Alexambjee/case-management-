<template> 
    <!-- report submission -->
    <div class="comments-details">
<!-- <form> -->
        <div class="row d-flex justify-content-between">
    <!-- comment section -->
            <div class=" col-md-8">
                <div class="card " v-if="operation=='submit-report' || operation=='Resubmit-report'">
                <div class="card-header bg-dark  text-muted" 
                        style="text-transform:uppercase; text-align:center; ">
                    REPORT SUBMISSION 
                    </div> 
                    <div class="card-body detail-card ">
                        <!-- comments        -->
                        <div class="row d-flex justify-content-between">
                         <!-- begin case type -->
                            <div class="col-md-6">
                                <div class="form-group mt-1">
                                    <label class="label" for="">Select Case Type <span class="ml-2 text-danger">*</span></label>
                                    <div class="row">
                                    <!-- select options -->
                                    <Select clearable id="option"
                                        style="width: 100%;"  class="input"
                                        placeholder="Select Case Type"  v-model="data.Option">
                                        <Option :value="s.id" v-for="(s, i) in SelectOptions" :key="i" v-if="SelectOptions.length">{{s.SELECT_OPTION_NAME}}</Option>
                                    </Select>
                                    <!-- error -->
                                    <small id="error"></small>

                                    </div>
                                </div>
                            </div>
                            <!-- end case type -->
                             <!-- begin case type -->
                            <div class="col-md-6">
                                <div class="form-group mt-1">
                                    <label class="label" for="">Objection Decision <span class="ml-2 text-danger">*</span></label>
                                    <div class="row">
                                    <!-- select options -->
                                    
                                    <Select clearable id="decision"
                                        style="width: 100%;"  class="input" 
                                        placeholder="Objection Decision..."  v-model="data.Decision" >
                                        <Option :value="d.SELECT_OPTION_NAME" v-for="(d, i) in decisions" :key="i"
                                         v-if="decisions.length">{{d.SELECT_OPTION_NAME}}</Option>
                                    </Select>
                                    <!-- error -->
                                    <small id="error"></small>
                                    </div>
                            <!-- row-->
                            <div class="row">
                                        <!-- begin case type -->
                                <div class="col-md-6" v-if="data.Decision == 'Partially accept'">
                                    <div class="form-group mt-1">
                                        <label class="label" for="">Amount Accepted<span class="ml-2 text-danger">*</span></label>
                                        <div class="row">
                                        <!-- select options -->
                                        <input type="number"  placeholder="Amount accepted...."
                                                    class="input form-control" v-model="calculate"  id="accepted"  :max="Details[0]['OBJECTION_AMOUNT']" 
                                                    :min="0" />
                                        <!-- error -->
                                        <small id="error"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" v-if="data.Decision == 'Partially accept'">
                                    <div class="form-group mt-1">
                                        <label class="label" for="">Objection Amount<span class="ml-2 text-danger">*</span></label>
                                        <div class="row">
                                        <!-- select options -->
                                        <input type="text"  placeholder="objection amount...."
                                         disabled class="input form-control" v-model="Details[0]['OBJECTION_AMOUNT']" />
                                        <!-- error -->
                                        <small id="error"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" v-if="data.Decision == 'Partially accept'">
                                    <div class="form-group mt-1">
                                        <label class="label" for="">Amount Rejected<span class="ml-2 text-danger">*</span></label>
                                        <div class="row">
                                        <!-- select options -->
                                        <input type="text"  placeholder="Amount rejected...."
                                                 disabled class="input form-control" v-model="data.rejected_amount" />
                                        <!-- error -->
                                        <small id="error"></small>
                                        </div>
                                    </div>
                                </div>
                                <!-- end case type -->
                                </div>
                            </div>
                            <!-- end case type -->

                            </div>

                            <!-- row ends -->
                            
                            <!-- begin basis of assessment-->
                                <div class="col-md-6 mr-2">
                                    <div class="form-group  mt-1">
                                        <label class="label" for="">Basis of Assessment <span class="ml-2 text-danger">*</span></label>
                                        <div class="">
                                                <Input type="textarea" :rows="4" placeholder="Enter basis of assessment...."
                                                  class="input" id="basis" v-model="data.assessment_basis" />
                                                <!-- error -->
                                                <small id="error"></small>
                                        </div>
                                    </div>
                                </div>
                                <!-- end basis of assessment -->
                            <!-- begin remarks -->
                                <div class="col-md-6 mr-2">
                                    <div class="form-group  mt-1">
                                        <label class="label" for="">IRO Recommendations <span class="ml-2 text-danger">*</span></label>
                                        <div class="">
                                                <Input type="textarea" :rows="4" placeholder="Enter recommendations/observations...."
                                                class="input" id="recommendation"  v-model="data.iro_recommendation" />
                                                <!-- error -->
                                                <small id="error"></small>
                                        </div>
                                    </div>
                                </div>
                                <!-- end remarks -->
                            <!-- begin remarks -->
                                <div class="col-md-6 mr-2">
                                    <div class="form-group  mt-1">
                                        <label class="label" for="">Ground of Objection <span class="ml-2 text-danger">*</span></label>
                                        <div class="">
                                                <Input type="textarea" :rows="4" placeholder="Enter ground of Objection...."
                                                  class="input"  id="ground" v-model="data.objection_ground" />
                                                <!-- error -->
                                                <small id="error"></small>
                                        </div>
                                    </div>
                                </div>
                                <!-- end remarks -->
                            <!-- begin remarks -->
                                <div class="col-md-6 mr-2">
                                    <div class="form-group  mt-1">
                                        <label class="label" for="">Remarks <span class="ml-2 text-danger">*</span></label>
                                        <div class="">
                                                <Input type="textarea" :rows="4" placeholder="Enter Remarks...."
                                                v-model="data.remarks" id="remarks"  class="input" />
                                                <!-- error -->
                                                <small id="error"></small>
                                        </div>
                                    </div>
                                </div>
                                <!-- end remarks -->
                           
                        
                        </div>
                        <!-- submit -->
                        <div class="text-center mt-3">
                            <Button type="success" size="small" v-if="operation=='submit-report'"
                            @click="submitReport()" :disabled="isLoading" :loading="isLoading"
                            >{{isLoading ?'Submitting Please Wait...' :'Submit'}}</Button>
                            <Button type="success" size="small" :disabled="isLoading" v-if="operation=='Resubmit-report'"
                            @click="ResubmitReport()" :loading="isLoading"
                            >{{isLoading ?'Please Wait...' :'Submit'}}</Button>

                        </div>
                    <!-- submit button ends-->
                        <!-- comments      ends  -->
                    <br>                                                                                         
                    
                    </div>
                </div>
             
               
            </div>
            
          

      <!-- ocomment section ends-->
        <!--attachment section -->
        <div class="col-lg-3 col-md-3">
            <div class="card detail-card">
            <div class="card-header pb-2 bg-dark text-muted text-center">
                    <h5 class="text-muted">ATTACHMENTS</h5>
            </div>
                <div class="card-body">
                       
                    <!-- attachment lists -->
                    <attachments :case_id="case_id" :tPin="data.tpin" />
                    <!-- attachment list ends -->
                     <div class="file-section top-header d-flex justify-content-between" style="box-shadow:0 5px 10px rgba(0,0,0,0.1);">
                        <span class="m-2">
                        <Upload 
                            multiple
                            ref="upload"
                            :on-success="handleSuccess"
                            :headers="{'x-csrf-token' :token,'X-Requested-With':'XMLHttpRequest'}"
                            :on-error="handleError"
                            :format="['pdf','docx']" 
                            :on-format-error="handleFormatError" 
                            :max-size="20048"
                            :on-exceeded-size="handleMaxSize"
                            action="/api/upload" id="fileUpload" class="input">
                            <small id="error"></small>

                            <Button icon="ios-cloud-upload-outline">Upload Report</Button>
                            <small class="text-muted">(.pdf or .docx)</small>
                        </Upload>
                        </span>
                        
                        </div>
                </div>
            </div>
        </div>
        <!-- ocomment section ends-->
        </div>
    
    <!-- </form> -->
</div>
<!-- report submission ends -->


</template>
<script>
import attachments from './attachments.vue'

export default {
    props:['case_id','operation','username','Details'],
    data() {
        return {
              data: {
                Option: '',
                remarks: '',
                filename:'',
                caseId: this.case_id,
                username:this.$store.state.user.USER_NAME,
                Decision:'',
                amount_accepted:'0',
                rejected_amount:'0',
                objection_amount:'',
                assessment_basis:'',
                iro_recommendation:'',
                objection_ground:'',
                decisionType:'decision',
                tpin:''
            },
            Fdata: {
                Option: '',
                remarks: '',
                filename:'',
                caseId: this.case_id,
                username:this.$store.state.user.USER_NAME,
                Decision:'',
                amount_accepted:'0',
                rejected_amount:'0',
                objection_amount:'',
                assessment_basis:'',
                iro_recommendation:'',
                objection_ground:'',
                decisionType:'decision'
            },
            calculate: '',
            caseDetails:[],
           
            decisions:[],
            reasons: [],
            Approvals:[],
            Type: 'case-type',
            SelectOptions: [],
            isLoading: false,
            isFormvalide:false,
            token: '',
            isUploaded:false,
            type_id:[],
            
        }
    },
    components: {
        attachments 
    },
    watch: {
            calculate: function (value) {
                const accepted = document.querySelector('#accepted')
              var accept;
            if (value > parseFloat(this.Details[0]['OBJECTION_AMOUNT']) ){
                // const accepted = document.querySelector('#accepted')
                let pt = accepted.parentNode;
                accepted.classList.add('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = 'Accepted amount cannot exceed objection amount!';
                this.isFormvalide = false
                accept = parseFloat(this.Details[0]['OBJECTION_AMOUNT'])
                this.data.amount_accepted = accept;
                    
            } else {
                accept = parseFloat(value)
                let pt = accepted.parentNode;
                accepted.classList.remove('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = '';
                this.isFormvalide = false
                 this.data.amount_accepted = parseFloat(accept)
            }
            // this.data.amount_accepted = value
            const diff=(parseFloat(this.Details[0]['OBJECTION_AMOUNT']) - accept)
            this.data.rejected_amount = parseFloat(diff).toFixed(2)
                
            }
    },
    methods: {
            
        async submitReport() {
            const option = document.querySelector('#option')
            const remarks = document.querySelector('#remarks')
            const basis = document.querySelector('#basis')

            const recommendation = document.querySelector('#recommendation')
            const ground = document.querySelector('#ground')
            const accepted = document.querySelector('#accepted')
            const decision = document.querySelector('#decision')

            const uploadfile = document.querySelector('#fileUpload')
            // checking casetype
            if (!this.data.Option) {
                let pt = option.parentNode;
                option.classList.add('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = ' case type is required!';
                this.isFormvalide = false

            }else {
                let pt = option.parentNode;
                option.classList.remove('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = '';
                this.isFormvalide = true
                
            }
            // checking remarks
            if (!this.data.remarks) {
                let pt = remarks.parentNode;
                remarks.classList.add('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = 'Remarks is required!';
                this.isFormvalide = false

            }else {
                let pt = remarks.parentNode;
                remarks.classList.remove('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = '';
                this.isFormvalide = true
            }


            // checking basis
            if (!this.data.assessment_basis) {
                let pt = basis.parentNode;
                basis.classList.add('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = 'Assessment basis is required!';
                this.isFormvalide = false

            }else {
                let pt = basis.parentNode;
                basis.classList.remove('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = '';
                this.isFormvalide = true
            }
            // // checking recommendation
            if (!this.data.iro_recommendation) {
                let pt = recommendation.parentNode;
                recommendation.classList.add('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = 'Iro recommendation is required!';
                this.isFormvalide = false

            }else {
                let pt = recommendation.parentNode;
                recommendation.classList.remove('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = '';
                this.isFormvalide = true
            }
            // // checking ground
            if (!this.data.objection_ground) {
                let pt = ground.parentNode;
                ground.classList.add('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = 'Objection ground is required!';
                this.isFormvalide = false

            }else {
                let pt = ground.parentNode;
                ground.classList.remove('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = '';
                this.isFormvalide = true
            }
           
           
            // checking decision
        
            if (!this.data.Decision) {
                let pt = decision.parentNode;
                decision.classList.add('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = 'Objection decision is required!';
                this.isFormvalide = false

            }else {
                let pt = decision.parentNode;
                decision.classList.remove('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = '';
                this.isFormvalide = true
                // console.log(this.data.Decision)
            //     if (this.data.Decision == 'Partially accept' && this.data.amount_accepted =='') {
            //         // check for amount
            //         // if (!this.data.amount_accepted) {
            //         let pt = accepted.parentNode;
            //         accepted.classList.add('invalid');
            //         let msgElem =pt.querySelector("#error");
            //         msgElem.textContent = 'Amount Accepted is required!';
            //         this.isFormvalide = false
            //         this.error('amount is required')

            //         // }

            //     }
            //    else {
            //         let pt = accepted.parentNode;
            //         accepted.classList.remove('invalid');
            //         let msgElem =pt.querySelector("#error");
            //         msgElem.textContent = '';
            //         this.isFormvalide = true
            //         }


            }

           
            // validating file
            // checking for file upload status
            if (this.data.filename.trim() == '') {
                let pt = uploadfile.parentNode;
                uploadfile.classList.add('invalid');
                let msgElem = pt.querySelector("#error");
                msgElem.textContent = 'Kindly upload a report';
                this.isFormvalide = false
                this.isUploaded = false
            }else{
                let pt = uploadfile.parentNode;
                uploadfile.classList.remove('invalid');
                let msgElem = pt.querySelector("#error");
                msgElem.textContent = '';
                this.isFormvalide = true
                this.isUploaded = true
            }
            if(this.isUploaded==true){
                let pt = uploadfile.parentNode;
                uploadfile.classList.remove('invalid');
                let msgElem =pt.querySelector("#error");
                msgElem.textContent = '';
                this.isFormvalide =true

            }
            // submit report when no error exists and file is uploaded
            if (this.isUploaded) {
                this.isLoading = true
                this.data.filename = `${this.data.filename}`;
                const res = await this.callApi('post', '/api/submitReport', this.data)
                if(res.status===200){
                    this.SelectOptions.unshift(res.data)
                    this.success('Report submitted sucessfully to Your Manager for Review.')
                    this.data.filename =''
                    this.data.remarks =''
                    this.data.Option=''
                    window.location='/officer/response-from-taxpayer'
                }
                // else{
                    // if(res.status==422){
                    //     for(let i in res.data.errors){
                    //         this.error(res.data.errors[i][0])
                    //     }
                    // }
                else{
                this.swr('Something Went Wrong!')
                }
                // }

                
                this.isLoading = false
            }
            
            
        },
       
        // forward case decisions
       
     
        handleSuccess(res){
            res = `${res}`
            this.data.filename = res
            this.isUploaded = true
        },
        handleError(file){
            this.$Notice.warning({
                title:'The file format is incorrect!',
                desc:`${file.errors.file.length ? file.errors.file[0] :'Something went wrong!'}`
            })
        },
        handleFormatError(file){
            this.$Notice.warning({
                title:'The file format is incorrect!',
                desc:'File format of ' + file.name + ' is incorrect, please select jpg, jpeg or png.'
            });
        },
        handleMaxSize(file){
            this.$Notice.warning({
                title:'Exceeding file size limit!',
                desc:'File '+file.name + 'is too large, no more than 21MB'
            });
        },
    },
    
    async created() {
        this.token = window.Laravel.csrfToken
        const [res, resType, resDecision,resCase] = await Promise.all([
            this.callApi('get', `/api/fetchSelectOption/${this.Type}`),
            this.callApi('get', `/api/getTypeId/${this.data.caseId}`),
            this.callApi('get', `/api/fetchDecisions/${this.data.decisionType}`),
            this.callApi('get', `/api/fetchDetails/${this.data.caseId}`)
        ])
        if (res.status == 200) {
            this.SelectOptions = res.data
        }
        else {
            this.swr('Something went wrong. Please try again later!')
        }
        if (resType.status == 200) {
            this.type_id = resType.data
            this.data.Option = this.type_id[0]['TYPE_ID']
        }
        else {
            this.swr('Something went wrong. Please try again later!')
        }
        
        // decisions
        if(resDecision.status == 200){
            this.decisions = resDecision.data
        }
        else{
            this.swr('Something went wrong!')
        }
         if (resCase.status == 200) {
            this.caseDetails = resCase.data
            this.data.assessment_basis = this.caseDetails[0]['ASSESSMENT_BASIS']
            this.data.rejected_amount = this.caseDetails[0]['REJECTION_AMOUNT']
            this.data.iro_recommendation = this.caseDetails[0]['IRO_RECOMMENDATION']
            this.data.objection_ground = this.caseDetails[0]['OBJECTION_GROUND']
            this.data.amount_accepted = this.caseDetails[0]['AMOUNT_ACCEPTED']
            this.data.Decision = this.caseDetails[0]['DECISION_NAME']
            this.data.tpin = this.caseDetails[0]['ASSESSMENT_NUMBER']

          
        }
        else {
            this.swr('Something went wrong!')
        }
        // fetch type_id

        
        
        
    }
    

}
</script>
