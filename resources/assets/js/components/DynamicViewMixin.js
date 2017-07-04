import axios from 'axios';

import { lang } from '../mixins/Localization';

export default {
    data() {
        return {
            data:null,
            layout:null,

            ready:false,
        }
    },
    methods: {
        get() {
            if(this.test) return;
            return axios.get(this.apiPath).then(response=>{
                    this.mount(response.data);
                    this.ready = true;
                this.glasspane.$emit('hide');
                    return Promise.resolve(response);
                })
                .catch(error=>{
                    this.glasspane.$emit('hide');
                    return Promise.reject(error);
                });
        },
        post() {
            this.glasspane.$emit('show');
            return axios.post(this.apiPath, this.data).then(response=>{
                this.glasspane.$emit('hide');
                    return Promise.resolve(response);
                })
                .catch(error=>{
                    this.glasspane.$emit('hide');
                    return Promise.reject(error);
                });
        }
    },
    created() {
        axios.interceptors.response.use(response => response, error => {

            let modalOptions = {
                title: lang(`modals.${error.response.status}`),
                text: error.response.data.message,
                isError: true
            };

            switch(error.response.status) {
                case 401: this.actionsBus.$emit('showMainModal', {
                    ...modalOptions,
                    okCallback() {
                        location.href = '/sharp/login';
                    },
                });
                    break;
                case 403: this.actionsBus.$emit('showMainModal', {
                    ...modalOptions,
                    okCloseOnly:true,
                });
                    break;
            }
            return Promise.reject(error);
        });

        this.glasspane.$emit('show');
    }
}