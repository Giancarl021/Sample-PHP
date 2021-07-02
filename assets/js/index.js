import Api from './common/api.js';

const api = new Api();

const tbody = document.querySelector('tbody');

await render();

async function render() {
    const items = await api.get('/list.php');

    if (!items || !items.length) return;

    let html = '';

    const formatter = new Intl.NumberFormat('pt-BR');

    for (const item of items) {
        html += `
        <tr>
            <td>${item.id}</td>
            <td>${item.name}</td>
            <td>${item.description}</td>
            <td>R$${formatter.format(item.price)}</td>
            <td><button class="button is-warning is-fullwidth edit">Editar</button></td>
            <td><button class="button is-danger is-fullwidth remove">Excluir</button></td>
        </tr>
    `;
    }

    tbody.innerHTML = html;

    [ ...document.querySelectorAll('.remove') ]
        .forEach(b => b.onclick = () => remove(b));
}

async function remove(element) {
    const id = element
        .parentElement
        .parentElement
        .querySelector('td:first-child')
        .innerText;

    await api.post('/delete.php', { id });

    render();
}