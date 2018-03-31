import store from '../../store';

class Route {
    constructor(name, params = {}, absolute = true) {
        this.name = name;
        this.params = typeof params !== 'object'
            ? [params]
            : params;
        this.absolute = absolute;
        this.url = this.buildUrl();
    }

    get() {
        return this.url;
    }

    buildUrl() {
        const url = this.buildDomain()
            + store.state.routes[this.name].uri.replace(/^\//, '');

        return url.replace(
            // finds every "{param}" and replaces it with the appropriate key from this.params
            /{([^}]+)}/gi,
            tag => this.extractTag(tag),
        );
    }

    buildDomain() {
        if (this.name === undefined) {
            throw new Error('Route: You must provide a route name');
        }

        if (store.state.routes[this.name] === undefined) {
            throw new Error(`Route: route "${this.name}" is not found in the route list`);
        }

        return this.absolute
            ? `${(store.state.routes[this.name].domain || store.state.meta.appUrl).replace(/\/+$/, '')}/`
            : '/';
    }

    extractTag(tag) {
        // removes "{", "}" and optional "?" from the end
        const key = tag.replace(/\{|\}/gi, '').replace(/\?$/, '');

        if (Array.isArray(this.params)) {
            return this.params.length === 0
                ? this.throwMissingKeyError(key)
                : this.params.shift();
        }

        if (typeof this.params[key] === 'undefined') {
            return tag.indexOf('?') === -1
                ? this.throwMissingKeyError(key)
                : '';
        }

        return this.params[key].id || this.params[key];
    }

    throwMissingKeyError(key) {
        throw new Error(`Route Error: "${key}" key is required for route "${this.name}"`);
    }
}

export default Route;
