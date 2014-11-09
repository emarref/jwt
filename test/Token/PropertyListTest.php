<?php

namespace Emarref\Jwt\Token;

class PropertyListTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $properties;

    /**
     * @var PropertyListStub
     */
    private $propertyList;

    public function setUp()
    {
        $this->properties = $this->getMockBuilder('\ArrayObject')->getMock();

        $this->propertyList = new PropertyListStub($this->properties);
    }

    public function testSetProperty()
    {
        $property = new PropertyStub();

        $this->properties->expects($this->once())
            ->method('offsetSet')
            ->with($property->getName(), $property);

        $this->propertyList->setProperty($property);

        return $property;
    }

    public function testJsonSerialize()
    {
        $expectedJson = '{"one":"11","two":"2"}';

        $properties = new \ArrayIterator([
            new PropertyStub('one', '1'),
            new PropertyStub('one', '11'), // Latter takes precedence
            new PropertyStub('two', '2'),
            new PropertyStub('three', ''), // Blank value ignored
            new PropertyStub('', '4'),     // Blank name ignored
        ]);

        $this->properties->expects($this->once())
            ->method('getIterator')
            ->will($this->returnValue($properties));

        $this->assertSame($expectedJson, $this->propertyList->jsonSerialize());
    }

    public function testGetIterator()
    {
        $this->assertSame($this->properties, $this->propertyList->getIterator());
    }
}
