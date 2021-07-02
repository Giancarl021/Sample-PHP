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
        const response = await fetch(this.#endpoint + uri, options);

        let json;
        try {
            json = await response.json();
        } catch (err) {
            return null;
        }

        return json;
    }

    async get(uri) {
        return await this.#request(uri);
    }

    async post(uri, data) {
        return await this.#request(uri, {
            method: 'POST',
            body: new URLSearchParams(data)
        });
    }
}