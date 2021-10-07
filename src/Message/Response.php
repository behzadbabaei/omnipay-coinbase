<?php

declare(strict_types = 1);

namespace Omnipay\Coinbase\Commerce\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

use function json_decode;
use function in_array;
use function end;

/**
 * Coinbase\Commerce Response.
 *
 * This is the response class for all Revolut requests.
 *
 * @see \Omnipay\Coinbase\Commerce\Gateway
 */
class Response extends AbstractResponse implements RedirectResponseInterface
{
    const STATUS_NEW = "NEW";
    const STATUS_PENDING = "PENDING";
    const STATUS_COMPLETED = "COMPLETED";
    const STATUS_EXPIRED = "EXPIRED";
    const STATUS_UNRESOLVED = "UNRESOLVED";
    const STATUS_RESOLVED = "RESOLVED";
    const STATUS_CANCELED = "CANCELED";
    const STATUS_REFUND_PENDING = "REFUND PENDING";
    const STATUS_REFUNDED = "REFUNDED";

    const CONTEXT_UNDERPAID = 'UNDERPAID';
    const CONTEXT_OVERPAID = 'OVERPAID';
    const CONTEXT_DELAYED = 'DELAYED';
    const CONTEXT_MULTIPLE = 'MULTIPLE';
    const CONTEXT_MANUAL = 'MANUAL';
    const CONTEXT_OTHER = 'OTHER';


    /**
     * Request id
     *
     * @var string URL
     */
    protected $requestId = null;

    /**
     * @var array
     */
    protected $headers = [];

    public function __construct(RequestInterface $request, $data, $headers = [])
    {
        parent::__construct($request, $data);

        $this->request = $request;
        $this->data = json_decode($data, true);
        $this->headers = $headers;
    }

    /**
     * Is the transaction in processing status?
     *
     * @return bool
     */
    public function isProcessing() : bool
    {
        return $this->getOrderStatus() == self::STATUS_PENDING;
    }

    /**
     * Is the transaction in pending status?
     *
     * @return bool
     */
    public function isPending() : bool
    {
        return $this->getOrderStatus() == self::STATUS_PENDING;
    }

    /**
     * Is the transaction in pending status?
     *
     * @return bool
     */
    public function isNew() : bool
    {
        return $this->getOrderStatus() == self::STATUS_NEW;
    }

    /**
     * Is the transaction in pending status?
     *
     * @return bool
     */
    public function isExpired() : bool
    {
        return $this->getOrderStatus() == self::STATUS_EXPIRED;
    }

    /**
     * Is the transaction successful?
     *
     * @return bool
     */
    public function isSuccessful() : bool
    {
        if ($this->getOrderStatus()) {
            return $this->isCompleted() && $this->isNotError();
        }

        return $this->isNotError();
    }

    /**
     * Is the response no error
     *
     * @return bool
     */
    public function isNotError() : bool
    {
        return in_array($this->getCode(), [self::STATUS_CANCELED, self::STATUS_EXPIRED, self::STATUS_UNRESOLVED]);
    }

    /**
     * Is the orderStatus completed
     * Full authorization of the order amount
     *
     * @return bool
     */
    public function isCompleted() : bool
    {
        return in_array($this->getOrderStatus(), [self::STATUS_COMPLETED, self::STATUS_REFUNDED, self::STATUS_RESOLVED]);
    }

    /**
     * @return bool
     */
    public function isRedirect() : bool
    {
        return true;
    }

    /**
     * Get response redirect url
     *
     * @return string|null
     */
    public function getRedirectUrl() : ?string
    {
        if (isset($this->data['hosted_url'])) {
            return $this->data['hosted_url'];
        }

        return null;
    }

    /**
     * Get the orderStatus.
     *
     *
     *  [
     * {
     * "time": "2017-01-31T20:49:02Z",
     * "status": "NEW"
     * },
     * {
     * "time": "2017-01-31T20:50:02Z",
     * "status": "PENDING"
     * },
     * {
     * "time": "2017-01-31T20:50:02Z",
     * "status": "COMPLETED"
     * },
     * {
     * "time": "2017-01-31T20:50:02Z",
     * "status": "UNRESOLVED",
     * "context": "UNDERPAID"
     * },
     * {
     * "time": "2017-01-31T20:50:02Z",
     * "status": "RESOLVED"
     * }
     * ]
     *
     *
     * @return |null
     */
    public function getOrderStatus()
    {
        if (isset($this->data['timeline'])) {
            return end($this->data['timeline'])['status'];
        }

        return null;
    }

    /**
     * Get the error message from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getMessage() : ?string
    {
        return null;
    }

    /**
     * Get the error code from the response.
     *
     * Returns null if the request was successful.
     *
     * @return string|null
     */
    public function getCode() : ?string
    {
        return null;
    }
}
