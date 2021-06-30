import createApi from './api.js';

const api = createApi();

console.log(await api.get('/index.php'));