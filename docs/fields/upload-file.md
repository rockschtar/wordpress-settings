# UploadFile

A file upload field. The file is saved to the WordPress uploads directory and the stored value is an array with `file` (server path) and `url` (public URL) keys.

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field |
| `addAllowedMimeType(string $ext, string $mime)` | static | Allow a specific MIME type |
| `setAppendMimeTypes(bool $value)` | static | Append to (default `true`) or replace the global allowed MIME list |
| `setUploadDirectory(string $path)` | static | Override the upload directory path |
| `setUploadUrl(string $url)` | static | Override the upload directory URL |
| `setReadonly(bool $value)` | static | Read-only |
| `setDisabled(bool $value)` | static | Disabled |

## Example

```php
use Rockschtar\WordPress\Settings\Fields\UploadFile;

UploadFile::create('my_plugin_import_file')
    ->setLabel('Import File')
    ->addAllowedMimeType('csv', 'text/csv')
    ->addAllowedMimeType('json', 'application/json')
    ->setDescription('Upload a CSV or JSON import file.')
    ->addToSection($section);
```

### Custom upload directory

```php
UploadFile::create('my_plugin_config')
    ->setLabel('Config File')
    ->addAllowedMimeType('json', 'application/json')
    ->setUploadDirectory(WP_CONTENT_DIR . '/my-plugin/config')
    ->setUploadUrl(WP_CONTENT_URL . '/my-plugin/config')
    ->addToSection($section);
```

## Reading the value

```php
$upload = get_option('my_plugin_import_file');

if (is_array($upload) && !empty($upload['url'])) {
    $fileUrl  = $upload['url'];
    $filePath = $upload['file'];
}
```
