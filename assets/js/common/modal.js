export function openModal(api, render, data = null) {
    const modal = document.querySelector('.modal');
    const submitButton = modal.querySelector('.modal-submit');

    modal.classList.add('is-active');

    if (data) {
        modal.querySelector('.modal-input-id').style.display = 'block';
        fill(data);
        submitButton.onclick = () => edit(api, render);
        submitButton.innerText = 'Editar';
    } else {
        modal.querySelector('.modal-input-id').style.display = 'none';
        empty();
        submitButton.onclick = () => add(api, render);
        submitButton.innerText = 'Adicionar';
    }
}

export function closeModal() {
    document.querySelector('.modal').classList.remove('is-active');
}

async function add(api, render) {
    const data = serialize();
    if (!data) return;
    await api.post('/create.php', data);
    closeModal();
    await render();
}

async function edit(api, render) {
    const data = serialize();
    if (!data) return;
    await api.post('/edit.php', data);
    closeModal();
    await render();
}

function fill(data) {
    const inputs = getInputs();

    for (const key in data) {
        inputs[key].value = data[key];
    }
}

function empty() {
    const inputs = getInputs();
    for (const key in inputs) {
        inputs[key].value = '';
    }
}

function serialize() {
    const inputs = getInputs();

    const data = {};
    let isValid = true;

    for (const key in inputs) {
        const input = inputs[key];

        input.classList.remove('is-danger');

        const { value } = input;

        if (!value && key !== 'id') {
            input.classList.add('is-danger');
            isValid = false;
        }

        if (value <= 0 && key === 'price') {
            input.classList.add('is-danger');
            isValid = false;
        }

        if (value) {
            data[key] = value;
        }
    }

    if (!isValid) {
        return null;
    }

    return data;
}

function getInputs() {
    return {
        id: document.querySelector('.modal-input-id input'),
        name: document.querySelector('.modal-input-name input'),
        description: document.querySelector('.modal-input-description textarea'),
        price: document.querySelector('.modal-input-price input')
    };
}