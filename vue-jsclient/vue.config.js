const dotenv = require('dotenv');
const dotenvExpand = require('dotenv-expand');
var myEnv = dotenv.config({path: '../.env'});
dotenvExpand(myEnv);

module.exports = {
  // outputDir: 'glp',
  filenameHashing: false,
  // indexPath: 'xxx.welcome.blade.php',
  devServer: {
      proxy: 'https://finalf.badmintonclub.ro.mydev'
  },
  configureWebpack: {
  },
  css: {
        loaderOptions: {
            scss: {
                prependData:    `@import "@/scss/integrate/invoice.scss";`
              }
        }
    }
}
