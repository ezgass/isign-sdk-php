<?php
namespace Isign\Tests\Integration;

use Isign\Login;

class MobileLoginTest extends TestCase
{
    public function testLogin()
    {
        /** @var Isign\Login\MobileResult $result */
        $result = $this->client->get(
            new Login\Mobile(PHONE, CODE)
        );

        return $result;
    }

    /**
     * @depends testLogin
     * @params Login\MobileResult $result
     */
    public function testLoginStatusWaiting(Login\MobileResult $result)
    {
        /** @var Isign\Login\MobileStatusResult $statusResult */
        $statusResult = $this->client->get(
            new Login\MobileStatus($result->getToken())
        );
        $this->assertSame(Login\MobileStatusResult::WAITING, $statusResult->getStatus());

        return $result;
    }

    /**
     * @depends testLoginStatusWaiting
     * @params Login\MobileResult $result
     */
    public function testLoginStatusOk(Login\MobileResult $result)
    {
        sleep(TIMEOUT);

        /** @var Isign\Login\MobileStatusResult $statusResult */
        $statusResult = $this->client->get(
            new Login\MobileStatus($result->getToken())
        );
        $this->assertSame(Login\MobileStatusResult::OK, $statusResult->getStatus());
    }

    /**
     * Test parameters validation on client side
     * @expectedException Isign\Exception\QueryValidator
     * @expectedExceptionMessage Query parameters validation failed
     */
    public function testInvalidParamsHandling()
    {
        $result = $this->client->get(
            new Login\Mobile('3726000000', CODE)
        );
    }

    /**
     * Test parameters validation on API by sending invalid personal code
     * @expectedException Isign\Exception\InvalidData
     * @expectedExceptionMessage Data validation failed
     */
    public function testBadRequest()
    {
        $result = $this->client->get(
            new Login\Mobile(PHONE, '41001091072')
        );
    }
}
