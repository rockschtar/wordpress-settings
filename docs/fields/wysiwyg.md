# WYSIWYG

A full WordPress TinyMCE rich-text editor via `wp_editor()`.

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the field. **ID must be lowercase letters and underscores only** (TinyMCE requirement) |
| `setHeight(int $px)` | static | Editor height in pixels |
| `setWidth(int $px)` | static | Editor width in pixels |
| `setSettings(array $settings)` | static | Pass any `wp_editor()` settings array |
| `setDisabled(bool $value)` | static | Make the editor read-only |

## Example

```php
use Rockschtar\WordPress\Settings\Fields\WYSIWYG;

WYSIWYG::create('my_plugin_content')
    ->setLabel('Content')
    ->setHeight(300)
    ->setDescription('Supports full HTML formatting.')
    ->addToSection($section);
```

### With custom wp_editor settings

```php
WYSIWYG::create('my_plugin_email_body')
    ->setLabel('Email Template')
    ->setHeight(200)
    ->setSettings([
        'media_buttons' => false,
        'teeny'         => true,
    ])
    ->addToSection($section);
```

## Reading the value

```php
$content = get_option('my_plugin_content', '');
echo wpautop($content);
```

> **Note:** The field ID must match the pattern `[a-z_]+` — TinyMCE will not initialize if the ID contains hyphens or uppercase letters.
