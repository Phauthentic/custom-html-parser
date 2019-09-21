<?php
declare(strict_types = 1);

namespace Phauthentic\CustomHtml;

use DOMElement;

/**
 * Abstract Element
 */
abstract class AbstractElement implements ElementInterface
{
    /**
     * Invoke
     *
     * @param  \DOMElement $element
     * @return void
     */
    public abstract function __invoke(DOMElement $element): void;

    /**
     * Injects a piece of HTML to the DOM
     *
     * @param \DOMElement $oldElement Element
     * @param string $html Html to inject
     * @return \DOMDocumentFragment
     */
    protected function createFragment(DOMElement $oldElement, string $html)
    {
        $fragment = $oldElement->ownerDocument->createDocumentFragment();
        $fragment->appendXML($html);

        return $fragment;
    }

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
        $newElement = $document->createElement($name);
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
     */
    protected function copyAttributes(DOMElement $existingElement, DOMElement $newElement, array $excludedAttributes = []): void
    {
        foreach ($existingElement->attributes as $attribute) {
            if (in_array((string)$attribute->name, $excludedAttributes)) {
                continue;
            }

            $newElement->setAttribute($attribute->name, $attribute->value);
        }
    }

    /**
     * Gets all CSS classes from an element
     *
     * @param \DOMElement $element Element
     * @return array
     */
    public function getCssClasses(DOMElement $element): array
    {
        $classes = (string)$element->getAttribute('class');

        return explode(' ', $classes);
    }

    /**
     * Checks if an element has a CSS class
     *
     * @param \DOMElement $element Element
     * @param string $class Class
     * @return void
     */
    public function hasCssClass(DOMElement $element, $class): bool
    {
        $classes = $this->getCssClasses($element);

        return in_array($classes, $class);
    }

    /**
     * Adds a CSS class to an element
     *
     * @param \DOMElement $element Element
     * @param string $class Class
     * @return void
     */
    public function addCssClass(DOMElement $element, $class): void
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
     * Removes a CSS class from an element
     *
     * @param \DOMElement $element Element
     * @param string $class Class
     */
    public function removeCssClass(DOMElement $element, $class): void
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
