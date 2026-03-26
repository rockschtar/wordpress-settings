# Enqueue Assets

Scripts and stylesheets can be enqueued at three levels:

- **Page level** — loaded on every visit to the settings page
- **Field level** — loaded only when the field is rendered
- **Button level** — loaded when the button is rendered

## EnqueueScript

```php
use Rockschtar\WordPress\Settings\Enqueue\EnqueueScript;

$script = new EnqueueScript(
    handle: 'my-script',
    src:    plugins_url('js/my-script.js', __FILE__),
    ver:    '1.0.0',
    deps:   ['jquery'],
);

// Optional: load in footer
$script->setInFooter(true);

// Optional: localize data
$script->addLocalize('myData', [
    'ajaxUrl' => admin_url('admin-ajax.php'),
    'nonce'   => wp_create_nonce('my-nonce'),
]);

// Optional: add inline script
$script->addInlineScript('console.log("loaded")', 'after');

$page->addEnqueue($script);        // page level
$field->addEnqueue($script);       // field level
```

## EnqueueStyle

```php
use Rockschtar\WordPress\Settings\Enqueue\EnqueueStyle;

$style = new EnqueueStyle(
    handle: 'my-style',
    src:    plugins_url('css/my-style.css', __FILE__),
    ver:    '1.0.0',
);

$page->addEnqueue($style);
```

## Inline Script / Style

```php
use Rockschtar\WordPress\Settings\Enqueue\AddInlineScript;
use Rockschtar\WordPress\Settings\Enqueue\AddInlineStyle;

// Inline script — position: 'before' or 'after' (default)
$inline = AddInlineScript::create('my-script', 'var x = 1;', 'before');

// Inline style
$inlineStyle = AddInlineStyle::create('my-style', 'body { color: red; }');
```
