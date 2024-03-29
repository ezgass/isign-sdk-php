<?php
namespace Isign\Tests\Integration;


use Isign\Sign\Sc;
use Isign\Sign\ScPrepare;
use Isign\Sign\ScPrepareResult;
use Isign\StatusResultInterface;

class ScSignTest extends TestCase
{
    /**
    * @expectedException Isign\Exception\QueryValidator
    */
    public function testRequiredParams()
    {
        $this->client->get(new ScPrepare(
            null,
            null,
            null,
            null,
            array()
        ));
    }

    public function testPrepare()
    {
        /** @var ScPrepareResult $result */
        $result = $this->client->get(new ScPrepare(
            base64_encode(CERTIFICATE_SIGN),
            'pdf',
            false,
            'LT',
            $this->getDocumentParams()
        ));

        $this->assertSame(StatusResultInterface::STATUS_OK, $result->getStatus());

        return $result;
    }

    /**
     * @depends testPrepare
     *
     * @param ScPrepareResult $result
     */
    public function testSign(ScPrepareResult $result)
    {
        $result = $this->client->get(new Sc($result->getToken(), $this->sign($result->getDtbs())));

        $this->assertSame(StatusResultInterface::STATUS_OK, $result->getStatus());
        $this->assertSame('Signature1', $result->getSignatureId());
    }

    /**
     * Test parameters validation on API by sending invalid personal code
     * @expectedException Isign\Exception\InvalidData
     * @expectedExceptionMessage Data validation failed
     */
    public function testBadRequest()
    {
        $documentParams = $this->getDocumentParams();
        unset($documentParams['reason']);
        /** @var Isign\Sign\MobileResult $result */
        $result = $this->client->get(new ScPrepare(
            base64_encode(CERTIFICATE_SIGN),
            'pdf',
            false,
            'LT',
            $documentParams
        ));
    }

    private function getDocumentParams()
    {
        return [
            'files' => [
                __DIR__.'/../data/document.pdf',
            ],
            'contact'   => 'Ponas Testuotojas',
            'reason'    => 'Pasirašymas',
            'location'  => 'Vilnius',
        ];
    }
}
