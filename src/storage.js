function Storage(backend) {
    this.backend = backend || {
        get: function(key) {
            return window.localStorage.getItem(key);
        },
        set: function(key, value) {
            window.localStorage.setItem(key, value);
        }
    };
};

Storage.prototype.get = function(key) {
    try {
        var value = this.backend.get(key);
        return value && JSON.parse(value);
    } catch (e) {
        return false;
    }
}

Storage.prototype.set = function(key, data) {
    this.backend.set(key, JSON.stringify(data));
}

export default Storage;
