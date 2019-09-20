<?php
declare(strict_types = 1);

namespace Phauthentic\CustomHtml;

use DOMElement;

/**
 * Container
 */
class Container extends AbstractElement
{
    /**
     *
     */
    public static function create()
    {
        return new self();
    }

    /**
     *
     */
    public function __invoke(DOMElement $oldElement)
    {
        $newElement = $this->createNewElement($oldElement, 'div');
        $this->copyAttributes($oldElement, $newElement, ['fluid']);

        if ($oldElement->hasAttribute('fluid')) {
            $class = 'container-fluid';
        } else {
            $class = 'container';
        }

        if ($newElement->hasAttribute('class')) {
            $class .= $newElement->getAttribute('class');
        }

        $newElement->setAttribute('class', $class);
    }
}
