<template>
    <div class="card message-card">
        <!-- include an accordion -->
        <div class="card-header bg-dark text-muted collapsed"
            style="text-transform:uppercase; text-align:center; cursor:pointer;" data-toggle="collapse"
            data-target="#Response" aria-expanded="false" aria-controls="#Response">
            FROM THE DEPARTMENTS
        </div>
        <!-- accordion -->
        <div id="accordion" class="col-lg-12 mt-3" style="width:100%">
            <!-- awaiting taxpayer response -->
            <div class="card shadow">
                <div id="Response" class="collapse" aria-labelledby="Response" data-parent="#accordion">

                    <!-- comments -->
                    <div class="card-body detail-card table-responsive">
                        <table style="border-style:none !important;width:100%;"
                            class="table no-wrap email-table table-striped table-hover">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th class="text-white">NAME</th>
                                    <th class="text-white">DEPT</th>
                                    <th class="text-white">STATUS</th>
                                    <th class="text-white">COMMENT</th>
                                    <th class="text-white">DATE CREATED</th>
                                    <th class="text-white">VIEW</th>
                                </tr>
                            </thead>
                            <tbody class="table-body" style="font-size:12px;">
                                <tr v-for="(remark, i) in comments" v-if="comments.length" :key="i">
                                    <td>{{ remark.other_names + ' ' }} ({{ remark.username }}) </td>
                                    <td>{{ remark.department_id_ }} </td>
                                    <!-- <td>{{remark.type == 'yes_lib' ? 'Liabilities':' No Liabilities' }} </td> -->
                                    <td v-if="remark.type === 'yes_lib'">Liabilities</td>
                                    <td v-else-if="remark.type === 'no_lib'">No Liabilities</td>
                                    <td v-else>HR initiator</td>
                                    <td>{{ remark.remarks }} </td>
                                    <td>{{ moment(remark.created_at).format('lll') }} </td>
                                    <td v-if="remark.type === 'yes_lib'">
                                        <Button type="primary"
                                            @click="get_lib(remark.remarks_id, remark.case_id, remark.department_id_)"
                                            :loading="isLoading" :disabled="isLoading">view</Button>
                                    </td>
                                    <td v-else disabled>
                                        <Button type="primary" disabled>view</Button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- accordion ends -->


        <Modal v-model="createModal" :title="title + ' ' + 'Liabilities'" :mask-closable="false" :width="1000"
            :styles="{ top: '60px', left: '100px', textTransform: 'uppercase' }" :closable="true">
            <div class="card">
                <hr class="solid">
                <div class="card card-detail">
                    <div class="card-body">
                        <table style="border-style:none !important;width:100%;"
                            class="table no-wrap email-table table-striped table-hover">
                            <thead class="bg-dark text-white text-center">
                                <tr>
                                    <th class="text-white text-center">ITEM</th>
                                    <th class="text-white text-center">AMOUNT</th>
                                    <th class="text-white text-center">CLEAR</th>
                                    <th class="text-white text-center">COMMENT</th>
                                    <th class="text-white text-center">ATTACHMENT</th>
                                    <th class="text-white text-center">UPLOAD ATTACHMENT</th>
                                </tr>
                            </thead>
                            <tbody class="table-body" style="font-size:12px;">
                                <tr v-for="(x, i) in libs" v-if="libs.length" :key="i">
                                    <td>{{ x.product_name }}</td>
                                    <td>{{ x.amount }} </td>
                                    <td>
                                        <div v-if="x.cleared == 0">
                                            <input type="checkbox" v-model="x.isChecked">
                                        </div>
                                        <div v-else>
                                            <span>cleared</span>
                                        </div>

                                    </td>
                                    <td>
                                        <div v-if="x.cleared == 0">
                                            <div class="form-group">
                                                <Input placeholder="Enter Comment" v-model="comment[x.liab_id]"
                                                    type="textarea" :Row="2" :col="6" :disabled="!x.isChecked" />
                                            </div>
                                        </div>
                                        <div v-else>
                                            <Input placeholder="Enter Comment" v-model="x.comment" type="textarea" :Row="2"
                                                :col="6" readonly />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="file-section bottom-header ">
                                            <div class="text-center" v-if="isLoading">Loading</div>
                                            <div class="text-center" v-else-if="x.attachments.length === 0">No attachments
                                                yet</div>
                                            <ul style="list-style:none;" class="download-lists" v-else>
                                                <li class="d-flex justify-content-between download-item"
                                                    v-for="(attachment, j) in x.attachments" :key="j">
                                                    <span class="text-primary">{{ attachment.attachment_name || 'Unnamed attachment'}}</span>
                                                    <a :href="attachment.attachment_link" class="download-rounded" download>
                                                        <i class="bx bxs-download "></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="file-section top-header d-flex justify-content-between"
                                                style="box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);">
                                                <span class="m-auto">
                                                    <Upload ref="upload" :on-success="res => handleSuccess(res, x.liab_id)"
                                                        :headers="{ 'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest' }"
                                                        :on-error="handleError"
                                                        :format="['pdf', 'docx', 'zip', 'rar', 'xls', 'xlsx', 'csv']"
                                                        :on-format-error="handleFormatError" :max-size="21000"
                                                        :on-exceeded-size="handleMaxSize" action="/api/upload"
                                                        :data="{ caseId: x.liab_id }" :multiple="true" id="fileUpload"
                                                        class="input mt-3">
                                                        <Button icon="ios-cloud-upload-outline"
                                                            :disabled="!x.isChecked">Upload File</Button>
                                                    </Upload>
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--new  message body  ends-->

            <div slot="footer">
                <Button v-if="this.role != 'hr' && stage2 == 'pending'" type="success" @click="clear_lib()"
                    :loading="isLoading" :disabled="isLoading">&nbsp;{{ isLoading ?
                        'Loading..' : 'Clear' }} <i class="fa fa-check-circle" aria-hidden="true"></i></Button>

                <Button v-if="stage == 'view_dept' && this.role == 'payroll' || this.role == 'ICT_ACCOUNT4'" type="success" @click="clear_lib()"
                    :loading="isLoading" :disabled="isLoading">&nbsp;{{ isLoading ?
                        'Loading..' : 'Clear' }} <i class="fa fa-check-circle" aria-hidden="true"></i></Button>
                <Button type="error" @click="remove()">Close &nbsp;<i class="fa fa-times-circle"
                        aria-hidden="true"></i></Button>
            </div>
        </Modal>
    </div>
