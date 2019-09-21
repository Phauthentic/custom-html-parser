<?php
declare(strict_types = 1);

namespace Phauthentic\CustomHtml;

/**
 * ArrayDotAccessTrait
 */
trait ArrayDotAccessTrait
{
    /**
     * Access an array via dot notation
     *
     * @param array Array Data
     * @param string $path Path
     * @param mixed $default Default
     * @return mixed
     */
    protected function dotAccess(array $array, string $path, $default = null)
    {
        $current = $array;
        $p = strtok($path, '.');

        while ($p !== false) {
            if (!isset($current[$p])) {
                return $default;
            }
            $current = $current[$p];
            $p = strtok('.');
        }

        return $current;
    }
}
