<?php

namespace Emarref\Jwt\Token;

use Emarref\Jwt\Claim;

class PayloadTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $claims;

    /**
     * @var PayloadStub
     */
    private $payload;

    public function setUp()
    {
        $this->claims  = $this->getMockBuilder('Emarref\Jwt\Token\PropertyList')->getMock();
        $this->payload = new PayloadStub($this->claims);
    }

    public function testSetClaim()
    {
        $claim = new Claim\PrivateClaim('name', 'value');

        $this->claims->expects($this->once())
            ->method('setProperty')
            ->with($claim);

        $this->payload->setClaim($claim);
    }

    public function testFindClaimByName()
    {
        $claim = new Claim\PrivateClaim('name', 'value');

        $this->claims->expects($this->exactly(2))
            ->method('getIterator')
            ->will($this->returnValue(new \ArrayObject([$claim])));

        $this->assertSame($claim, $this->payload->findClaimByName('name'));
        $this->assertNull($this->payload->findClaimByName('none'));
    }

    public function testGetClaims()
    {
        $this->assertSame($this->claims, $this->payload->getClaims());
    }

    public function testJsonSerialize()
    {
        $expectedJson = '{"whatever":true}';

        $this->claims->expects($this->once())
            ->method('jsonSerialize')
            ->will($this->returnValue($expectedJson));

        $this->assertSame($expectedJson, $this->payload->jsonSerialize());
    }
}
