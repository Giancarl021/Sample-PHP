import Api from './common/api.js';

const api = new Api();

const items = await api.get('/list.php');

const tbody = document.querySelector('tbody');
let html = '';

const formatter = new Intl.NumberFormat('pt-BR');

for (const item of items) {
    html += `
        <tr>
            <td>${item.id}</td>
            <td>${item.name}</td>
            <td>${item.description}</td>
            <td>R$${formatter.format(item.price)}</td>
            <td><button class="button is-warning is-fullwidth">Editar</button></td>
            <td><button class="button is-danger is-fullwidth">Excluir</button></td>
        </tr>
    `;    
}

tbody.innerHTML = html;