const path = require('path')
// vue.config.js
module.exports = {
  outputDir: '../../public/dist',
  filenameHashing: false,
  publicPath: '/',
  chainWebpack: config => {
    config.plugin('copy')
          .tap(args => {
            args[0].push({
              from: path.resolve(__dirname, 'src/assets'),
              to: path.resolve(__dirname, '../../public/dist/img'),
              toType: 'dir',
              ignore: ['.DS_Store']
            })
            return args
          })
  }
}
