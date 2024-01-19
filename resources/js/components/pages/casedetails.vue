<template>
    <div class="card shadow mb-4">
        <div class="card-body">
            <casedefault :stage="stage" :details="details" />
            <div class="comments-details">
                <div class="row">
                    <comments :case_id="data.caseId" :role="role" :username="username" :stage2="stage2" :stage="stage" />
                </div>
            </div>
            <!-- comments & attachment section -->
            <div class="comments-details">
                <div class="row ">
                    <!--attachment section -->
                    <div :class="`${smallCol}`">
                        <div class="card detail-card">
                            <div class="card-header pb-2 bg-dark text-muted text-center">
                                <h5 class="text-muted">ATTACHMENTS</h5>
                            </div>
                            <div class="card-body"> 
                                <!-- attachment lists -->
                                <attachments :case_id="this.data.caseId" :p_no="data.p_no" :stage="stage" />
                                <!-- attachment list ends -->
                                <div v-if="stage != 'Details' && role != 'Admin' && role != 'hr'"
                                    class="file-section top-header bg-dark d-flex justify-content-between"
                                    style="box-shadow:0 5px 10px rgba(0,0,0,0.1);">
                                    <span class="m-auto">
                                        <Upload ref="upload" :on-success="handleSuccess"
                                            :headers="{ 'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest' }"
                                            :on-error="handleError"
                                            :format="['pdf', 'docx', 'zip', 'rar', 'xls', 'xlsx', 'csv']"
                                            :on-format-error="handleFormatError" :max-size="21000"
                                            :on-exceeded-size="handleMaxSize" action="/api/upload"
                                            :data="{ caseId: this.data.caseId }" :multiple="true" id="fileUpload"
                                            class="input mt-3">
                                            <Button icon="ios-cloud-upload-outline">Upload File</Button>
                                            <small class="text-muted">(.pdf,.docx,.zip ,.xls,.xlsx,.csv or .rar)</small>
                                        </Upload>
                                        <small id="error"></small>
                                        <input type="hidden" name="caseId" v-model="data.caseId" />
                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- attachment section ends-->
                    <!-- action section -->

                    <div v-if="final == 'x'" :class="`${bigCol}`">
                        <div class="form-group ml-2 d-flex align-items-center mt-2">
                            <Col span="13" offset="0">
                            <div class="form-group ml-2 f-s-13">
                                <label class="mb-3  text-dark">Select Document To Print</label>
                                <Select v-model="doc_type" style="width:100%" placeholder="Select Document...">
                                    <Option value="cl">Clearance Form</Option>
                                    <Option value="clf">Clearance Form (FOR)</Option>
                                    <Option value="ct">Certificate of Service</Option>
                                    <Option value="ctf">Certificate of Service (FOR)</Option>
                                </Select>
                            </div>
                            </Col>
                        </div>
                    </div>
                    <div :class="`${bigCol}`" v-if="stage == 'view_dept' || stage == 'pending'">
                        <div class="card ">
                            <div class="card-header bg-dark  text-muted"
                                style="text-transform:uppercase; text-align:center; ">
                                {{ actionTitle }}
                            </div>
                            <!-- actions -->
                            <div class="card-body detail-card">
                                <br />
                                <div class="row">
                                    <!-- prelim -->
                                    <div class="col-md-12">
                                        <!-- cm actions -->
                                        <!-- seletions -->
                                        <Col span="13" offset="0">
                                        <div class="form-group ml-2 f-s-13">
                                            <label class="mb-3  text-dark">Recommendation <span
                                                    class="text-danger">*</span></label>
                                            <Select v-model="data.Recommendation" style="width:100%"
                                                placeholder="Select Recommendation...">
                                                <Option v-if="stage2 != 'pending'" value="yes_lib">Liability</Option>
                                                <Option v-if="stage2 != 'pending'" value="no_lib">No Liability</Option>
                                                <Option v-if="stage2 == 'pending'" value="close_lib">Close Case</Option>

                                            </Select>
                                        </div>
                                        </Col>

                                        <!-- seletions ends-->
                                        <!-- proceed with case / close case -->
                                        <div class="card" v-if="data.Recommendation == 'yes_lib'">
                                            <div class="card-body">
                                                <RadioGroup v-model="Choice">
                                                    <Radio label="monetary">
                                                        <span class="text-dark">Monetary</span>
                                                    </Radio>
                                                    <Radio label="others">
                                                        <span class="text-dark">Others</span>
                                                    </Radio>

                                                </RadioGroup>
                                                <div v-if="Choice == 'monetary'">
                                                    <Form ref="formDynamic1" :model="formDynamic1" style="width: 100%"
                                                        :label-width="100">
                                                        <template v-for="(item, index) in formDynamic1.items">
                                                            <div class="card">
                                                                <div v-if="item.status" :key="index"
                                                                    :label="'Period ' + item.index">

                                                                    <div class="m-5">
                                                                        <div class="row mb-4">

                                                                            <div class="form-group col-5">
                                                                                <label class="text-dark">Item<span
                                                                                        class="text-danger ml-2">*</span></label>

                                                                                <Select v-model="item.Lib_item"
                                                                                    style="width:100%"
                                                                                    placeholder="Select Item..."
                                                                                    v-if="stage == 'facilities'">
                                                                                    <Option :value="head.option"
                                                                                        v-for="(head, i) in Lib_itemInfo"
                                                                                        :key="i">{{ head.option }}
                                                                                    </Option>
                                                                                </Select>
                                                                                <Input v-else v-model="item.Lib_item"
                                                                                    type="text"
                                                                                    placeholder="Enter Item Name..." />
                                                                            </div>
                                                                            <div class="form-group col-5">
                                                                                <label class="text-dark">Amount <span
                                                                                        class="text-danger ml-2">*</span></label>
                                                                                <Input v-model="item.Amount" type="text"
                                                                                    placeholder="Enter Amount..." />
                                                                            </div>
                                                                            <div class="form-group col-3 "
                                                                                v-if="item.index != '1'">
                                                                                <div class="">
                                                                                </div>
                                                                                <Button @click="handleRemove1(index)" ghost
                                                                                    type="error">Delete</Button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </template>
                                                        <div class="row mb-4">
                                                            <Col span="8" offset="3">
                                                            <Button type="info" ghost @click="handleAdd1('formDynamic1')"
                                                                icon="md-add">Add</Button>
                                                            </Col>
                                                        </div>
                                                    </Form>
                                                    <!-- more entry -->

                                                    <div class="card">
                                                        <div class="card-body ">
                                                            <div class="form-group ml-2 d-flex align-items-center mt-2">
                                                                <label class="mb-3 text-dark mb-2">Remarks <span
                                                                        class="text-danger ml-2">*</span></label>
                                                                <Input v-model="data.remarks" placeholder="Enter Remarks"
                                                                    type="textarea" :Row="10" :col="6" />

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group text-center mt-5">
                                                        <Col span="8" offset="7" v-if="isValid">
                                                        <Button type="primary"
                                                            @click="handleSubmit('formDynamic1')">Submit</Button>
                                                        </Col>
                                                    </div>
                                                </div>
                                            </div>

                                            <div v-if="Choice == 'others'">
                                                <div class="form-group ml-2 d-flex align-items-center mt-2">
                                                    <label class="mb-3 text-dark mb-2">Remarks <span
                                                            class="text-danger ml-2">*</span></label>
                                                    <Input v-model="data.remarks" placeholder="Enter Remarks"
                                                        type="textarea" :Row="10" :col="3" />
                                                </div>

                                                <div class="form-group ml-2 mt-2 text-center">
                                                    <Button type="primary" :disabled="isLoading" :loading="isLoading"
                                                        @click="handleSubmit()">{{ isLoading
                                                            ? 'Please wait...' : 'Submit' }}
                                                    </Button>
                                                </div>
                                            </div>
                                        </div>

                                        <!--others ends -->
                                    </div>
                                    <!-- </div> -->
                                </div>
                                <div v-if="data.Recommendation == 'no_lib' || data.Recommendation == 'close_lib'">
                                    <div v-if="stage2 != 'pending'" class="form-group ml-2 d-flex align-items-center mt-2">
                                        <label class="mb-3 text-dark mb-2">Remarks <span
                                                class="text-danger ml-2">*</span></label>
                                        <Input v-model="data.remarks" placeholder="Enter Remarks" type="textarea" :Row="10"
                                            :col="6" />

                                    </div>
                                    <!-- proceed with case / close case ends -->
                                    <div class="form-group text-center mt-5">
                                        <Col span="8" offset="7" v-if="isValid">
                                        <Button type="primary" @click="handleSubmit('formDynamic1')">Submit</Button>
                                        </Col>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- case details component ends-->
