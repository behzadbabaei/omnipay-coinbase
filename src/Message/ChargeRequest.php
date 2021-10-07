<?php

declare(strict_types = 1);

namespace Omnipay\Coinbase\Commerce\Message;

use function array_merge;
use function json_encode;

/**
 * Class ChargeRequest
 *
 * @package Omnipay\Coinbase\Commerce\Message
 */
class ChargeRequest extends AbstractRequest
{
    /**
     * Sets the request CancelUrl.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setCancelUrl($value)
    {
        return $this->setParameter('cancelUrl', $value);
    }

    /**
     * Get the request CancelUrl.
     *
     * @return mixed
     */
    public function getCancelUrl()
    {
        return $this->getParameter('cancelUrl');
    }


    /**
     * Prepare the data for creating the order.
     *
     * {
     * "name": "The Sovereign Individual",
     * "description": "Mastering the Transition to the Information Age",
     * "local_price": {
     *      "amount": "100.00",
     *      "currency": "USD"
     * },
     * "pricing_type": "fixed_price",
     * "metadata": {
     *      "customer_id": "id_1005",
     *      "customer_name": "Satoshi Nakamoto"
     * },
     * "redirect_url": "https://charge/completed/page",
     * "cancel_url": "https://charge/canceled/page"
     * }
     *
     * https://commerce.coinbase.com/docs/api/#create-a-charge
     *
     * @return array
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $this->validate('name', 'description', 'currency', 'amount');

        return array_merge($this->getCustomData(), [
            'name'         => $this->getName(),
            'description'  => $this->getDescription(),
            'local_price'  => [
                "amount"   => $this->getAmount(),
                "currency" => $this->getCurrency()
            ],
            "pricing_type" => $this->getPricingType() ?? self::PRICING_TYPE_FIXED_PRICE,
            "metadata"     => $this->getCustomData() ?? [],
            "redirect_url" => $this->getReturnUrl(),
            "cancel_url"   => $this->getCancelUrl(),
        ]);
    }

    /**
     * Send data and return response instance.
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
            'X-CC-Version' => $this->getApiVersion(),
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
     * Get the order create endpoint.
     *
     * @return string
     */
    public function getEndpoint() : string
    {
        return $this->getUrl().'/charges';
    }
}
