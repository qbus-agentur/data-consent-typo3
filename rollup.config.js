// rollup.config.js
import resolve from '@rollup/plugin-node-resolve';

export default {
  input: 'src/index.js',
  output: {
    file: 'data-consent.js',
    format: 'umd',
    name: 'DataConsent',
    globals: {
      'es6-promise': 'Promise'
    },
  },
  plugins: [
    resolve({
      mainFields: ['module', 'main'],
      modulesOnly: true
    }),
  ],
  external: [ 'es6-promise' ],
}
