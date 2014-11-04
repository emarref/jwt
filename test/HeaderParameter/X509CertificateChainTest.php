<?php

namespace Emarref\Jwt\HeaderParameter;

class X509CertificateChainTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'x5c';
    private static $value = 'foobar';

    /**
     * @var X509CertificateChain
     */
    private $parameter;

    public function setUp()
    {
        $this->parameter = new X509CertificateChain(self::$value);
    }

    public function testGetName()
    {
        $this->assertSame(self::$name, $this->parameter->getName());
    }

    public function testGetValue()
    {
        $this->assertSame(self::$value, $this->parameter->getValue());
    }

    public function testSetValue()
    {
        $newValue = 'NewValue';

        $this->parameter->setValue($newValue);
        $this->assertSame($newValue, $this->parameter->getValue());
    }
}
