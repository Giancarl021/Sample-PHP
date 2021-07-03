export function startModal(api, data = null) {
    const modal = document.querySelector('.modal');

    modal.classList.add('is-active');

    if (data) {
        modal.querySelector('.modal-input-id').style.display = 'block';
    } else {
        modal.querySelector('.modal-input-id').style.display = 'none';
    }
}

export function closeModal() {
    document.querySelector('.modal').classList.remove('is-active');
}

async function add(api, data) {
    await api.post('/create.php', data);
}

async function edit(api, data) {
    await api.post('/edit.php', data);
}