<template>
    <!-- case details component -->
        <div class="card shadow mb-4">
    
                <div class="card-body">
    
                <casedefault :stage="stage" />
                 <div class="comments-details" v-if="stage != 'prelim'">
                    <div class="row">
                    <!-- comments -->
                        <div class="col-lg-6 col-md-12">
                            <comments :case_id="data.caseId"/>
                        </div>
                    <!-- comments ends -->
                    <!--taxpayer response -->
                        <div class="col-lg-6 col-md-12">
                            <TaxpayerResponse :case_id="data.caseId"/>
                        </div>
                    <!--taxpayer response ends -->
                    </div>
                </div>
                <!-- comments & attachment section -->
                <div class="comments-details">
                    <!-- <form> -->
                        <div class="row d-flex justify-content-between">
                        <!-- comment section -->
                        <!-- action section -->
                        <div class="col-md-8">
                            <div class="card ">
                            <div class="card-header bg-dark  text-muted"
                                    style="text-transform:uppercase; text-align:center; ">
                                  {{ actionTitle }}
                                </div>
                                <!-- actions -->
                                <div class="card-body detail-card" >
                                <br>
                                    <div class="row">
                                        <!-- prelim -->
                                        <div class="col-md-12" v-if="stage =='prelim'">
                                        <!-- cm actions -->
                                            <div>
                                            <!-- seletions -->
                                            <div class="form-group ml-2 f-s-13">
                                                <label class="mb-3 label">Recommendation <span class="text-danger">*</span></label>
                                                    <Select v-model="data.Recommendation" style="width:100%" placeholder="Select Recommendation...">
                                                        <Option value="Proceed with Case">Proceed with Case</Option>
                                                        <Option value="Close Case">Close Case</Option>
                                                    </Select>
                                            </div>
                                        <!-- seletions ends-->
                                                <!-- approve -->
                                                <div class="card" v-if="data.Recommendation=='Proceed with Case' || data.Recommendation=='Close Case'">
                                                    <div class="card-body">
                                                        <Space direction="vertical" size="large" >
                                                            <RadioGroup v-model="Choice">
                                                                <Radio label="periods">
                                                                    <span class="label">Select Periods</span>
                                                                </Radio>
                                                                <Radio label="others">
                                                                    <span class="label">Others</span>
                                                                </Radio>
                                                            </RadioGroup>
                                                        </Space>
                                                    <!-- select periods -->
                                                        <div v-if="Choice == 'periods'">
                                                        <!-- select test -->
                                                        <Form ref="formDynamic1" :model="formDynamic1"  style="width: 100%"
                                                        label-position="center" :label-width="100"
                                                        >
                                                            <!-- <div class="card shadow"> -->
    
                                                            
                                                            <template v-for="(item, index) in formDynamic1.items">
                                                                <!-- :label="'Period ' + item.index" -->
                                                              <!-- :rules="{required: true, message: 'Amount ' + item.index +' can not be empty', trigger: 'blur'}" -->
                                                                
    
                                                                
                                                                <div class="card shadow">
    
                                                              <FormItem
    
                                                                      v-if="item.status"
                                                                      :key="index"
                                                                      :label="'Period ' + item.index"
                                                                      :prop="'items.' + index + '.Amount'"
                                                                      :rules="{required: true, message: 'Amount ' + item.index +' can not be empty', trigger: 'blur'}"
                                                                      >
                                                                      <!-- <Row> -->
                                                                        <!-- <Col flex="4"> -->
                                                                            <!-- row -->
                                                                            <div class="m-5">
                                                                                <div class="row mb-4">
    
                                                                            <div class="form-group col-7">
                                                                                <label class="label">Tax Head <span class="text-danger ml-2">*</span></label>
                                                                                <Select v-model="item.TaxHead" style="width:100%" placeholder="Select Tax head...">
                                                                                    <Option 
                                                                                    :value="head.option" v-for="(head, i) in TaxHeadInfo" :key="i"
                                                                                    >{{head.option}}</Option>
                                                                                   
                                                                                </Select>
                                                                            </div>
                                                                            <div class="form-group col-5">
                                                                                <label class="label">Amount <span class="text-danger ml-2">*</span></label>
                                                                                <Input v-model="item.Amount" type="text" placeholder="Enter Amount..."/>
                                                                                <!-- <InputNumber :max="100999900" type="number" :min="1" style="width:100%"
                                                                                placeholder="Enter Amount..." v-model="item.Amount" /> -->
    
                                                                            </div>
                                                                            <div class="form-group col-4">
                                                                                <label class="label">Month <span class="text-danger ml-2">*</span></label>
                                                                                <Select v-model="item.month" 
                                                                                 placeholder="Select Month..." required="false">
                                                                                    <Option :value="m.Month" v-for="(m, i) in MonthRegister" :key="i">{{m.Month}}</Option>
                                                                                </Select>
    
                                                                            </div>
                                                                            <div class="form-group col-4">
                                                                                <label class="label">Year <span class="text-danger ml-2">*</span></label>
                                                                                <DatePicker v-model="item.Year" type="year" placeholder="Select Year..."/>
    
                                                                            </div>
                                                                            
                                                                            <div class="form-group col-3 " v-if="item.index !='1'">
                                                                                <label class="label">Delete Option</label>
                                                                                <Button @click="handleRemove1(index)" ghost type="error">Delete</Button>
                                                                            </div>
                                                                        </div>
                                                                        <!-- </Col> -->
                                                                        <!-- <Col flex="1"> -->
                                                                            <!-- <Row>
                                                                         
                                                                              
                                                                              <Col span="8" offset="3">
                                                                                  <Button @click="handleRemove1(index)">Delete</Button>
                                                                              </Col>
                                                                            </Row> -->
                                                                        </div>
                                                                            <!-- row ends -->
                                                                        <!-- </Col> -->
                                                                    <!-- </Row> -->
                                                                     
                                                              </FormItem>
                                                            </div>
                                                            </template>
                                                        <!-- </div> -->
                                                            <FormItem>
                                                                <Row>
                                                                    <!-- <Col span="12">
                                                                        <Button type="dashed" long @click="handleAdd" icon="md-add">Add item</Button>
                                                                    </Col> -->
                                                                    <Col span="8"  offset="3">
                                                                        <Button type="dashed"  @click="handleAdd1('formDynamic1')" icon="md-add">Add</Button>
                                                                    </Col>
                                                                    <Col span="8"  offset="3">
                                                                        <Button @click="handleReset1('formDynamic1')" style="margin-left: 8px">Reset</Button>
                                                                    </Col>
    
                                                                </Row>
                                                            </FormItem>
                                                            <!-- <FormItem>
                                                                <Button type="primary" @click="handleSubmit1('formDynamic1')">Submit</Button>
                                                            </FormItem> -->
                                                        </Form>
                                                        <!-- more entry -->
                                                        <div class="card shadow">
                                                            <div class="card-body ">
                                                                <div class="form-group ml-2 d-flex align-items-center mt-2 justify-content-between">
                                                                    <label class="label mr-5">Total </label>
                                                                    <Input disabled type="text" v-model="data.total" />
    
                                                                </div>
                                                                
                                                                <div class="form-group ml-2 d-flex align-items-center mt-2">
                                                                    <label class="label">Reason <span class="text-danger ml-2">*</span></label>
                                                                    <Select v-model="data.Reason" style="width:100%" placeholder="Select Recommendation...">
                                                                        <Option :value="p.option" v-for="(p, i) in ProceedReasons"
                                                                :key="i">{{p.option}}</Option>
                                                                    </Select>
    
                                                                </div>
                                                                <div class="form-group ml-2 d-flex align-items-center mt-2">
                                                                    <label class="mb-3 label mb-2">Remarks <span class="text-danger ml-2">*</span></label>
                                                                    <Input v-model="data.Remarks" placeholder="Enter Remarks" type="textarea"
                                                                    :Row="10" :col="6" />
                                                                    
                                                                </div>
                                                                
                                                                <!-- attachment addition -->
                                                               
                                                                <!-- attachment addition ends -->
    
                                                            </div>
    
                                                        </div>
                                                        <div class="form-group text-center mt-5">
                                                            <Space wrap>
                                                                <Col span="8"  offset="7">
                                                                    <Button type="primary" size="medium"
                                                                    @click="handleSubmit1('formDynamic1')">Submit</Button>
                                                                </Col>
                                                                
                                                            </Space>
                                                            
                                                        </div>
                                                        <!-- more entry ends -->
                                                        <!-- select test ends -->
                                                    </div>
                                                    <!--select periods ends -->
                                                     <!-- others -->
                                                     <div v-if="Choice == 'others'">
                                                        <div class="form-group ml-2 d-flex align-items-center mt-2">
                                                            <label class="mb-3 label mb-2">Reason <span class="text-danger ml-2">*</span></label>
                                                            <Select v-model="data.Reason" style="width:100%" placeholder="Select Recommendation...">
                                                                <Option :value="r.option" v-for="(r, i) in ClosureReasons"
                                                                :key="i">{{r.option}}</Option>
                                                            </Select>
    
                                                        </div>
                                                        <div class="form-group ml-2 d-flex align-items-center mt-2">
                                                            <label class="mb-3 label mb-2">Remarks <span class="text-danger ml-2">*</span></label>
                                                            <Input v-model="data.Remarks" placeholder="Enter Remarks" type="textarea"
                                                            :Row="10" :col="6" />
                                                            
                                                        </div>
                                                        <div class="form-group ml-2 mt-2 text-center">
                                                            <Button type="success" size="small"
                                                            :disabled="isLoading" :loading="isLoading"
                                                            @click="aprrove()">{{isLoading ?'Please wait...' :'Submit'}}
                                                            </Button>
                                                        </div>
    
                                                        <!-- test -->
                                                     
                                                        <!-- test ends -->
                                                    </div>
                                                <!--others ends -->
                                                    </div>
                                                   
                                                    <!-- </div> -->
                                                </div>
                                                <!-- approve ends -->
    
                                                <!-- reject -->
                                               
                                            <!-- reject ends -->
    
                                            </div>
                                        <!-- cm actions ends-->
    
    
    <!-- || casetype =='Technical above 10 million' -->
                                        <!-- forward to cm -->
                                        
    
                                        <!-- reject ends -->
    
                                        </div>
                                        <!-- prelim ends -->
                                        <!-- Decision stages -->
                                        <div class="col-md-12" v-if="stage =='Decision'">
                                            approve  & reject designs
                                        </div>
                                        <!-- Decision stages ends -->
                                        <!-- Taxpayer contact stage-->
                                        <div class="col-md-12" v-if="stage =='TaxpayerContact'">
                                            <form>
                                                <div class="form-content">
                                                    <div class="form-group d-flex  mt-3">
                                                        <div class="col-3">
                                                            <label class="label">Taxpayer Email <span class="ml-2 text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-8 text-muted" >
                                                            <Input placeholder="Taxpayer email...." class="input"
                                                            type="email" style="color:#ccc !important; font-weight:bold !important;
                                                            text-transform: lowercase !important;"
                                                            v-model="data.taxpayerEmail" id="temail" disabled />
                                                             <small id="error"></small>
                                                        </div>
                                                    </div>
                                                    <div class="form-group d-flex ">
                                                        <div class="col-3">
                                                            <label class="label">CC </label>
                                                        </div>
                                                        <div class="col-8">
                                                            <Input placeholder="CC email...." id="cc"  type="email" v-model="data.cc" />
                                                             <small id="error"></small>
    
                                                        </div>
                                                    </div>
                                                    <div class="form-group d-flex">
                                                        <div class="col-3">
                                                            <label class="label">Subject <span class="ml-2 text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-8">
                                                            <Input placeholder="Subject.." disabled
                                                             type="textarea" :rows="2" v-model="data.subject" class="input" id="subject"   />
                                                             <small id="error"></small>
                                                        </div>
                                                    </div>
                                                    <div class="form-group d-flex mt-2">
                                                        <div class="col-3">
                                                            <label class="label">Message Body <span class="ml-2 text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-8" style="text-align:justify;">
                                                        <Input type="textarea" placeholder="Message body...."
                                                        :rows="12" id="body" class="input"
                                                        v-model="data.body" />
                                                             <small id="error"></small>
    
                                                        </div>
    
    
                                                    </div>
                                                    <!-- submit button -->
                                                        <div class="form-group text-center mt-4">
                                                            <Button type="info" size="medium"
                                                            @click="contactTaxpayer()" :loading="isLoading">
                                                            {{ isLoading ?'Please wait...' :'Submit' }}
                                                            </Button>
                                                        </div>
                                                </div>
                                                <!-- content form ends-->
                                               </form>
                                        </div>
                                        <!-- Taxpayer stage ends -->
    
                                        <!-- assessment and returns stage -->
                                        <div class="col-md-12" v-if="stage =='AssessmentReturns'">
                                            assessment design
                                        </div>
                                        <!-- assessment and returns stage ends -->
    
                                    </div>
                                </div>
                                <!-- actions ends-->
    
    
                            </div>
                        </div>
                        <!-- action section  ends -->
                    <!-- </div> -->
                    <!-- ocomment section ends-->
                        <!--attachment section -->
                        <div class="col-md-4">
                            <div class="card detail-card">
                             <div class="card-header pb-2 bg-dark text-muted text-center">
                                    <h5 class="text-muted">ATTACHMENTS</h5>
                             </div>
                                <div class="card-body">
                                    <!-- attachment lists -->
                                    <attachments :case_id="this.data.caseId" :tPin="data.tpin" />
                                    <!-- attachment list ends -->
                                     <div class="file-section top-header bg-dark d-flex justify-content-between" style="box-shadow:0 5px 10px rgba(0,0,0,0.1);">
                                        <span class="m-auto">
                                        <Upload 
                                            ref="upload"
                                            :on-success="handleSuccess"
                                            :headers="{'x-csrf-token' :token,'X-Requested-With':'XMLHttpRequest'}"
                                            :on-error="handleError"
                                            :format="['pdf','docx']"
                                            :on-format-error="handleFormatError"
                                            :max-size="20048"
                                            :on-exceeded-size="handleMaxSize"
                                            action="/api/upload" id="fileUpload" class="input mt-3">
    
                                            <Button icon="ios-cloud-upload-outline">Upload File</Button>
                                            <small class="text-muted">(.pdf or .docx)</small>
                                        </Upload>
                                            <small id="error"></small>
                                        </span>
    
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!-- ocomment section ends-->
                        </div>
    
                <!-- </form> -->
                </div>
                <!-- comments & attachment section ends -->
        </div>
        </div>
    <!-- case details component ends-->
    
    </template>
    <script>
    import casedefault from './cases.vue'
    import TaxpayerResponse from './taxpayer-response.vue'
    import comments from './comments.vue'
    import attachments from './attachments.vue'
    export default {
        props: ['Rstatus', 'Fstatus', 'Astatus', 'username','role','Path', 'action', 'stage', 'actionTitle'],
        data(){
            return{
                data:{
                    caseId: this.$route.params.caseId,
                    approvalType: 'approval',
                    Approval: "",
                    Recommendation:"",
                    filename:'',
                    username: this.username,
                    remarks: '',
                    Astatus:this.Astatus,
                    assessment_no: '',
                    rejection_id: '',
                    ReasonName:'',
                    tpin:'',
                    total:'0'
    
                },
                MonthRegister:[
                    {
                    id:'1',
                    Month:'January'
                    },
                    {
                    id:'2',
                    Month:'February'
                    },
                    {
                    id:'3',
                    Month:'March'
                    },
                    {
                    id:'4',
                    Month:'April'
                    },
                    {
                    id:'5',
                    Month:'May'
                    },
                    {
                    id:'6',
                    Month:'June'
                    },
                    {
                    id:'7',
                    Month:'July'
                    },
                    {
                    id:'8',
                    Month:'August'
                    },
                    {
                    id:'9',
                    Month:'September'
                    },
                    {
                    id:'10',
                    Month:'October'
                    },
                    {
                    id:'11',
                    Month:'November'
                    },
                    {
                    id:'12',
                    Month:'December'
                    }
                ],
                // from db
                TaxHeadInfo: [
                    {
                        option:'Presumptive Tax'
                    },
                    {
                        option:'National Hospital Insurance Fund (NHIF)'
                    },
                ],
                ProceedReasons: [
                    {
                        option:'Significant Amount to be Recovered'
                    },
                    {
                        option:'Others'
                    },
                ],
                ClosureReasons: [
                    {
                        option:'Insignificant Amount amount to be Recovered'
                    },
                    {
                        option:'Errors in Computation'
                    },
                    {
                        option:'High Profile Case'
                    },
                    {
                        option:'Insufficient Data for Proove'
                    },
                    {
                        option:'Others'
                    },
                ],
                index: 1,
                
                formDynamic1: {
                    items: [
                        {
                            Amount: '',
                            month: '',
                            Year: '',
                            TaxHead: '',
                            index: 1,
                            status: 1
                        }
                    ]
                },
                Choice:'',
                Mdata:{
                    type:''
                },
                
                MApprovals:[],
                FApprovals:[],
                options:'',
                isUpload:false,
                casetype: '',
                typeId:'',
                Approvals:[],
                RApprovals:[],
                caseDetails:[],
                reasons: [],
                isLoading:false,
                Rdata:{
                    ReasonType:'reason',
                    reason: '',
                    caseId: this.$route.params.caseId,
                    username: this.username,
                    Rstatus:this.Rstatus,
                    assessment_no:'',
                },
                isLoading:false,
                Fdata: {
                    Approval:'',
                    remarks: '',
                    caseId: this.$route.params.caseId,
                    username:this.username,
                    Fstatus: this.Fstatus,
                    assessment_no:''
                },
                isFormvalide:false,
                token: '',
                // validate form
               
    
            }
        },
    
        components : {
            casedefault,
            TaxpayerResponse,
            comments,
            attachments
        },
        methods: {
    
            // attachment
          
            // attachment ends
            // attachment
            handleSubmit1 (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.$Message.success('Success!');
                        console.log(this.formDynamic1.items)
                    } else {
                        this.$Message.error("Failed");
                    }
                
                })
            },
            handleReset1 (name) {
                this.$refs[name].resetFields();
            },
            handleAdd1 (name) {
                this.index++;
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.formDynamic1.items.push({
                        value: '',
                        Amount: '',
                        month: '',
                        Year: '',
                        TaxHead: '',
                        index: 1,
                        status: 1,
                        index: this.index,
                    });
                    } else {
                        this.$Message.error("All fields of Periods Are Required!");
                        // this.$Message.error("All fields of Period:"+ this.name.index +"Are Required!");
    
                        // this.$Message.error('Fail!');
                    }
                
                })
               
            },
            handleRemove1 (index) {
                this.formDynamic1.items[index].status = 0;
                this.formDynamic1.items[index] = '';
            },
            // attachment ends
    
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
          
            // }
    
        },
      
      
            // },
            // async aprrove() {
            //       // checking for file upload status
            //     const uploadfile = document.querySelector('#fileUpload')
    
            //     if (this.role == 'Chief Manager' && this.Mdata.type == 'Technical above 10 million') {
            //         this.isUpload = true
            //         if (this.data.filename.trim() == '') {
            //         let pt = uploadfile.parentNode;
            //         uploadfile.classList.add('invalid');
            //         let msgElem = pt.querySelector("#error");
            //         msgElem.textContent = 'Kindly upload a file';
            //         this.isFormvalide = false
            //         this.isUploaded = false
            //         }else{
            //             let pt = uploadfile.parentNode;
            //             uploadfile.classList.remove('invalid');
            //             let msgElem = pt.querySelector("#error");
            //             msgElem.textContent = '';
            //             this.isFormvalide = true
            //             this.isUploaded = true
            //         }
            //         if(this.isUploaded==true){
            //             let pt = uploadfile.parentNode;
            //             uploadfile.classList.remove('invalid');
            //             let msgElem =pt.querySelector("#error");
            //             msgElem.textContent = '';
            //             this.isFormvalide =true
            //         }
            //         // upload with file
            //         if (this.isUploaded) {
            //             this.isLoading = true
            //             this.data.filename = `${this.data.filename}`;
            //             const res = await this.callApi('post', '/api/ApproveCase', this.data)
            //             if (res.status === 200) {
            //                 this.success('Case has been Approved and Forwarded to ORC successfully for Review!')
            //                 window.location =`${this.Path}`
            //             }
            //             else {
            //                 this.swr('Something Went Wrong!')
            //             }
            //         }
    
            //         this.warning('file upload is required')
            //     }
            //     // else
            //     else {
            //         this.isLoading=true
            //         const res = await this.callApi('post', '/api/ApproveCase', this.data)
            //         if (res.status === 200) {
            //             this.success('Case has been Approved successfully!')
            //             window.location =`${this.Path}`
            //         }
            //         else {
            //             this.swr('Something Went Wrong')
            //         }
            //         this.isLoading=false
    
            //     }
    
    
            // },
            // async Reject() {
            //     const reason = document.querySelector('#option')
            //     const remarks = document.querySelector('#remarks')
            //     // validate fields
            //     // checking reason
            //     if (!this.Rdata.reason) {
            //         let pt = reason.parentNode;
            //         reason.classList.add('invalid');
            //         let msgElem =pt.querySelector("#error");
            //         msgElem.textContent = 'Reason is required!';
            //         this.isFormvalide = false
    
            //     }
            //     else {
            //         let pt = option.parentNode;
            //         option.classList.remove('invalid');
            //         let msgElem =pt.querySelector("#error");
            //         msgElem.textContent = '';
            //         this.isFormvalide = true
    
            //     }
            //     // checking remarks
            //      if (!this.Rdata.remarks) {
            //         let pt = remarks.parentNode;
            //         remarks.classList.add('invalid');
            //         let msgElem =pt.querySelector("#error");
            //         msgElem.textContent = 'Remarks is required!';
            //         this.isFormvalide = false
    
            //     }else {
            //         let pt = remarks.parentNode;
            //         remarks.classList.remove('invalid');
            //         let msgElem =pt.querySelector("#error");
            //         msgElem.textContent = '';
            //         this.isFormvalide = true
            //     }
    
            //     //procedd if all is well
    
            //     if (this.isFormvalide) {
            //         this.isLoading=true
            //         const res = await this.callApi('post', '/api/RejectCase', this.Rdata)
            //         if (res.status === 200) {
            //             this.success('Case has been Rejected successfully!')
            //             window.location =`${this.Path}`
            //         }
            //         else {
            //             this.swr('Something Went Wrong')
            //         }
            //         this.isLoading=true
            //     }
    
            // },
            // async Forward() {
            //     const remarks = document.querySelector('#remarks')
            //     // checking remarks
            //     if (!this.Fdata.remarks) {
            //         let pt = remarks.parentNode;
            //         remarks.classList.add('invalid');
            //         let msgElem =pt.querySelector("#error");
            //         msgElem.textContent = 'Remarks is required!';
            //         this.isFormvalide = false
    
            //     }else {
            //         let pt = remarks.parentNode;
            //         remarks.classList.remove('invalid');
            //         let msgElem =pt.querySelector("#error");
            //         msgElem.textContent = '';
            //         this.isFormvalide = true
            //     }
            //     //procedd if all is well
            //     if (this.isFormvalide) {
            //         this.isLoading=true
            //         const res = await this.callApi('post', '/api/ForwardCaseToCM', this.Fdata)
            //         if (res.status === 200) {
            //             this.success('Case has been Forwarded to Chief Manager for Review successfully!')
            //             window.location =`${this.Path}`
            //         }
            //         else {
            //             this.swr('Something Went Wrong')
            //         }
            //         this.isLoading=false
    
            //     }
    
            // },
            // handleSuccess(res){
            //     res = `${res}`
            //     this.data.filename = res
            //     this.isUploaded = true
            // },
            // handleError(file){
            //     this.$Notice.warning({
            //         title:'The file format is incorrect!',
            //         desc:`${file.errors.file.length ? file.errors.file[0] :'Something went wrong!'}`
            //     })
            // },
            // handleFormatError(file){
            //     this.$Notice.warning({
            //         title:'The file format is incorrect!',
            //         desc:'File format of ' + file.name + ' is incorrect, please select jpg, jpeg or png.'
            //     });
            // },
            // handleMaxSize(file){
            //     this.$Notice.warning({
            //         title:'Exceeding file size limit!',
            //         desc:'File '+file.name + 'is too large, no more than 21MB'
            //     });
            // },
    
            // },
        async created() {
            console.log(this.stage)
            
            // this.token = window.Laravel.csrfToken
            // const [resCase,resApproval,resRejection,resReason] = await Promise.all([
            //     this.callApi('get',`/api/fetchDetails/${this.data.caseId}`),
            //     this.callApi('get', `/api/fetchApprovals/${this.data.approvalType}`),
            //     this.callApi('get', `/api/fetchRejections/${this.data.approvalType}`),
            //     this.callApi('get',`/api/fetchReasons/${this.Rdata.ReasonType}`)
            // ])
            // if(resCase.status == 200){
            //     this.caseDetails = resCase.data
            //     this.data.tpin = this.caseDetails[0]['ASSESSMENT_NUMBER']
            //     // fetching rejection reason
            //     this.data.rejection_id = resCase.data[0]['REJECTION_ID']
            //     if (resCase.data[0]['REJECTION_ID']) {
            //         const res = await this.callApi('get',`/api/getReasonName/${resCase.data[0]['REJECTION_ID']}`)
            //         if(res.status==200){
            //             this.data.ReasonName = res.data[0]['SELECT_OPTION_NAME']
    
            //         }
            //         else{
            //             this.swr()
            //         }
            //     }
            //     else {
            //         // do nothing
            //     }
    
            //     this.typeId = this.caseDetails[0]['TYPE_ID']
            //     this.Fdata.assessment_no = this.caseDetails[0]['ASSESSMENT_NUMBER']
            //     this.data.assessment_no = this.caseDetails[0]['ASSESSMENT_NUMBER']
            //     this.Rdata.assessment_no = this.caseDetails[0]['ASSESSMENT_NUMBER']
            //     const Restype = await this.callApi('get', `/api/getTypeName/${this.typeId}`)
            //     if (Restype.status == 200) {
            //         this.Mdata.type = Restype.data[0]['SELECT_OPTION_NAME']
            //     } else {
            //         this.swr()
            //     }
    
            // }
    
            // else{
            //     this.swr('Something went wrong!')
            // }
            // // approvals without forward to cm
            // if(resApproval.status == 200){
            //     this.Approvals = resApproval.data
            //     this.MApprovals = resApproval.data
    
            // }
            // else{
            //     this.swr('Something went wrong!')
            // }
            // //   reasons
            // if(resRejection.status == 200){
            //     this.RApprovals = resRejection.data
            // }
            // else{
            //     this.swr('Something went wrong!')
            // }
    
            // //   reasons
            // if(resReason.status == 200){
            //     this.reasons = resReason.data
            // }
            // else{
            //     this.swr('Something went wrong!')
            // }
    
    
    
             // fetching forward to cm option only if case type is as below
            // if (this.casetype = 'Technical between 5-10 million' || (this.casetype = 'Technical above 10 million')) {
            //     const resForward = await this.callApi('get', `/api/getForwardOption/${this.Mdata.approvalType}`)
            //     if (resForward.status == 200) {
            //         this.FApprovals = resForward.data
            //     }
            //     else {
            //         this.swr()
            //     }
            // } else {
            //     this.swr()
            // }
    
        }
    
    
    
    
    
    
    
    }
    </script>
    