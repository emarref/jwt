<?php

namespace Emarref\Jwt\Signature;

use Emarref\Jwt\HeaderParameter\Algorithm;

class JwsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $algorithm;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $encoder;

    /**
     * @var Jws
     */
    private $signer;

    public function setUp()
    {
        $this->algorithm = $this->getMockBuilder('Emarref\Jwt\Algorithm\None')->getMock();

        $this->encoder = $this->getMockBuilder('Emarref\Jwt\Encoding\Base64')->getMock();

        $this->signer = new Jws($this->algorithm, $this->encoder);
    }

    public function testComputeSignature()
    {
        $computed = 'computed';

        // Configure header

        $headerJson = '{"a":"1"}';
        $encodedHeaderJson = 'a';

        $headerParameters = $this->getMockBuilder('Emarref\Jwt\Token\PropertyList')->getMock();

        $headerParameters->expects($this->once())
                         ->method('jsonSerialize')
                         ->will($this->returnValue($headerJson));

        $this->encoder->expects($this->at(0))
            ->method('encode')
            ->with($headerJson)
            ->will($this->returnValue($encodedHeaderJson));

        $header = $this->getMockBuilder('Emarref\Jwt\Token\Header')->getMock();

        $header->expects($this->once())
            ->method('getParameters')
            ->will($this->returnValue($headerParameters));

        // Configure payload

        $claimsJson = '{"b":"2"}';
        $encodedClaimsJson = 'b';

        $claims = $this->getMockBuilder('Emarref\Jwt\Token\PropertyList')->getMock();

        $claims->expects($this->once())
            ->method('jsonSerialize')
            ->will($this->returnValue($claimsJson));

        $payload = $this->getMockBuilder('Emarref\Jwt\Token\Payload')->getMock();

        $payload->expects($this->once())
            ->method('getClaims')
            ->will($this->returnValue($claims));

        $this->encoder->expects($this->at(1))
            ->method('encode')
            ->with($claimsJson)
            ->will($this->returnValue($encodedClaimsJson));

        $this->algorithm->expects($this->once())
            ->method('compute')
            ->with(sprintf('%s.%s', $encodedHeaderJson, $encodedClaimsJson))
            ->will($this->returnValue($computed));

        // Configure token

        $token = $this->getMockBuilder('Emarref\Jwt\Token')->getMock();

        $token->expects($this->once())
              ->method('getHeader')
              ->will($this->returnValue($header));

        $token->expects($this->once())
              ->method('getPayload')
              ->will($this->returnValue($payload));

        $this->assertSame($computed, $this->signer->computeSignature($token));
    }

    public function testSign()
    {
        $expectedSignature = 'foobar';

        // Configure header

        $headerParameters = $this->getMockBuilder('Emarref\Jwt\Token\PropertyList')->getMock();

        $headerParameters->expects($this->once())
            ->method('jsonSerialize');

        $this->encoder->expects($this->at(0))
            ->method('encode');

        $header = $this->getMockBuilder('Emarref\Jwt\Token\Header')->getMock();

        $header->expects($this->once())
            ->method('getParameters')
            ->will($this->returnValue($headerParameters));

        // Configure payload

        $claims = $this->getMockBuilder('Emarref\Jwt\Token\PropertyList')->getMock();

        $claims->expects($this->once())
            ->method('jsonSerialize');

        $payload = $this->getMockBuilder('Emarref\Jwt\Token\Payload')->getMock();

        $payload->expects($this->once())
            ->method('getClaims')
            ->will($this->returnValue($claims));

        $this->encoder->expects($this->at(1))
            ->method('encode');

        $this->algorithm->expects($this->once())
            ->method('compute')
            ->will($this->returnValue($expectedSignature));

        // Configure token

        $token = $this->getMockBuilder('Emarref\Jwt\Token')->getMock();

        $token->expects($this->once())
              ->method('getHeader')
              ->will($this->returnValue($header));

        $token->expects($this->once())
              ->method('getPayload')
              ->will($this->returnValue($payload));

        $this->algorithm->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('alg'));

        $token->expects($this->once())
            ->method('addHeader')
            ->with(new Algorithm('alg'));

        $token->expects($this->once())
            ->method('setSignature')
            ->with($expectedSignature);

        $this->signer->sign($token);
    }
}
