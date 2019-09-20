<?php
declare(strict_types = 1);

namespace Phauthentic\CustomHtml;

use DOMElement;

/**
 * Rename Tag
 */
class RenameTag
{
    /**
     * @var string
     */
    protected $newElementName = 'div';

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public static function create(string $newElementName)
    {
        $self = new self();
        $self->newTagName = $newElementName;

        return $self;
    }

    /**
     *
     */
    public function __invoke(DOMElement $oldElement)
    {
        $document = $oldElement->ownerDocument;

        $newElement = $document->createElement($this->newTagName);
        $oldElement->parentNode->replaceChild($newElement, $oldElement);

        foreach ($oldElement->attributes as $attribute) {
            $newElement->setAttribute($attribute->name, $attribute->value);
        }

        foreach (iterator_to_array($oldElement->childNodes) as $child) {
            $newElement->appendChild($oldElement->removeChild($child));
        }
    }
}
