<?php

namespace Emarref\Jwt\Serialization;

use Emarref\Jwt\Claim;
use Emarref\Jwt\HeaderParameter;
use Emarref\Jwt\Token;

class CompactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $encoding;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $headerParameterFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $claimFactory;

    /**
     * @var Compact
     */
    private $serializer;

    public function setUp()
    {
        $this->encoding = $this->getMockBuilder('Emarref\Jwt\Encoding\Base64')->getMock();

        $this->headerParameterFactory = $this->getMockBuilder('Emarref\Jwt\HeaderParameter\Factory')->getMock();

        $this->claimFactory = $this->getMockBuilder('Emarref\Jwt\Claim\Factory')->getMock();

        $this->serializer = new Compact($this->encoding, $this->headerParameterFactory, $this->claimFactory);
    }

    public function testDeserialize()
    {
        $jwt = 'a.b.c';

        // Configure encoding

        $this->encoding->expects($this->at(0))
            ->method('decode')
            ->with('a')
            ->will($this->returnValue('{"a":"1"}'));

        $this->encoding->expects($this->at(1))
            ->method('decode')
            ->with('b')
            ->will($this->returnValue('{"b":"2"}'));

        $this->encoding->expects($this->at(2))
            ->method('decode')
            ->with('c')
            ->will($this->returnValue('c'));

        // Configure headers

        $headerParameter = $this->getMockBuilder('Emarref\Jwt\HeaderParameter\Custom')
            ->getMock();

        $headerParameter->expects($this->once())
            ->method('setValue')
            ->with('1');

        $headerParameter->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('1'));

        $headerParameter->expects($this->exactly(2))
            ->method('getName')
            ->will($this->returnValue('a'));

        $this->headerParameterFactory->expects($this->once())
            ->method('get')
            ->with('a')
            ->will($this->returnValue($headerParameter));

        // Configure claims

        $claim = $this->getMockBuilder('Emarref\Jwt\Claim\PrivateClaim')
            ->getMock();

        $claim->expects($this->once())
            ->method('setValue')
            ->with('2');

        $claim->expects($this->once())
            ->method('getValue')
            ->will($this->returnValue('2'));

        $claim->expects($this->exactly(2))
            ->method('getName')
            ->will($this->returnValue('b'));

        $this->claimFactory->expects($this->once())
            ->method('get')
            ->with('b')
            ->will($this->returnValue($claim));

        // Assert

        $token = $this->serializer->deserialize($jwt);

        $this->assertSame('{"a":"1"}', $token->getHeader()->jsonSerialize());
        $this->assertSame('{"b":"2"}', $token->getPayload()->jsonSerialize());
        $this->assertSame('c', $token->getSignature());
    }

    public function testSerialize()
    {
        // Configure payload

        $headerParameters = $this->getMockBuilder('Emarref\Jwt\Token\PropertyList')->getMock();

        $headerParameters->expects($this->once())
            ->method('jsonSerialize')
            ->will($this->returnValue('{"a":"1"}'));

        $header = $this->getMockBuilder('Emarref\Jwt\Token\Header')->getMock();

        $header->expects($this->once())
            ->method('getParameters')
            ->will($this->returnValue($headerParameters));

        // Configure payload

        $claims = $this->getMockBuilder('Emarref\Jwt\Token\PropertyList')->getMock();

        $claims->expects($this->once())
            ->method('jsonSerialize')
            ->will($this->returnValue('{"b":"2"}'));

        $payload = $this->getMockBuilder('Emarref\Jwt\Token\Payload')->getMock();

        $payload->expects($this->once())
            ->method('getClaims')
            ->will($this->returnValue($claims));

        // Configure token

        $token = $this->getMockBuilder('Emarref\Jwt\Token')->getMock();

        $token->expects($this->once())
            ->method('getHeader')
            ->will($this->returnValue($header));

        $token->expects($this->once())
              ->method('getPayload')
              ->will($this->returnValue($payload));

        $token->expects($this->once())
              ->method('getSignature')
              ->will($this->returnValue('c'));

        // Configure encoding

        $this->encoding->expects($this->exactly(3))
            ->method('encode')
            ->will($this->returnValueMap([
                ['{"a":"1"}', 'a'],
                ['{"b":"2"}', 'b'],
                ['c', 'c'],
            ]));

        $jwt = $this->serializer->serialize($token);

        $this->assertSame('a.b.c', $jwt);
    }
}
