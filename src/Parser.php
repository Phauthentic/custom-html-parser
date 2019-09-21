<?php
declare(strict_types = 1);

namespace Phauthentic\CustomHtml;

use DOMDocument;
use DOMXPath;

/**
 * Parser
 */
class Parser
{
    /**
     * @var array
     */
    protected $tags = [];

    /**
     * @var bool
     */
    protected $noLibXmlError = true;

    /**
     * @var array $tags Tags
     */
    public function __construct(array $tags = [])
    {
        foreach ($tags as $name => $callable) {
            $this->addTag($name, $callable);
        }
    }

    /**
     * Adds a new element handler
     *
     * @param string   $name     Element name
     * @param callable $callable Callable
     */
    public function addTag(string $name, callable $callable)
    {
        $this->tags[$name] = $callable;
    }

    /**
     * Parses the HTML
     *
     * @param  string $html HTML string
     * @return string
     */
    public function parse(string $html): string
    {
        $document = new DOMDocument();
        if ($this->noLibXmlError) {
            $document->loadHTML($html, LIBXML_NOERROR);
        } else {
            $document->loadHTML($html);
        }

        $xpath = new DOMXPath($document);

        foreach ($this->tags as $name => $callable) {
            $elements = $xpath->query("//" . $name);
            foreach ($elements as $element) {
                $callable($element, $document);
            }
        }

        return $document->saveHTML();
    }
}
