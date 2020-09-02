// rollup.config.js
import resolve from '@rollup/plugin-node-resolve';
import { terser } from "rollup-plugin-terser";
import copy from 'rollup-plugin-copy'

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
        copy({
            targets: [
                { src: 'node_modules/es6-promise/dist/es6-promise.auto.min.js', dest: 'Resources/Public/JavaScript/' }
            ],
            verbose: true,
            copyOnce: true
        }),
    ],
    external: [ 'es6-promise' ],
}
