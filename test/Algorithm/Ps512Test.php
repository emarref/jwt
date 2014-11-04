<?php

namespace Emarref\Jwt\Algorithm;

class Ps512Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testNotImplemented()
    {
        $algorithm = new Ps512();
    }
}
