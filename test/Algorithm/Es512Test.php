<?php

namespace Emarref\Jwt\Algorithm;

class Es512Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testNotImplemented()
    {
        $algorithm = new Es512();
    }
}
