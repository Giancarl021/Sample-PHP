import { openModal } from './modal.js';

export default async function render(api, tbody) {
    const items = await api.get('/list.php');

    if (!items || !items.length) {
        tbody.innerHTML = '';
        return;
    }

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

    [...document.querySelectorAll('.remove')]
        .forEach(b => b.onclick = () => remove(b));

    [...document.querySelectorAll('.edit')]
        .forEach(b => b.onclick = () => edit(b));

    async function remove(element) {
        const id = element
            .parentElement
            .parentElement
            .querySelector('td:first-child')
            .innerText;

        await api.post('/delete.php', { id });

        await render(api, tbody);
    }

    async function edit(element) {
        const row = element.parentElement.parentElement;

        const [id, name, description, priceString] = [...row.querySelectorAll('td')].map(e => e.innerText);

        const price = priceString.replace(/\D/g, '');

        const data = {
            id,
            name,
            description,
            price
        };

        openModal(api, render.bind(null, api, tbody), data);
    }
}