import Api from './api.js';

const api = new Api();

console.log(await api.get('/index.php'));