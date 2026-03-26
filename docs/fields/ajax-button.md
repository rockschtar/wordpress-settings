# AjaxButton

A button that triggers a server-side PHP callback via AJAX — without saving the settings form. Useful for actions like clearing a cache, testing a connection, or running an import.

Buttons can be placed in two locations:

- **Inside a section** (via `addToSection()` or `section->addField()`) — renders inline with the fields
- **Page level** (via `page->addButton()`) — renders next to the Submit button

## Methods

Inherits all [common field options](/settings-page#common-field-options) plus:

| Method | Type | Description |
|---|---|---|
| `create(string $id)` | static | Create the button |
| `setButtonLabel(string $label)` | static | Button text |
| `setLabelWait(string $label)` | static | Text while request is in progress (default: `Please wait`) |
| `setLabelSuccess(string $label)` | static | Text on success (reverts after 3 s) |
| `setLabelError(string $label)` | static | Text on error (reverts after 3 s) |
| `setCallable(callable $fn)` | static | PHP callback executed on the server |
| `setDisabled(bool $value)` | static | Disable the button |
| `setPosition(string $pos)` | static | `Button::POSITION_FORM`, `POSITION_BEFORE_SUBMIT`, `POSITION_AFTER_SUBMIT` |
| `setJSCallbackSuccess(string $fn)` | static | JS function name called on success (dot-notation) |
| `setJSCallbackError(string $fn)` | static | JS function name called on error |
| `setJSCallbackDone(string $fn)` | static | JS function name called always (after success or error) |

### Server callback

The callable receives the `AjaxButton` instance and must call `wp_send_json_success()` or `wp_send_json_error()`:

```php
function (AjaxButton $button): void {
    // do work …
    wp_send_json_success('Done!');
    // or
    wp_send_json_error('Something went wrong.', 500);
}
```

The data passed to `wp_send_json_success($data)` is displayed as the button label when `setLabelSuccess()` is empty.

## Examples

### Clear cache button

```php
use Rockschtar\WordPress\Settings\Fields\AjaxButton;

AjaxButton::create('my_plugin_clear_cache')
    ->setButtonLabel('Clear Cache')
    ->setLabelWait('Clearing…')
    ->setLabelSuccess('Cache cleared!')
    ->setLabelError('Failed')
    ->setCallable(static function (): void {
        my_plugin_clear_cache();
        wp_send_json_success('Cache cleared successfully.');
    })
    ->setDescription('Manually flush the plugin cache.')
    ->addToSection($section);
```

### Test API connection (page-level button)

```php
$button = AjaxButton::create('my_plugin_test_api')
    ->setButtonLabel('Test Connection')
    ->setLabelWait('Testing…')
    ->setLabelSuccess('Connected!')
    ->setLabelError('Failed — check your API key')
    ->setPosition(AjaxButton::POSITION_AFTER_SUBMIT)
    ->setCallable(static function (): void {
        $key    = get_option('my_plugin_api_key');
        $result = my_plugin_test_api($key);

        if ($result) {
            wp_send_json_success('Connection successful.');
        } else {
            wp_send_json_error('Could not connect to the API.', 422);
        }
    });

$page->addButton($button);
```

### With JS callback

```php
AjaxButton::create('my_plugin_export')
    ->setButtonLabel('Export')
    ->setLabelWait('Exporting…')
    ->setJSCallbackSuccess('MyPlugin.onExportSuccess')
    ->setCallable(static function (): void {
        $url = my_plugin_generate_export();
        wp_send_json_success(['download_url' => $url]);
    })
    ->addToSection($section);
```

```js
window.MyPlugin = {
    onExportSuccess(response) {
        window.location.href = response.data.download_url;
    }
};
```

## Form field values

The AJAX request includes all `<input>` and `<select>` values from the settings form, keyed by their field IDs. Access them inside your callable via `$_POST['fields']`:

```php
->setCallable(static function (): void {
    $fields = $_POST['fields'] ?? [];
    $apiKey = sanitize_text_field($fields['my_plugin_api_key'] ?? '');
    // test with the current (unsaved) key value
    wp_send_json_success();
})
```
