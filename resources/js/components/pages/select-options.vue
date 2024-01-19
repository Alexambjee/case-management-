<template>
    <Select clearable required
        style="width: 100%;" 
        placeholder="Select Case Type"  v-model="data.Option">
        <Option :value="s.id" v-for="(s, i) in SelectOptions" :key="i" v-if="SelectOptions.length">{{s.SELECT_OPTION_NAME}}</Option>
    </Select>
</template>
<script>
export default {
    props:['type'],
    data() {
        return {
            data: {
                Type: this.type,
                id: null,
                Option:''
            },
            SelectOptions:[],

        }
    },
    async created() {
        const res = await this.callApi('get', `/api/fetchSelectOption/${this.data.Type}`)
        if (res.status == 200) {
            this.SelectOptions = res.data
        }
        else {
            this.swr('Something went wrong. Please try again later!')
        }
        
    }
}
</script>