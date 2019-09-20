<?php
declare(strict_types = 1);

require_once '../vendor/autoload.php';

use Phauthentic\CustomHtml\Parser;

$html = file_get_contents('../tests/Fixture/test.html');

$parser = new Parser();

$parser->addTag('test', \Phauthentic\CustomHtml\RenameTag::create('othertag'));
$parser->addTag('container', \Phauthentic\CustomHtml\Container::create());
$parser->addTag('bsinput', \Phauthentic\CustomHtml\FragmentTag::create());
$parser->addTag('var', \Phauthentic\CustomHtml\VarTag::create([
    'test' => 'hello!',
    'test2' => 'Hello after!'
]));
$parser->addTag('col', function($oldTag) {
    $document = $oldTag->ownerDocument;

    $newTag = $document->createElement('div');
    $oldTag->parentNode->replaceChild($newTag, $oldTag);

    foreach (iterator_to_array($oldTag->childNodes) as $child) {
        $newTag->appendChild($oldTag->removeChild($child));
    }

    /**
     * @var $newTag \DOMElement
     */
    $newTag->setAttribute('class', 'col');
});

echo $parser->parse($html);
