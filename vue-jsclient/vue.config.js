const dotenv = require('dotenv');
const dotenvExpand = require('dotenv-expand');
var myEnv = dotenv.config({path: '../.env'});
dotenvExpand(myEnv);

module.exports = {
  // outputDir: 'glp',
  filenameHashing: false,
  // indexPath: 'xxx.welcome.blade.php',
  devServer: {
	 //changeOrigin: true,
     // host: 'finalf.badmintonclub.ro.mydev',
	 proxy:

	      // https://cli.vuejs.org/config/#devserver-proxy
	 {
	 	    target: 'https://finalf.badmintonclub.ro.mydev',
		    //changeOrigin: true
	 }
	  //proxy: 'http://localhost:8080'


  },
  configureWebpack: {}
}
