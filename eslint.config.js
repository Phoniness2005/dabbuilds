import js from '@eslint/js';
import globals from 'globals';

export default [
  js.configs.recommended,
  {
    files: [
      'custom/theme/dabbuilds-child/assets/custom.js',
      'custom/theme/dabbuilds-child/assets/lighting.js',
    ],
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: 'script',
      globals: globals.browser,
    },
    rules: {
      'no-var': 'error',
      'prefer-const': 'error',
      eqeqeq: ['error', 'always'],
      curly: ['error', 'all'],
      'no-eval': 'error',
      'no-implied-eval': 'error',
      'no-new-func': 'error',
      'no-script-url': 'error',
      'no-caller': 'error',
      'no-extend-native': 'error',
      'no-proto': 'error',
      'no-with': 'error',
      'no-alert': 'error',
      'no-console': 'error',
      'no-undef': 'error',
      'no-unused-vars': ['error', { argsIgnorePattern: '^_', caughtErrorsIgnorePattern: '^_' }],
      'no-redeclare': 'error',
      'no-shadow': 'error',
      'no-global-assign': 'error',
      'no-implicit-globals': 'error',
      strict: ['error', 'function'],
      'no-fallthrough': 'error',
      'no-labels': 'error',
      'no-iterator': 'error',
      'no-loop-func': 'error',
      'max-lines-per-function': ['error', {
        max: 60,
        skipBlankLines: false,
        skipComments: true,
        IIFEs: false,
      }],
    },
  },
];
