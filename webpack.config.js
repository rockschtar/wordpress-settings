const path = require( 'path' );

/**
 * WordPress Dependencies
 */

const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );
const defaultEntryPoints = defaultConfig.entry();
const entryPoints = {
  ...defaultEntryPoints,
  'AjaxButton' : path.resolve('js/AjaxButton.js'),
  'FileUpload' : path.resolve('js/FileUpload.js'),
  'MediaUpload' : path.resolve('js/MediaUpload.js')

}

module.exports = {
  ...defaultConfig,
  ...{
    entry: entryPoints
  }
}
