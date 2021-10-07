<?php

declare(strict_types = 1);

namespace Omnipay\Coinbase\Commerce\Message;

use function array_merge;
use function json_encode;

/**
 * Class CancelChargeRequest
 *
 * @package Omnipay\Coinbase\Commerce\Message
 */
class CancelChargeRequest extends AbstractRequest
{
    /**
     * Sets the request orderId.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    /**
     * Get the request orderId.
     *
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    /**
     * Prepare data to send
     *
     * @return array
     */
    public function getData() : array
    {
        return array_merge($this->getCustomData(), []);
    }

    /**
     * Send data and return response instance
     *
     * https://commerce.coinbase.com/docs/api/#cancel-a-charge
     *
     * @param mixed $body
     *
     * @return mixed
     */
    public function sendData($body)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'X-CC-Api-Key' => $this->getAccessToken(),
            'X-CC-Version' => $this->getVersion(),
        ];

        $httpResponse = $this->httpClient->request(
            $this->getHttpMethod(),
            $this->getEndpoint(),
            $headers,
            json_encode($body)
        );

        return $this->createResponse($httpResponse->getBody()->getContents(), $httpResponse->getHeaders());
    }

    /**
     * @param       $data
     * @param array $headers
     *
     * @return Response
     */
    protected function createResponse($data, $headers = []) : Response
    {
        return $this->response = new Response($this, $data, $headers);
    }

    /**
     * @return string
     */
    public function getEndpoint() : string
    {
        $orderId = $this->getOrderId();

        return $this->getUrl().'/charges/'.$orderId.'/cancel';
    }
}
