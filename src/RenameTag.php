<?php
namespace Phauthentic\CustomHtml;

class RenameTag {

	protected $newTagName = 'div';

	public function __construct() {
	}

	public static function create($newTagName) {
		$self = new self();
		$self->newTagName = $newTagName;

		return $self;
	}

	public function __invoke($oldTag) {
		$document = $oldTag->ownerDocument;

		$newTag = $document->createElement($this->newTagName);
		$oldTag->parentNode->replaceChild($newTag, $oldTag);

		foreach ($oldTag->attributes as $attribute) {
			$newTag->setAttribute($attribute->name, $attribute->value);
		}
		foreach (iterator_to_array($oldTag->childNodes) as $child) {
			$newTag->appendChild($oldTag->removeChild($child));
		}
	}
}
