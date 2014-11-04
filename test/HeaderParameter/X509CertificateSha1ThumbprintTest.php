<?php

namespace Emarref\Jwt\HeaderParameter;

class X509CertificateSha1ThumbprintTest extends \PHPUnit_Framework_TestCase
{
    private static $name  = 'x5t';
    private static $value = 'foobar';

    /**
     * @var X509CertificateSha1Thumbprint
     */
    private $parameter;

    public function setUp()
    {
        $this->parameter = new X509CertificateSha1Thumbprint(self::$value);
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
