<?php

namespace Emarref\Jwt\Token;

use Emarref\Jwt\HeaderParameter;

class HeaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $parameters;

    /**
     * @var HeaderStub
     */
    private $header;

    public function setUp()
    {
        $this->parameters = $this->getMockBuilder('Emarref\Jwt\Token\PropertyList')->getMock();
        $this->header     = new HeaderStub($this->parameters);
    }

    public function testSetParameter()
    {
        $parameter = new HeaderParameter\Custom('name', 'value');

        $this->parameters->expects($this->once())
            ->method('setProperty')
            ->with($parameter);

        $this->header->setParameter($parameter);
    }

    public function testSetCriticalParameter()
    {
        $parameter = new HeaderParameter\Custom('name', 'value');

        $this->parameters->expects($this->exactly(2))
             ->method('setProperty');

        $this->parameters->expects($this->at(0))
            ->method('setProperty')
            ->with($parameter);

        $this->parameters->expects($this->once())
            ->method('getIterator')
            ->will($this->returnValue(new \ArrayObject([$parameter])));

        $this->header->setParameter($parameter, true);
    }

    public function testFindParameterByName()
    {
        $parameter = new HeaderParameter\Custom('name', 'value');

        $this->parameters->expects($this->exactly(2))
            ->method('getIterator')
            ->will($this->returnValue(new \ArrayObject([$parameter])));

        $this->assertSame($parameter, $this->header->findParameterByName('name'));
        $this->assertNull($this->header->findParameterByName('none'));
    }

    public function testGetParameters()
    {
        $this->assertSame($this->parameters, $this->header->getParameters());
    }

    public function testJsonSerialize()
    {
        $expectedJson = '{"whatever":true}';

        $this->parameters->expects($this->once())
            ->method('jsonSerialize')
            ->will($this->returnValue($expectedJson));

        $this->assertSame($expectedJson, $this->header->jsonSerialize());
    }
}
