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


    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Not a valid JWT string passed for deserialization
     */
    public function testDeserializationWithEmptyToken()
    {
        $token = '';
        $this->serializer->deserialize($token);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Not a valid header of JWT string passed for deserialization
     */
    public function testDeserializationTokenWithInvalidHeader()
    {
        $token = 'header.payload.signature';
        $this->encoding->expects($this->at(0))
            ->method('decode')
            ->with('header')
            ->will($this->returnValue('{"invalid"}'));

        $this->serializer->deserialize($token);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Not a valid payload of JWT string passed for deserialization
     */
    public function testDeserializationTokenWithInvalidPayload()
    {
        $token = 'header.payload.signature';
        $this->encoding->expects($this->at(0))
            ->method('decode')
            ->with('header')
            ->will($this->returnValue('{"header_field":"valid_header"}'));

        $this->encoding->expects($this->at(1))
            ->method('decode')
            ->with('payload')
            ->will($this->returnValue('{"invalid"}'));

        $this->encoding->expects($this->at(2))
            ->method('decode')
            ->with('signature')
            ->will($this->returnValue('{"signature_field":"valid_signature"}'));

        $headerParameter = $this->getMockBuilder('Emarref\Jwt\HeaderParameter\Custom')
            ->getMock();

        $this->headerParameterFactory->expects($this->once())
            ->method('get')
            ->with('header_field')
            ->will($this->returnValue($headerParameter));

        $this->serializer->deserialize($token);
    }

    public function testDeserializationTokenWithoutSignature()
    {
        $token = 'header.payload';
        $this->encoding->expects($this->at(0))
            ->method('decode')
            ->with('header')
            ->will($this->returnValue('{"header_field":"valid_header"}'));

        $this->encoding->expects($this->at(1))
            ->method('decode')
            ->with('payload')
            ->will($this->returnValue('{}'));

        $this->encoding->expects($this->at(2))
            ->method('decode')
            ->with(null)
            ->will($this->returnValue(null));

        $headerParameter = $this->getMockBuilder('Emarref\Jwt\HeaderParameter\Custom')
            ->getMock();

        $this->headerParameterFactory->expects($this->once())
            ->method('get')
            ->with('header_field')
            ->will($this->returnValue($headerParameter));

        $token = $this->serializer->deserialize($token);

        $this->assertNull($token->getSignature());
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
