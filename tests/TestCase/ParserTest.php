<?php
declare(strict_types = 1);

namespace Phauthentic\CustomHtml\Test\TestCase;

use Phauthentic\CustomHtml\Parser;
use PHPUnit\Framework\TestCase;

/**
 * Parser Test
 */
class ParserTest extends TestCase
{
    /**
     * @return void
     */
    public function testParse(): void
    {
        $html = file_get_contents('tests/Fixture/test.html');
        $parser = new Parser();
        $result = $parser->parse($html);
    }
}
