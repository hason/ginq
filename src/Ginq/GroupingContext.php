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

use Ginq\Core\Comparer;
use Ginq\Util\IteratorUtil;

class GroupingContext extends Context
{
    /**
     * @var mixed
     */
    protected $key;

    /**
     * @param \Iterator $it
     * @param mixed     $key
     * @internal param \Ginq\Core\Comparer $comparer
     */
    public function __construct($it, $key)
    {
        $this->key = $key;
        parent::__construct($it);
    }

    public function key()
    {
        return $this->key;
    }
}