</template>
<script>
import casedefault from './cases.vue'
import comments from './comments.vue'
import attachments from './attachments.vue'
export default {
    props: ['username', 'role', 'Path', 'action', 'stage', 'actionTitle', 'final', 'stage2'],
    data() {
        return {
            doc_type: null,
            ItemData: {
                total: '0'
            },
            bigCol: '',
            smallCol: '',
            preventedDate: {
                disabledDate(month) {
                    const today = new Date()
                    today.setHours(0, 0, 0, 0);
                    return month > today
                }
            },
            data: {
                caseId: this.$route.params.caseId,
                Recommendation: "",
                filename: [],
                username: this.username,
                role: this.role,
                remarks: '',

            },
            // from db
            Lib_itemInfo: [],
            ProceedReasons: [],
            index: 1,
            formDynamic1: {
                items: [
                    {
                        Amount: '',
                        Lib_item: '',
                        index: 1,
                        status: 1
                    }
                ]
            },
            Choice: '',
            isValid: true,
            options: '',
            isUpload: false,
            casetype: '',
            typeId: '',
            details: [],
            reasons: [],
            isLoading: false,
            token: '',


        }
    },

    components: {
        casedefault,
        comments,
        attachments
    },
    watch: {
        'doc_type': { handler: 'PrintDocuments' }
    },
    methods: {

        downloadFile(url, filename) {
            fetch(url)
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = filename;
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => console.error('Error downloading PDF:', error));
        },
        async PrintDocuments() {
            if (this.doc_type == 'cl') {
                var url = `/api/pdfClearance/${this.details.case_id}?query=1`
                this.downloadFile(url, `${this.details.employee_name + ' (' + this.details.user_name + ')'}clearance_form.pdf`);
            } else if (this.doc_type == 'ct') {
                var url = `/api/pdfCertificate/${this.details.case_id}?query=1`
                this.downloadFile(url, `${this.details.employee_name + ' (' + this.details.user_name + ')'}certificate_of_service.pdf`);
            } else if (this.doc_type == 'ctf') {
                var url = `/api/pdfCertificate/${this.details.case_id}`
                this.downloadFile(url, `${this.details.employee_name + ' (' + this.details.user_name + ')'}certificate_of_service(FOR).pdf`);
            } else if (this.doc_type == 'clf') {
                var url = `/api/pdfClearance/${this.details.case_id}`
                this.downloadFile(url, `${this.details.employee_name + ' (' + this.details.user_name + ')'}clearance_form(FOR).pdf`);
            } else {
                this.swr('something went wrong (Document Printing Error)')
            }
        },
        async handleSubmit() {
            if (this.Choice === "monetary") {
                var formData = this.formDynamic1.items;
                let size = formData.length
                this.index++;
                if (this.data.remarks == '') return this.error('Please add a RemarK')
                let totalAmounts = 0;
                this.totalAmount = totalAmounts;
                for (let i = 0; i < this.formDynamic1.items.length; i++) {
                    totalAmounts += parseInt(this.formDynamic1.items[i].Amount);
                    const postData = {
                        ...this.data,
                        Amount: this.formDynamic1.items[i].Amount,
                        Lib_item: this.formDynamic1.items[i].Lib_item,
                        Choice: this.Choice,
                        department: this.role,
                        department_id: this.details.department_id,
                        lib_dept_id: this.$store.state.user.role.role_id,
                    }

                    const res = await this.callApi('post', "/api/updateCase/", postData)
                }
                this.success('Succesfully Cleared');
                this.$router.go(-1)
            }
            if (this.Choice === "others" || this.data.Recommendation == 'no_lib' || this.data.Recommendation == 'close_lib') {

                if (this.data.remarks == '' && this.data.Recommendation != 'close_lib')
                    return this.error('Please Select a Reason')

                var postData2 = {}

                if (this.Choice == 'others') {
                    postData2 = {
                        ...this.data,
                        Choice: this.Choice,
                        case: "",
                        choice: 'others',
                        department: this.role,
                        department_id: this.details.department_id,
                        lib_dept_id: this.$store.state.user.role.role_id,
                    }
                }
                if (this.data.Recommendation == 'no_lib' || this.data.Recommendation == 'close_lib') {
                    postData2 = {
                        ...this.data,
                        Choice: this.Choice,
                        case: "",
                        choice: 'no_lib',
                        department: this.role,
                        department_id: this.role_dec,
                        lib_dept_id: this.$store.state.user.role.role_id,
                    }
                }
                const res2 = await this.callApi('post', "/api/updateCase/", postData2)
                this.success('Success!');
                this.$router.go(-1)
            }
        },
        handleReset1(name) {
            this.$refs[name].resetFields();
        },


        handleAdd1() {
            var formData = this.formDynamic1.items;
            var size = formData.length
            this.index++;
            for (let i = 0; i < size; i++) {
                var newData = formData[i];
                if (newData.Amount == '') return this.error('Amount is required')
                if (newData.Lib_item == '') return this.error('Item is required')
                var Total = parseFloat(newData.Amount) + parseFloat(this.ItemData.total);
            }
            formData.push({
                Amount: '',
                Lib_item: '',
                index: 1,
                status: 1,
                index: this.index
            });
            this.ItemData.total = Total;
        },

        handleRemove1(index) {
            this.ItemData.total -= parseFloat(this.formDynamic1.items[index].Amount)
            this.formDynamic1.items[index].status = 0;
            this.formDynamic1.items.splice(index, 1)
            // 
        },
        handleSuccess(res) {
            this.data.filename.push(res.filenames[0]);
        },
        handleError(file) {
            this.$Notice.warning({
                title: 'The file format is incorrect!',
                desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong!'}`
            })
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: 'The file format is incorrect!',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg, jpeg or png.'
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit!',
                desc: 'File ' + file.name + 'is too large, no more than 21MB'
            });
        },

        async fetchDetails() {
            const res = await this.callApi('get', `/api/fetchDetails/${this.data.caseId}`)
            if (res.status === 200) {
                this.details = res.data
            } else {
                this.swr('something went wrong')
            }
        }
    },



    created() {
        this.fetchDetails()
        // if ((this.stage) === 'AssessmentReturns') {
        //     this.bigCol = 'col-md-9',
        //         this.smallCol = 'col-md-3'
        // }
        // else {
        this.bigCol = 'col-md-9'
        this.smallCol = 'col-md-3'
        // }


    }







}
</script>
