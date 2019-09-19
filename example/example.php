<?php
require_once '../vendor/autoload.php';

$html = '<html>
	<container>
		<col>
			<p>
				<test attribute="test" attribute2="this">test<br />content with other tags</test>
			</p>
		</col>
		<col>
			test col
		</col>
	</container>
	<container fluid="true"><test>dsdshsh</test></container>
</html>';

$parser = new \Phauthentic\CustomHtml\DomParser($html);

$parser->addTag('test', \Phauthentic\CustomHtml\RenameTag::create('othertag'));
$parser->addTag('container', \Phauthentic\CustomHtml\Container::create());
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

echo $parser->replace();
