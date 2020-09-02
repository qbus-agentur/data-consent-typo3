// rollup.config.js
import resolve from '@rollup/plugin-node-resolve';
import { terser } from "rollup-plugin-terser";

export default {
    input: 'src/index.js',
    output: [
        {
            file: 'data-consent.js',
            format: 'umd',
            name: 'DataConsent',
            globals: {
                'es6-promise': 'Promise'
            },
        },
        {
            file: 'data-consent.min.js',
            format: 'umd',
            name: 'DataConsent',
            globals: {
                'es6-promise': 'Promise'
            },
            plugins: [terser()]
        },
        {
            file: 'Resources/Public/JavaScript/data-consent.min.js',
            format: 'umd',
            name: 'DataConsent',
            globals: {
                'es6-promise': 'Promise'
            },
            plugins: [terser()]
        }
    ],
    plugins: [
        resolve({
            mainFields: ['module', 'main'],
            modulesOnly: true
        }),
    ],
    external: [ 'es6-promise' ],
}
