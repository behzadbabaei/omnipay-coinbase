# Omnipay Coinbase Commerce
Coinbase Commerce gateway for Omnipay payment processing library
This package has implemented the Commerce API of Coinbase Payment systems
For more information please visit the following link:[Developer Document](https://commerce.coinbase.com/docs/#php)

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "behzadbabaei/omnipay-coinbase-commerce": "dev-master"
    }
}
```

And run composer to update your dependencies:

    composer update

Or you can simply run

    composer require behzadbabaei/omnipay-coinbase-commerce

## Basic Usage

1. Use Omnipay gateway class:

```php
    use Omnipay\Omnipay;
```

2. Initialize Revolut gateway:

```php

        $gateway = Omnipay::create('CoinbaseCommerce');

        $gateway->setAccessToken('your-api-key');
        $gateway->setApiVersion('your-api-version');
        $gateway->setLanguage(App::getLocale());

```

# Creating an charge order
Call purchase, it will return the response which includes the public_id for further process.
Please refer to the [Developer Document](https://commerce.coinbase.com/docs/api/#create-a-charge) for more information.

```php
            $redirectUrl = 'success-url'
            $cancelUrl = 'cancel-url'

            $metaData = [
                'orderId' => $data['orderId']
            ];

            return $this->gateway->purchase([
                'name'        => $data['name'],
                'description' => $data['description'],
                'amount'      => $data['amount'],
                'currency'    => $data['currency'],
                'customData'  => $metaData,
                'redirectUrl' => $redirectUrl,
                'cancelUrl'   => $cancelUrl,
            ])->send()->getData();
```

# Cancel an order
Please refer to the [Developer Document](https://commerce.coinbase.com/docs/api/#cancel-a-charge) for more information.

```php
       return $this->gateway->cancel([
              'orderId' => $orderId
            ])->send()->getData();
        } catch (Throwable $exception) {
            return null;
        }
```

# Retrieve an order
Please refer to the [Developer Document](https://commerce.coinbase.com/docs/api/#show-a-charge) for more information.

```php
        return $this->gateway->fetchTransaction([
            'orderId' => $orderId
        ])->send()->getData();
```

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcement, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/behzadbabaei/omnipay-coinbase-commerce/issues),
or better yet, fork the library and submit a pull request.

