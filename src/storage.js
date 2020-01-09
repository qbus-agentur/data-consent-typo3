function Storage(type) {
    this.type = type || 'localstorage';
    if (this.type === 'cookie') {
        this.object = new Cookies();
    }
};

Storage.prototype.set = function(key, data) {
    if (this.type === 'localstorage') {
        window.localStorage.setItem(key, JSON.stringify(data));
    } else {
        this.object.set(key, data);
    }
}

Storage.prototype.get = function(key) {
    if (this.type === 'localstorage') {
        try {
            var value = window.localStorage.getItem(key);
            return value && JSON.parse(value);
        } catch (e) {
            return false;
        }
    } else {
        return this.object.get(key);
    }
}

export default Storage;
