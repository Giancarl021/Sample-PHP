export default class Api {
    #endpoint
    constructor(endpoint = window.location.pathname + 'api') {
        this.#endpoint = endpoint;
    }

    get endpoint() {
        return this.#endpoint;
    }

    set endpoint(endpoint) {
        this.#endpoint = endpoint;
    }

    async #request(uri, options = {}) {
        return await (await fetch(this.#endpoint + uri, options)).json();
    }

    async get(uri) {
        return await this.#request(uri);
    }
}