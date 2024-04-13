const path = require( 'path' );

/**
 * WordPress Dependencies
 */

const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );
const defaultEntryPoints = defaultConfig.entry();
const entryPoints = {
  ...defaultEntryPoints,
  'AjaxButton' : path.resolve('js/AjaxButton.js'),
  'UploadFile' : path.resolve('js/UploadFile.js'),
  'UploadMedia' : path.resolve('js/UploadMedia.js')

}

module.exports = {
  ...defaultConfig,
  ...{
    entry: entryPoints
  }
}
