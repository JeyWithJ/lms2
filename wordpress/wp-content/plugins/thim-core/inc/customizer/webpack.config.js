const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );
 
 module.exports = {
     ...defaultConfig,
     entry: {
         'customizer': path.resolve( process.cwd(), 'src/App.ts' ),
         'preview': path.resolve( process.cwd(), 'src/Preview.ts' ),
     },
 
     output: {
         ...defaultConfig.output,
         path: path.resolve( process.cwd(), 'build/' ),
         publicPath: 'auto',
     },
 
     plugins: [
         ...defaultConfig.plugins,
     ],
 };