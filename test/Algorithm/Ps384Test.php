<?php

namespace Emarref\Jwt\Algorithm;

class Ps384Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testNotImplemented()
    {
        $algorithm = new Ps384();
    }
}
