const dotenv = require('dotenv');
const dotenvExpand = require('dotenv-expand');
var myEnv = dotenv.config({path: '../.env'});
dotenvExpand(myEnv);

module.exports = {
  // outputDir: 'glp',
  filenameHashing: false,
  indexPath: 'xxx.welcome.blade.php',
  devServer: {
     // host: 'https://worktest.client'
	 proxy: 'https://finalf.badmintonclub.ro.mydev'

  },
  configureWebpack: {}
}
