# UploadMedia

Opens the WordPress media library to select an attachment. The stored value is an array with `attachment_id`, `media_url`, and `icon_url` keys.

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field |
| `setUploadButtonText(string $text)` | static | Label on the select button (default: `Upload`) |
| `setRemoveButtonText(string $text)` | static | Label on the remove button (default: `Remove`) |
| `setDisabled(bool $value)` | static | Disable the field |

## Example

```php
use Rockschtar\WordPress\Settings\Fields\UploadMedia;

UploadMedia::create('my_plugin_logo')
    ->setLabel('Logo')
    ->setUploadButtonText('Select Logo')
    ->setRemoveButtonText('Remove Logo')
    ->setDescription('Select an image from the media library.')
    ->addToSection($section);
```

## Reading the value

```php
$media = get_option('my_plugin_logo');

if (is_array($media) && !empty($media['attachment_id'])) {
    $attachmentId = (int) $media['attachment_id'];
    $imageUrl     = $media['media_url'];

    echo wp_get_attachment_image($attachmentId, 'thumbnail');
}
```
