# Custom HTML Tags

You might know that you can create custom HTML tags using JS frameworks like Vue.js or React. This library allows you to do this in php as well and to turn your custom HTML into something else.

**This library is NOT ready for production! Work in progress!**

## Simple Example

This will just rename a tag:

```php
$html = '<div><my-funky-tag class="test" /></div>'

$parser = new Phauthentic\CustomHtml\Parser();
$parser->addTag('my-funky-tag', \Phauthentic\CustomHtml\RenameTag::create('other-tag'));

echo $parser->parse();
```

The above should output:

```html
<div><other-tag class="test" /></div>
```

You can add whatever transformation you want by adding a callable via `Parser::add`.

## License & Copyright

Copyright Florian Krämer

[MIT](license.txt)
