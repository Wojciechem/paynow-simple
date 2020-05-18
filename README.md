Paynow Simple
--
Paynow Simple is unofficial PHP library to consume Paynow API.  
Meant as more straightforward, yet type-safe alternative to official paynow-php-sdk.

**This library is work in progress** and will be a subject to change.

`PaynowSimple\Client` uses HTTPlug. It does not depend on concrete http client, but GuzzleClient is bundled for convenience (factory methods).  

You can use any compatible http client through constructor injection.

### Usage:
First: use [composer autoloading](https://getcomposer.org/doc/01-basic-usage.md#autoloading)
#### Starting a payment:
```php
use PaynowSimple\ClientFactory as PaynowClientFactory;
use PaynowSimple\ValueObject\Payment;
use PaynowSimple\Exception\ClientException;

$client = PaynowClientFactory::default()->create('api-key', 'signature-key');

$payment = Payment::create(
    10000,
    'PLN',
    'ORDER-0001',
    'payment description',
    'customer@acme.invalid'
);

try {
    $client->makePayment($payment);
} catch (ClientException $e) {
    // handle errors...
}
```

#### Receiving payment notification (without http framework):
```php
use PaynowSimple\Exception\InvalidArgument;
use PaynowSimple\NotificationHandler;

try {
    $handler = new NotificationHandler('my signature key');
    $handler->handle();

    // proceed with payment processing
    // return 200 / 202 response
} catch (InvalidArgument $e) {
    // return 400 response
}
```

#### Receiving payment notification with http framework
Above won't work with most http frameworks, as they clear superglobals used in `PaymentStatusNotification::createFromGlobals()`.  
You must instantiate `PaymentStatusNotification` yourself using its constructor, or extend it with factory method like `::fromRequest()`.  
Please see source code of `NotificationHandler::handle()` and implement your own solution accordingly.

### PHP version
Right now only php 7.3 was tested, I expect no problems with php 7.4.  
Generally library should work with php 7.1 and above (due to _private const_).  

Do not use unsupported php versions. It just makes no sense.

### Support:
This is a hobby project, so support is not guaranteed.  
But, if you find any problem with this library, please file an issue on Github.  
Suggestions are welcome.