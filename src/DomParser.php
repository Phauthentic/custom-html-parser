<?php
namespace Phauthentic\CustomHtml;

use DOMDocument;
use DOMXPath;

class DomParser {

	/**
	 * @var array
	 */
	protected $tags = [];

	/**
	 * @var \DOMDocument
	 */
	protected $document;

	/**
	 * @var \DOMXPath
	 */
	protected $xpath;

	/**
	 * @var string $html HTML
	 */
	public function __construct($html)
	{
		$this->document = new DOMDocument();
		$this->document->loadXML($html);

		$this->xpath = new DOMXPath($this->document);
	}

	public function addTag(string $name, callable $callable)
	{
		$this->tags[$name] = $callable;
	}

	public function replace() {
		foreach ($this->tags as $name => $callable) {
			$elements = $this->xpath->query("//" . $name);

			foreach ($elements as $element) {
				$callable($element, $this->document);
			}
		}

		return $this->document->saveHTML();
	}
}
