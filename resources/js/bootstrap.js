import axios from 'axios';
window.axios = axios;

// Pastikan ini ada di bawah import
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';