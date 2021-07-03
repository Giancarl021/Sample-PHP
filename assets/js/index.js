import Api from './common/api.js';
import render from './common/render.js';
import { startModal, closeModal } from './common/modal.js';

const api = new Api();

const tbody = document.querySelector('tbody');
const addButton = document.querySelector('.add');

addButton.onclick = () => startModal(api);

[ ...document.querySelectorAll('.close-modal') ]
    .forEach(b => b.onclick = () => closeModal());

await render(api, tbody);