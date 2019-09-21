<?php
declare(strict_types = 1);

namespace Phauthentic\CustomHtml;

use DOMElement;

/**
 * Var Tag
 */
class VarTag
{
    use ArrayDotAccessTrait;

    /**
     * @var array
     */
    protected $vars = [];

    /**
     * Create
     *
     * @param array $vars Vars to set
     * @return $this
     */
    public static function create(array $vars = [])
    {
        $self = new self();
        $self->vars = $vars;

        return $self;
    }

    /**
     * @param array $vars Vars to set
     *
     * @return $this
     */
    public function setVars(array $vars)
    {
        $this->vars = $vars;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(DOMElement $oldTag)
    {
        $document = $oldTag->ownerDocument;

        $path = $oldTag->getAttribute('path');
        $value = $this->dotAccess($this->vars, $path);

        if (!is_string($value)
            && (
                is_object($value)
                && !method_exists('__toString')
            )
        ) {
            trigger_error(
                'Can`t convert data to string: %s ',
                E_USER_WARNING
            );
        }

        $oldTag->parentNode->replaceChild(
            $document->createTextNode((string)$value),
            $oldTag
        );
    }
}
