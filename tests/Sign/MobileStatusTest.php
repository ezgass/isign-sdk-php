<?php
namespace Isign\Tests\Sign;

use Isign\Sign\MobileStatus;
use Isign\QueryInterface;
use Isign\Tests\TestCase;

class MobileStatusTest extends TestCase
{
    private $method;

    public function setUp()
    {
        $this->method = new MobileStatus('xxx');
    }

    public function testContainsToken()
    {
        $this->assertInstanceOf('Isign\TokenizedQueryInterface', $this->method);
        $this->assertSame('xxx', $this->method->getToken());
    }

    public function testGetFields()
    {
        $result = $this->method->getFields();

        $this->assertArrayHasKey('token', $result);
        $this->assertSame('xxx', $result['token']);
    }

    public function testGetAction()
    {
        $this->assertSame('mobile/sign/status', $this->method->getAction());
    }

    public function testGetMethod()
    {
        $this->assertSame(QueryInterface::GET, $this->method->getMethod());
    }

    public function testCreateResult()
    {
        $this->assertInstanceOf('Isign\Sign\MobileStatusResult', $this->method->createResult());
    }

    public function testHasValidationConstraints()
    {
        $collection = $this->method->getValidationConstraints();

        $this->assertInstanceOf(
            'Symfony\Component\Validator\Constraints\Collection',
            $collection
        );
    }
}
