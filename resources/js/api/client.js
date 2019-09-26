import axios from 'axios';

axios.defaults.baseURL = window.location.href;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

let ENDPOINT_URL = 'advert';

export default {
    list: (data = null) => axios.get(`${ENDPOINT_URL}`, {params: data}),
    show: (id) => axios.get(`${ENDPOINT_URL}/${id}`),
    store: (data) => axios.post(`${ENDPOINT_URL}`, data),
    update: (data) => axios.post(`${ENDPOINT_URL}/update`, data),
    delete: (id) => axios.post(`${ENDPOINT_URL}/destroy`, {id: id}),
};

