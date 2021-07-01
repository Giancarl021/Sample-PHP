import Api from './common/api.js';

const api = new Api();

console.log(await api.get('/index.php'));