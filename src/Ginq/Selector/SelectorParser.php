<?php
/**
 * Ginq: `LINQ to Object` inspired DSL for PHP
 * Copyright 2013, Atsushi Kanehara <akanehara@gmail.com>
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * PHP Version 5.3 or later
 *
 * @author     Atsushi Kanehara <akanehara@gmail.com>
 * @copyright  Copyright 2013, Atsushi Kanehara <akanehara@gmail.com>
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package    Ginq
 */

namespace Ginq\Selector;

use Ginq\Core\Selector;

class SelectorParser
{
    /**
     * @param \Closure|string|int|Selector $src
     * @param Selector $default
     * @throws \InvalidArgumentException
     * @return Selector
     */
    static public function parse($src, $default)
    {
        if (is_null($src)) {
            return $default;
        }

        if (is_string($src)) {
            return PathSelector::parse($src);
        }

        if (is_callable($src)) {
            return new DelegateSelector($src);
        }

        if ($src instanceof Selector) {
            return $src;
        }

        $type = gettype($src);
        throw new \InvalidArgumentException(
            "'selector' Closure or string or expected, got $type");
    }
}

