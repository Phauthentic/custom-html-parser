<?php
namespace Phauthentic\CustomHtml;

class Container {

	public function __construct() {
	}

	public static function create() {
		return new self();
	}

	public function __invoke($oldTag) {
		$document = $oldTag->ownerDocument;

		/**
		 * @var $oldTag \DOMElement
		 */
		if ($oldTag->hasAttribute('fluid')) {
			$class = 'container-fluid';
		} else {
			$class = 'container';
		}

		$newTag = $document->createElement('div');
		$oldTag->parentNode->replaceChild($newTag, $oldTag);

		foreach ($oldTag->attributes as $attribute) {
			if ($attribute->name === 'fluid') {
				continue;
			}

			$newTag->setAttribute($attribute->name, $attribute->value);
		}

		foreach (iterator_to_array($oldTag->childNodes) as $child) {
			$newTag->appendChild($oldTag->removeChild($child));
		}

		/**
		 * @var $newTag \DOMElement
		 */
		$newTag->setAttribute('class', $class);
	}
}
