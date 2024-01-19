<template>
    <div class="file-section bottom-header ">
        <div class="text-center" v-if="isLoading">Loading</div>
        <div class="text-center" v-else-if="attachments.length === 0">No attachments yet</div>
        <ul style="list-style:none;" class="download-lists" v-else>
            <li class="d-flex justify-content-between download-item" v-for="(attachment, i) in attachments" :key="i">
                <span class="text-primary">{{attachment.attachment_name ||'Unnamed attachmet'}}</span>
                <a :href="`${attachment.attachment_link}`" class="download-rounded" download>
                    <i class="bx bxs-download "></i>
                </a>
                <i v-if="stage =='sent-back'"  class=" bx bxs-minus-circle" @click="deleteAttachment(attachment)"></i>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props:['stage'],
  data() {
    return {
        caseId: this.$route.params.caseId,
        attachments: [],
        isLoading: true
    }
  },
  methods:{
    async getAttachment(){
        this.isLoading = false
        const res = await this.callApi('get', `/api/fetchAttachments/${this.caseId}`)
        if (res.status == 200) {
        this.attachments = res.data
        }
        else {
        this.swr("Ooops! error getting document")
        }
    },
    async deleteAttachment(attachment) {
        this.isLoading = false
        const res2 = await this.callApi('delete', `/api/deleteAttachment/${this.caseId}/${attachment.id}`)
        if (res2.status == 200) {
            this.attachments = this.attachments.filter(a => a.id !== attachment.id)
        }else{
            this.swr("Ooops! Couldn't delete attachment")
        }
    }

  },
    created() {
        this.getAttachment()
  }
}
</script>