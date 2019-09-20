<?php
declare(strict_types = 1);

namespace Phauthentic\CustomHtml;

use DOMElement;

/**
 * Abstract Element
 */
abstract class AbstractElement
{
    /**
     * Invoke
     *
     * @param  \DOMElement $element
     * @return void
     */
    public abstract function __invoke(DOMElement $element);

    /**
     * Creates a new element based on the old one with the new name
     *
     * @param  \DOMElement $existingElement
     * @param  string      $name            Name
     * @return \DOMElement
     */
    protected function createNewElement(DOMElement $existingElement, string $name)
    {
        /**
         * @var $document \DOMDocument
         * @var $newElement \DOMElement
         */
        $document = $existingElement->ownerDocument;
        $newElement = $document->createElement('div');
        $existingElement->parentNode->replaceChild($newElement, $existingElement);

        foreach (iterator_to_array($existingElement->childNodes) as $child) {
            $newElement->appendChild($existingElement->removeChild($child));
        }

        return $newElement;
    }

    /**
     * Copies attributes from old to new element
     *
     * @param  \DOMElement $existingElement    Old Tag
     * @param  \DOMElement $newElement         New Tag
     * @param  array       $excludedAttributes Exclude these attributes
     * @return \DOMElement
     */
    protected function copyAttributes(DOMElement $existingElement, DOMElement $newElement, array $excludedAttributes = [])
    {
        foreach ($existingElement->attributes as $attribute) {
            if (in_array($attribute->name, $excludedAttributes)) {
                continue;
            }

            $newElement->setAttribute($attribute->name, $attribute->value);
        }
    }

    /**
     *
     */
    public function getCssClasses(DOMElement $element): array
    {
        $classes = (string)$element->getAttribute('class');

        return explode(' ', $classes);
    }

    /**
     *
     */
    public function hasCssClass(DOMElement $element, $class)
    {
        $classes = $this->getCssClasses($element);

        return in_array($classes, $class);
    }

    /**
     *
     */
    public function addCssClass(DOMElement $element, $class)
    {
        if ($this->hasCssClass($element, $class)) {
            return;
        }

        $classes = $this->getCssClasses($element);
        $classes[] = $class;
        $classes = implode(' ', $classes);

        $element->setAttribute('class', $classes);
    }

    /**
     *
     */
    public function removeCssClass(DOMElement $element, $class)
    {
        if (!$this->hasCssClass($element, $class)) {
            return;
        }

        $classes = $this->getCssClasses($element);
        foreach ($classes as $index => $existingClass) {
            if ($existingClass === $class) {
                unset($classes[$index]);
                break;
            }
        }

        $element->setAttribute('class', implode(' ', $classes));
    }
}
