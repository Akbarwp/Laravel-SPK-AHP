import axios from 'axios';
import 'remixicon/fonts/remixicon.css';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
