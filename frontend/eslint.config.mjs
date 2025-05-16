import js from '@eslint/js'
import pluginVue from 'eslint-plugin-vue'
import pluginVitest from '@vitest/eslint-plugin'
import skipFormatting from '@vue/eslint-config-prettier/skip-formatting'
import eslintPluginPromise from 'eslint-plugin-promise'
import globals from 'globals'
import eslintrcImport from './.eslintrc-auto-import.json' with { type: 'json' }

export default [
  { name: 'app/files-to-lint', files: ['**/*.{js,mjs,jsx,vue}'] },
  { name: 'app/files-to-ignore', ignores: ['**/dist/**', '**/dist-ssr/**', '**/coverage/**'] },
  {
    name: 'app/rules-override',
    rules: {
      'no-unused-vars': [
        'error',
        { varsIgnorePattern: '^_', caughtErrorsIgnorePattern: '^_', argsIgnorePattern: '^_' }
      ],
      'vue/valid-v-slot': [
        'error',
        {
          allowModifiers: true
        }
      ]
    }
  },
  // JS
  js.configs.recommended,
  // PROMESAS
  eslintPluginPromise.configs['flat/recommended'],
  // VUE
  ...pluginVue.configs['flat/recommended'],
  // VITEST
  { ...pluginVitest.configs.recommended, files: ['src/**/__tests__/*'] },
  // PRETTIER SKIP
  skipFormatting,
  // GLOBALS
  {
    languageOptions: {
      globals: { ...globals.browser, ...globals.node, ...eslintrcImport.globals }
    }
  }
]