</template>
    
<script>
import attachments from './attachments.vue'

export default {
    props: ['case_id', 'role', 'username', 'stage2', 'stage'],
    data() {
        return {
            data: {
                caseId: this.case_id,
                filename: []
            },
            comments: [],
            libs: [],
            createModal: false,
            isLoading: false,
            isChecked: false,
            r_id: '',
            depart: '',
            title: this.$route.params.department,
            token: '',
            attachments: [],
            comment: {},
            attach: { filename: [], lib_id: '' }
        }
    },

    computed: {
        selectedItems() {
            return this.libs.filter(x => x.isChecked);
        }
    },
    methods: {
        async getAttachment(liab_id) {
            this.isLoading = false;
            const res = await this.callApi('get', `/api/fetchAttachments/${liab_id}`);
            if (res.status == 200) {
                // Find the corresponding lib and update its attachments array
                const libIndex = this.libs.findIndex(lib => lib.liab_id === liab_id);
                if (libIndex !== -1) {
                    this.$set(this.libs[libIndex], 'attachments', res.data);
                }
            } else {
                this.swr("Ooops! error getting document");
            }
        },

        handleSuccess(res, liab_id) {
            const selectedLiability = this.selectedItems.find(x => x.liab_id === liab_id);
            if (selectedLiability) {
                if (!selectedLiability.filenames) {
                    this.$set(selectedLiability, 'filenames', []); // Initialize filenames if it doesn't exist
                }
                selectedLiability.filenames.push(...res.filenames)
            }
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


        async clear_lib() {
            this.isLoading = true;
            const isAtLeastOneChecked = this.selectedItems.some(item => item.isChecked);

            if (isAtLeastOneChecked) {

                for (let i = 0; i < this.selectedItems.length; i++) {
                    const x = this.selectedItems[i];
                    if (x.isChecked) {
                        const comment = this.comment[x.liab_id];
                        const updatedLiability = { ...x, comment: comment };
                        this.selectedItems[i] = updatedLiability;
                    }
                }
                const res2 = await this.callApi('post', "/api/updateLib/", [this.username, this.role, this.selectedItems])
                if (res2.status == 200) {
                    await this.get__com()
                    this.success(`Success you cleared!`);
                    this.isLoading = false;
                } else {
                    this.swr('Something Went Wrong(clearing the item)!')
                    this.isLoading = false;
                }
            } else {
                this.swr('Please check the boxes or All are cleared')
            }
            this.isLoading = false;
            this.remove();
            this.selectedItems = []
        },
        async get_lib(remarks_id, case_id, department_id_) {
            this.r_id = remarks_id
            this.depart = department_id_
            var dataSent = [case_id, department_id_]
            this.isLoading = true;
            const res = await this.callApi('get', `/api/get_liabilities/${dataSent}`)
            if (res.status == 200) {
                this.libs = res.data.map(lib => ({
                    ...lib,
                    attachments: [] // Initialize an empty array for attachments
                }));
                for (let i = 0; i < this.libs.length; i++) {
                    await this.getAttachment(this.libs[i].liab_id);
                }
                this.isLoading = false;
                this.createModal = true
            }
            else {
                this.swr('Something Went Wrong(liabilities)!')
                this.isLoading = false;
            }

        },
        remove() {
            this.isLoading = false;
            this.createModal = false;
            this.isChecked = false
            this.r_id = ''
            this.depart = ''
            this.filename = ''
            this.attach = {}
            this.libs = []
        },

        async get__com() {
            const res = await this.callApi('get', `/api/get_comments/${this.data.caseId}`);
            if (res.status == 200) {
               if (this.role == 'ICT_ACCOUNT4') {
                  this.comments = res.data.filter((comment) => {
                        return ["ICT_ACCOUNT1", "ICT_ACCOUNT2", "ICT_ACCOUNT3", "ICT_VPN"].includes(comment.department_id_);
                    });



                } else  if (this.role != 'payroll' && this.role != 'hr') {
                    this.comments = res.data.filter((comment) => {
                        return comment.department_id_ == this.role;
                    });
                }
               
                else {
                    this.comments = res.data;
                }

            } else {
                this.swr('Something Went Wrong (comments)!')
            }


        }
    },
    async created() {
        await this.get__com()
    }
}
</script>