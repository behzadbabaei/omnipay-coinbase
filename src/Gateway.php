<?php

declare(strict_types = 1);

namespace Omnipay\CoinbaseCommerce;

use Omnipay\CoinbaseCommerce\Message\CancelChargeRequest;
use Omnipay\CoinbaseCommerce\Message\ChargeRequest;
use Omnipay\CoinbaseCommerce\Message\RetrieveChargeRequest;
use Omnipay\Common\AbstractGateway;

/**
 * Braintree Gateway
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
 */
class Gateway extends AbstractGateway
{
    /**
     * Get name
     *
     * @return string
     */
    public function getName() : string
    {
        return 'CoinbaseCommerce';
    }

    /**
     * Get default parameters
     *
     * @return array
     */
    public function getDefaultParameters() : array
    {
        return [
            'accessToken' => '',
        ];
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
     * Set custom data to get back as is
     *
     * @param array $value
     *
     * @return $this
     */
    public function setCustomData($value)
    {
        return $this->setParameter('customData', $value);
    }

    /**
     * Get custom data
     *
     * @return mixed
     */
    public function getCustomData()
    {
        return $this->getParameter('customData');
    }

    /**
     * Set apiVersion
     *
     * @param string $value
     *
     * @return $this
     */
    public function setApiVersion(string $value)
    {
        return $this->setParameter('apiVersion', $value);
    }

    /**
     * Get custom apiVersion
     *
     * @return mixed
     */
    public function getApiVersion()
    {
        return $this->getParameter('apiVersion');
    }

    /**
     * Create a purchase request
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function purchase(array $options = array())
    {
        return $this->createRequest(ChargeRequest::class, $options);
    }

    /**
     * Create a retrieve order request
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function fetchTransaction(array $options = array())
    {
        return $this->createRequest(RetrieveChargeRequest::class, $options);
    }

    /**
     * Create a cancel request
     *
     * @param array $options
     *
     * @return \Omnipay\Common\Message\AbstractRequest|\Omnipay\Common\Message\RequestInterface
     */
    public function cancel(array $options = array())
    {
        return $this->createRequest(CancelChargeRequest::class, $options);
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        // TODO: Implement @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface fetchTransaction(array $options = [])
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
    }
}
