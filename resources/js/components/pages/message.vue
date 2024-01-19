<template>
    <div>
        <!-- message container -->
        <div class="message-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card message-card">
                        <div class="card-body bg-dark text-white mailbox-widget pb-0 ">
                            <h2 class="text-white">Mailbox</h2>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="" id="inbox" aria-labelledby="inbox-tab" role="tabpanel" >
                                <div class="card-body">
                                    <div class=" row p-4 no-gutters align-items-center d-flex justify-content-between" >
                                        <div class="col-sm-12 col-md-6">
                                            <h5 class="font-light mb-0">
                                                <i class="ti-email mr-2"></i><span class="badge bg-danger">{{ data.unread}}</span> Unread messages
                                            </h5>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <ul
                                                class=" list-inline dl mb-0 float-left float-md-right">
                                                <li class=" list-inline-item text-info mr-3 ">
                                                    <button class="btn btn-circle btn-success text-white float-right" @click="composeModal= true" style="display: flex;align-items: center;justify-content: center;" >
                                                        <i class="  bx bx-plus f-s-16"></i>
                                                        <span class="ml-2 font-normaltext-light ">Compose</span>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                    <!-- Mail list-->
                                    <div class="table-responsive">
                                        <table  
                                        class="table email-table no-wrap table-hover v-middle mb-0 font-13 " style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th>#</th> -->
                                                    <th>USERNAME</th>
                                                    <th>SUBJECT</th>
                                                    <th>MESSAGE</th>
                                                    <th>DATE</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="color: gray "  v-for="(message, i) in Messages" :key="i" 
                                                :class="message.STATUS==0 ?'text-bold':''">
                                                    <!-- <td class="pl-3">{{ message.id }}</td> -->
                                                    <td>
                                                        <span class="mb-0">{{ message.TO }}</span>
                                                    </td>
                                                    <td>{{ message.SUBJECT }}</td>
                                                    <td class="message-reduced">
                                                        <span>{{ message.BODY }}</span>
                                                    </td>
                                                    <td>{{moment(message.created_at).format('lll')}}</td>
                                                    <td>
                                                        <button class=" btn btn-circle btn-success text-white btn-sm " @click="showDetailsModal(message, i)" style="display: flex; align-items: center; justify-content: center; gap: 5px; " >
                                                            <i class=" fa fa-eye  mr-3" ></i> View
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- message container ends-->
        <!-- details modal -->
        <Modal
            v-model="detailsModal"
            title="Message Details"
            :mask-closable="false"
            width="600"
            :styles="{ top: '60px' }"
            :closable="true"
        >
            <!-- message body -->
            <div class="row inbox-wrapper">
                <div class="col-lg-12">
                    <div class="card message-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 email-content">
                                    <div class="email-head">
                                        <div class="email-head-subject">
                                            <div class=" title d-flex align-items-center justify-content-between " >
                                                <div class=" d-flex align-items-center">
                                                    <a class="active" href="#" ><span class="icon" ></span  ></a>
                                                    <span class=" text-muted f-s-14 " style="text-transform:capitalize;">
                                                    {{ messageData.subject }}
                                                    </span>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        <div class=" email-head-sender d-flex align-items-center justify-content-between flex-wrap " ref="body" >
                                            <div class=" d-flex align-items-center " >
                                               
                                                <div class="sender d-flex align-items-center ">From
                                                    <span  class="text-success">{{messageData.sender }}</span>
                                                    <span>to</span><span class="text-muted" >me</span>
                                                </div>
                                            </div>
                                            <div class="date">
                                                {{moment(messageData.created_at).format('lll')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="email-body">
                                        <p>{{messageData.body}}</p>
                                        <br />
                                    </div>
                                    <Grid :col="4" square class="grid">
                                       
                                        <GridItem>
                                            <button
                                                @click="anim2 = !anim2" class=" btn btn-circle btn-success 
                                                text-white float-right"> Reply
                                                <i class="bx bx-reply f-s-16"></i>
                                            </button>
                                            <transition name="slide-down">
                                                <div v-show="anim2" class="transition-box" >
                                                        <!-- new message body -->
                                                    <div class="card mt-5">
                                                        <div class="card card-detail">
                                                            <div class="card-body">
                                                                <form>
                                                                    
                                                                    <div class="form-group d-flex mt-2">
                                                                        <div class="col-3">
                                                                            <label class="label"
                                                                                >Subject
                                                                                <span class="text-danger ml-2">*</span></label>
                                                                        </div>
                                                                        <div class="col-9">
                                                                            <Input type="text" placeholder="Subject" 
                                                                            id="subject" v-model="Fdata.subject"/>
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
                                                                                :rows="6" id="body" v-model="Fdata.message" />
                                                                                <small id="error"></small>
                                                                            </div>
                                                                        </div>
                                                                         <div slot="footer" class="text-center mt-4">
                                                                        <Button type="success" :loading="isloading" 
                                                                        @click="replyMail()" >
                                                                            {{ isloading ?'Please wait...' :'Send' }}</Button>
                                                                    </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <!--new  message body  ends-->
                                       
                                                </div>
                                            </transition>
                                        </GridItem>
                                    </Grid>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- message body  ends-->
            <div slot="footer">
                <Button type="error" @click="detailsModal = false">Close</Button>
            </div>
        </Modal>
        <!-- details modal -->
            <!-- details modal -->
        <Modal
            v-model="composeModal"
            title="Compose Message"
            :mask-closable="false"
            width="500"
            :styles="{ top: '60px' }"
            :closable="true">
            <!-- new message body -->
            <div class="card">
                <div class="card card-detail">
                    <div class="card-body">
                        <form>
                            <div class="form-group d-flex mt-2">
                                <div class="col-3">
                                    <label class="label">To
                                        <span class="text-danger ml-2">*</span>
                                    </label>
                                </div>
                                <div class="col-9">
                                    <Select placeholder="Select Recipient" 
                                    clarable filterable v-model="data.to" class="input" id="to">
                                    <Option :value="(user.USER_NAME)" v-for="(user, i) in users" :key="i">
                                    {{ user.USER_NAME }} - ({{ user.OTHER_NAMES }}) - {{ user.ROLE_NAME }}
                                    </Option>
                                    </Select>
                                    <small id="error"></small>
                                </div>
                            </div>
                        
                            

                            <div class="form-group d-flex mt-2">
                                <div class="col-3">
                                    <label class="label"
                                        >Subject
                                        <span class="text-danger ml-2">*</span></label>
                                </div>
                                <div class="col-9">
                                    <Input type="text" placeholder="Subject" id="subject" v-model="data.subject"/>
                                    <small id="error"></small>
                                </div>
                            </div>

                            <div class="form-group d-flex mt-2">
                                <div class="col-3">
                                    <label class="label">Message
                                        <span class="text-danger ml-2">*</span></label>
                                </div>
                                <div class="col-9">
                                    <Input type="textarea" placeholder="message..." :rows="6" id="body" v-model="data.message" />
                                    <small id="error"></small>
                                </div>
                            </div>

                            

                        </form>
                    </div>
                </div>
            </div>
            <!--new  message body  ends-->
            <div slot="footer">
                <Button type="success" :loading="isloading" @click="composeMail()" >
                     {{ isloading ?'Please wait...' :'Send' }}</Button>
                <Button type="error" @click="composeModal = false" >Close</Button>
            </div>
        </Modal>
        <!-- details modal -->
        
    </div>
</template>
<script>
export default {
    props:['username'],
    data() {
        return {
            data: {        
                message: "",
                subject: "",
                to: "",
                unread: "",
                username:this.$store.state.user.USER_NAME
            },
            Fdata: {        
                message: "",
                subject: "",
                to: "",
                username:this.$store.state.user.USER_NAME
            },
            

            Messages: [],
            messageData:[],
            isFormvalide:false,
            isloading:false,
            anim1: false,
            anim2: false,
            index:-1,
            detailsModal: false,
            composeModal: false,
            users:[]
        };
    },
    methods: {

        async showDetailsModal(message, index) {
            let obj = {
                id: message.id,
                subject: message.SUBJECT,
                username: message.TO,
                created_at: message.created_at,
                body: message.BODY,
                sender: message.FROM,
                STATUS: message.STATUS
            }
            this.Fdata.to = obj.sender
            this.messageData = obj
            this.index = index
            this.detailsModal = true
            const res = await this.callApi('post', '/api/changeMessageStatus', this.messageData)
            if (this.res.status == 200) {
                this.Messages[this.index].STATUS = this.messageData.STATUS
            }
            else {
                this.swr()
            }
        },

        async composeMail() {

            const email = document.querySelector('#to')
            const subject = document.querySelector('#subject')
            const body = document.querySelector('#body')

          
            // checking email
            if (this.data.to.trim() == '') {
                let pt = email.parentNode;
                email.classList.add('invalid');
                let msgElem = pt.querySelector("#error");
                msgElem.textContent = 'Recipient field is required!';
                this.isFormvalide = false
            }
            else {
                let pt = email.parentNode;
                email.classList.remove('invalid');
                let msgElem = pt.querySelector('#error');
                msgElem.textContent = '';
                this.isFormvalide = true
            }
            // checking subject
            if (this.data.subject.trim() == '') {
                let pt = subject.parentNode;
                subject.classList.add('invalid');
                let msgElem = pt.querySelector("#error");
                msgElem.textContent = 'Subject field is required!';
                this.isFormvalide = false
            } else {
                let pt = subject.parentNode;
                subject.classList.remove('invalid');
                let msgElem = pt.querySelector('#error');
                msgElem.textContent = '';
                this.isFormvalide = true
            }
            // checking body
            if (this.data.message.trim() == '') {
                let pt = body.parentNode;
                body.classList.add('invalid');
                let msgElem = pt.querySelector("#error");
                msgElem.textContent = 'Message  is required!'
                this.isFormvalide = false

            } else {
                let pt = body.parentNode;
                body.classList.remove('invalid');
                let msgElem = pt.querySelector("#error");
                msgElem.textContent = '';
                this.isFormvalide = true
            }
            if (this.data.message && this.data.to && this.data.subject) {
                console.log(this.data)
                this.isloading = true
                const resSend = await this.callApi('post', '/api/composeMail', this.data)

                if (resSend.status === 200) {
                    this.success('Message sent successfully.')
                    this.data.subject = ''
                    this.data.message = ''
                    this.data.to = ''
                    this.composeModal = false
                }
                else {
                    if (resSend.status === 422) {
                        for(let i in resSend.data.errors){
                            this.error(resSend.data.errors[i][0])
                        }
                        this.isloading = false

                    }
                    this.swr()
                    this.isloading = false
                }
                this.isloading = false

                
            }

         
        },
        async replyMail() {

            const subject = document.querySelector('#subject')
            const body = document.querySelector('#body')
          
            // checking subject
            if (this.Fdata.subject.trim() == '') {
                let pt = subject.parentNode;
                subject.classList.add('invalid');
                let msgElem = pt.querySelector("#error");
                msgElem.textContent = 'Subject field is required!';
                this.isFormvalide = false
            } else {
                let pt = subject.parentNode;
                subject.classList.remove('invalid');
                let msgElem = pt.querySelector('#error');
                msgElem.textContent = '';
                this.isFormvalide = true
            }
            // checking body
            if (this.Fdata.message.trim() == '') {
                let pt = body.parentNode;
                body.classList.add('invalid');
                let msgElem = pt.querySelector("#error");
                msgElem.textContent = 'Message  is required!'
                this.isFormvalide = false

            } else {
                let pt = body.parentNode;
                body.classList.remove('invalid');
                let msgElem = pt.querySelector("#error");
                msgElem.textContent = '';
                this.isFormvalide = true
            }
            if (this.Fdata.message && this.Fdata.subject) {
                console.log(this.Fdata)
                this.isloading = true
                const resSend = await this.callApi('post', '/api/replyMail', this.Fdata)

                if (resSend.status === 200) {
                    this.success('Message sent successfully.')
                    this.Fdata.subject = ''
                    this.Fdata.message = ''
                    this.Fdata.to = ''
                    this.detailsModal = false
                }
                else {
                    if (resSend.status === 422) {
                        for(let i in resSend.data.errors){
                            this.error(resSend.data.errors[i][0])
                        }
                        this.isloading = false

                    }
                    this.swr()
                    this.isloading = false
                }
                this.isloading = false
            }

         
        }
    },
            

    
    // fetching messages
    async created(){
        this.data.username =this.$store.state.user.USER_NAME
        const [res, resUnread,resUsers] = await Promise.all([
            this.callApi('get', `/api/getMessages/${this.$store.state.user.USER_NAME}`),
            this.callApi('get', `/api/unreadMessages/${this.$store.state.user.USER_NAME}`),
            this.callApi('get', `/api/getMessageUsers/${this.$store.state.user.USER_NAME}`)

        ])

        if (res.status == 200){
            this.Messages =res.data
        } else {
            this.swr('Something went Wrong! Please try again later!')
        }

        if (resUnread.status==200){
            this.data.unread = resUnread.data
        } else {
            this.swr ("Something went wrong!")
        }
        if (resUsers.status==200){
            this.users = resUsers.data
        } else {
            this.swr ("Something went wrong!")
        }
       
    }

   
};
</script>
