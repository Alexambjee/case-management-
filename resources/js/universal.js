import {mapGetters} from 'vuex'
export default {
    data() {
        return {

        }
        this.$Loading.config({
            color: '#5cb85c',
            failedColor: '#f0ad4e',
            height: 5
        });
    },
    methods: {
        async callApi(method, url, dataObj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });

            } catch (e) {
                console.log(e)
                return e.response
            }
        },


        // test(desc,background="error"){
        //     this.$Message[desc]({
        //         background: background,
        //         content: desc
        //     });
        //     }
        // },
        swr(desc = "something went wrong! please try again.", title = "oops!") {
            this.$Notice.error({
                title: title,
                desc: desc,
                top: 150,
            });

        },
        // info(desc) {
        //     this.$Message.error({
        //         content: desc,
        //         duration: 10,
        //         bottom: 150,
        //         closable: true
        //     });
        // },
        info(desc, title = "Hey") {
            this.$Notice.info({
                title: title,
                desc: desc,
                top:50
            });
        },
        success(desc, title = "Great!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        warning(desc, title = "oops!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        error(desc, title = "Oops!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        async logout() {
            sessionStorage.removeItem('sxt-user');
            localStorage.removeItem('sxt-user');
            localStorage.removeItem('primary-permission');
            localStorage.removeItem('role');
            document.cookie.split(';').forEach(function (c) {
              document.cookie = c
                .replace(/^ +/, '')
                .replace(/=.*/, '=;expires=' + new Date().toUTCString() + ';path=/');
            });
            this.$store.commit('setUpdatedUser', null);
            location.href = `/api/logout`;
          },
       
    },
    computed: {
        ...mapGetters({
            'userRole': 'getUserRole'
        }),
    }
}