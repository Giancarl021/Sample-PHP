export default function (endpoint = window.location.pathname + 'api') {
    async function _fetch(uri, options = {}) {
        console.log(endpoint + uri);
        return await (await fetch(endpoint + uri, options)).json();
    }

    async function get(uri) {
        return await _fetch(uri);
    }

    return {
        get
    };
}