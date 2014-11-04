<?php

namespace Emarref\Jwt\Claim;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    private static $classMap = [
        Audience::NAME   => 'Emarref\Jwt\Claim\Audience',
        Expiration::NAME => 'Emarref\Jwt\Claim\Expiration',
        IssuedAt::NAME   => 'Emarref\Jwt\Claim\IssuedAt',
        Issuer::NAME     => 'Emarref\Jwt\Claim\Issuer',
        JwtId::NAME      => 'Emarref\Jwt\Claim\JwtId',
        NotBefore::NAME  => 'Emarref\Jwt\Claim\NotBefore',
        Subject::NAME    => 'Emarref\Jwt\Claim\Subject',
        'private'        => 'Emarref\Jwt\Claim\PrivateClaim',
    ];

    /**
     * @var Factory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new Factory();
    }

    public function testGetAudience()
    {
        $this->assertInstanceOf(self::$classMap[Audience::NAME], $this->factory->get(Audience::NAME));
    }

    public function testGetExpiration()
    {
        $this->assertInstanceOf(self::$classMap[Expiration::NAME], $this->factory->get(Expiration::NAME));
    }

    public function testGetIssuedAt()
    {
        $this->assertInstanceOf(self::$classMap[IssuedAt::NAME], $this->factory->get(IssuedAt::NAME));
    }

    public function testGetIssuer()
    {
        $this->assertInstanceOf(self::$classMap[Issuer::NAME], $this->factory->get(Issuer::NAME));
    }

    public function testGetJwtId()
    {
        $this->assertInstanceOf(self::$classMap[JwtId::NAME], $this->factory->get(JwtId::NAME));
    }

    public function testGetNotBefore()
    {
        $this->assertInstanceOf(self::$classMap[NotBefore::NAME], $this->factory->get(NotBefore::NAME));
    }

    public function testGetSubject()
    {
        $this->assertInstanceOf(self::$classMap[Subject::NAME], $this->factory->get(Subject::NAME));
    }

    public function testGetPrivate()
    {
        $this->assertInstanceOf(self::$classMap['private'], $this->factory->get('unknown'));
    }
}
