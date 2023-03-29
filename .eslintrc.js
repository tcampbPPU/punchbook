process.env.ESLINT_TSCONFIG = 'tsconfig.json'

module.exports = {
  extends: '@antfu',
  rules: {
    'antfu/top-level-function': 'off',
    'vue/html-self-closing': [
      'error',
      {
        html: {
          void: 'always',
          normal: 'never',
          component: 'always',
        },
        svg: 'always',
        math: 'always',
      },
    ],
  },
}
