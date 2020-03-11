# Data Consent library based on Promises

## Installation

```bash
$ npm install --save @qbus/data-consent
```

## CSS Usage

### Usage with LESS

Add the following contents to your style.less file:

```less
@import (inline) "npm://@qbus/data-consent";
```

Adapt your less-css pipeline to include the `npm-import` plugin.

```bash
$ npm install --save-dev less-plugin-npm-import
$ lessc --npm-import style.less stlye.css
```


### Serve as separate CSS file

Serve the file `data-content.css` from your server or include https://unpkg.com/@qbus/data-consent@0.1.0-alpha.0/data-consent.css as stylesheet.


## JavaScript Usage

### Usage with browserify

To bundle `@qbus/data-consent` into a javascript bundle created with browserify,
the `esmify` plugin is required to support the ES6 module import/export syntax
used by `@qbus/data-consent`.

```bash
$ npm install --save-dev esmify
```

Add the following contents to your index.js file:

```js
var Consent = require('@qbus/data-consent').default;

var consent = new Consent({
    banner: true,
    functional: false
});
```

Adapt your browserify pipeline to include the `esmify` plugin.
The plugin will be enabled by passing `-p esmify` to the browserify command:


```bash
$ browserify -p esmify index.js -o bundle.js
```


### Usage with webpack

TODO

### Pre-bundled usage

TODO: Create bundle that can be served as raw js/css file from unkg.com or local server.
