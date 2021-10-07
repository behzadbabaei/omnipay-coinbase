<?php

declare(strict_types = 1);

namespace Omnipay\Coinbase\Commerce\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;

/**
 * Class AbstractRequest
 *
 * @package Omnipay\Coinbase\Commerce\Message
 */
abstract class AbstractRequest extends BaseAbstractRequest
{
    const PRICING_TYPE_FIXED_PRICE = "fixed_price";
    const PRICING_TYPE_NO_PRICE = "no_price";

    /**
     * Gateway production endpoint.
     *
     * @var string $prodEndpoint
     */
    protected $prodEndpoint = 'https://api.commerce.coinbase.com';

    /**
     * @var string $sandboxEndpoint
     */
    protected $sandboxEndpoint = 'https://api.commerce.coinbase.com';

    /**
     * @return string
     */
    abstract public function getEndpoint() : string;

    /**
     * @param mixed $data
     *
     * @return \Omnipay\Common\Message\ResponseInterface
     */
    abstract public function sendData($data);

    /**
     * Get url Depends on  test mode.
     *
     * @return string
     */
    public function getUrl() : string
    {
        return $this->getTestMode() ? $this->sandboxEndpoint : $this->prodEndpoint;
    }

    /**
     * Sets the request version.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setVersion($value)
    {
        return $this->setParameter('version', $value);
    }

    /**
     * Get the request version.
     *
     * @return mixed
     */
    public function getVersion()
    {
        return $this->getParameter('version');
    }

    /**
     * Sets the request name.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }

    /**
     * Get the request name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->getParameter('name');
    }

    /**
     * Sets the request pricingType.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setPricingType($value)
    {
        return $this->setParameter('pricingType', $value);
    }

    /**
     * Get the request pricingType.
     *
     * @return mixed
     */
    public function getPricingType()
    {
        return $this->getParameter('pricingType');
    }

    /**
     * Sets the request access token.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setAccessToken($value)
    {
        return $this->setParameter('accessToken', $value);
    }

    /**
     * Get the request access token.
     *
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->getParameter('accessToken');
    }

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    public function getHttpMethod() : string
    {
        return 'POST';
    }

    /**
     * @return array
     */
    public function getHeaders() : array
    {
        return [];
    }

    /**
     * /**
     * Set custom data to get back as is.
     *
     * @param array $value
     *
     * @return $this
     */
    public function setCustomData(array $value)
    {
        return $this->setParameter('customData', $value);
    }

    /**
     * Get custom data.
     *
     * @return mixed
     */
    public function getCustomData()
    {
        return $this->getParameter('customData', []) ?? [];
    }
}
