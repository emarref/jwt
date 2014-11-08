<?php

namespace Emarref\Jwt\Encryption;

class SymmetricTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $algorithm;

    /**
     * @var Symmetric
     */
    private $encryption;

    public function setUp()
    {
        $this->algorithm = $this->getMockBuilder('Emarref\Jwt\Algorithm\Hs256')
            ->setConstructorArgs(['secret'])
            ->getMock();

        $this->encryption = new Symmetric($this->algorithm);
    }

    public function testEncrypt()
    {
        $value         = 'value';
        $computedValue = 'computed_value';

        $this->algorithm->expects($this->once())
            ->method('compute')
            ->with($value)
            ->will($this->returnValue($computedValue));

        $this->assertSame($computedValue, $this->encryption->encrypt($value));
    }

    public function testVerify()
    {
        $value        = 'value';
        $signature    = 'signature';

        $badValue     = 'bad_value';
        $badSignature = 'bad_signature';

        $this->algorithm->expects($this->exactly(2))
            ->method('compute')
            ->will($this->returnValueMap([
                [$value, $signature],
                [$badValue, 'wontverify'],
            ]));

        $this->assertTrue($this->encryption->verify($value, $signature));
        $this->assertFalse($this->encryption->verify($badValue, $badSignature));
    }
}
