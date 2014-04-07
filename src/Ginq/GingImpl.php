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

namespace Ginq;

use Ginq\Comparer\DelegateComparer;
use Ginq\Core\EqualityComparer;
use Ginq\Core\IterProviderIterImpl;

class GinqImpl
{
    protected $equalityComparer;
    protected $iterProvider;

    /**
     * @param \Closure|Comparer $src
     * @param Comparer $default
     * @throws \InvalidArgumentException
     * @return \Ginq\Core\Comparer
     */
    public function resolveComparer($src, $default)
    {
        if (is_null($src)) {
            return $default;
        }
        if ($src instanceof \Closure) {
            return new DelegateComparer($src);
        }
        if ($src instanceof Comparer) {
            return $src;
        }
        $type = gettype($src);
        throw new \InvalidArgumentException(
            "'comparer' Closure expected, got $type");
    }

    /**
     * @param callable|EqualityComparer $src
     * @param EqualityComparer $default
     * @throws \InvalidArgumentException
     * @return \Ginq\Core\EqualityComparer
     */
    public function resolveEqualityComparer($src, $default)
    {
        if (is_null($src)) {
            return $default;
        }
        if (is_callable($src)) {
            return new DelegateComparer($src);
        }
        if ($src instanceof EqualityComparer) {
            return $src;
        }
        $type = gettype($src);
        throw new \InvalidArgumentException(
            "Invalid equality comparer, got $type");
    }

    /**
     * @param \Closure|JoinSelector|int $src
     * @param $default
     * @throws \InvalidArgumentException
     * @return JoinSelector
     */
    public function resolveJoinSelector($src, $default)
    {
        if (is_null($src)) {
            return $default;
        }
        if (is_callable($src)) {
            return new DelegateJoinSelector($src);
        }
        if (is_array($src)) {
            return new DelegateJoinSelector(Lambda::fun($src));
        }
        if ($src instanceof JoinSelector) {
            return $src;
        }
        $type = gettype($src);
        throw new \InvalidArgumentException(
            "Invalid selector, got $type");
    }

    /**
     * @param \Closure|string|int|Selector $src
     * @param Selector $default
     * @throws \InvalidArgumentException
     * @return Selector
     */
    static function resolveSelector($src, $default)
    {
        if (is_null($src)) {
            return $default;
        }
        if (is_callable($src)) {
            return new DelegateSelector($src);
        }
        if (is_string($src)) {
            return new PropertySelector($src);
        }
        if (is_array($src)) {
            return new DelegateSelector(Lambda::fun($src));
        }
        if ($src instanceof Selector) {
            return $src;
        }
        $type = gettype($src);
        throw new \InvalidArgumentException("Invalid selector, got '$type''.");
    }

    public function resolvePredicate($src)
    {
        if (is_callable($src)) {
            return new DelegatePredicate($src);
        }
        if (is_string($src)) {
            return new PropertyPredicate($src);
        }
        if (is_array($src)) {
            return new DelegatePredicate(Lambda::fun($src));
        }
        $type = gettype($src);
        throw new \InvalidArgumentException("Invalid predicate, got $type");
    }

    public function getEqualityComparer()
    {
        if (null === $this->equalityComparer) {
            $this->equalityComparer = new EqualityComparer();
        }

        return $this->equalityComparer;
    }

    public function getIterProvider()
    {
        if (null === $this->iterProvider) {
            $this->iterProvider = new IterProviderIterImpl();
        }

        return $this->iterProvider;
    }
}
