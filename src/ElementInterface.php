<?php
declare(strict_types=1);

namespace Phauthentic\CustomHtml;

use DOMElement;

/**
 *
 */
interface ElementInterface
{
    /**
     *
     */
    public function __invoke(DOMElement $element): void;
}
