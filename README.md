Paynow Simple
--
Paynow Simple is unofficial PHP library to consume Paynow API.  
Meant as more straightforward, yet type-safe alternative to official paynow-php-sdk.

**This library is work in progress** and will be a subject to change.

### TODO:
- consider curl http client implementation instead of Guzzle as default (more lightweight?)
- psalm
- github actions?

### Usage:
Starting a payment:
```php
use PaynowSimple\Client as PaynowClient;
use PaynowSimple\ValueObject\Payment;

$client = PaynowClient::create(
    'apiKey',
    'signatureKey'
);

$payment = Payment::create(
    10000,
    'PLN',
    'ORDER-0001',
    'payment description',
    'customer@acme.invalid'
);


$client->makePayment($payment);
```
Static factory methods are provided for convenience.  

PaynowSimple\Client uses HTTPlug, therefore it does not depend on concrete http client. 
You can use any compatible http client through constructor injection.

GuzzleClient is used by default (that can change).

### PHP version
Right now only php 7.3 was tested, I expect no problems with php 7.4.  
Generally library should work with php 7.1 and above (due to _private const_).  

Do not use unsupported php versions. It just makes no sense.

### Support:
This is a hobby project, so support is not guaranteed.  
But, if you find any problem with this library, please file an issue on Github.  
Suggestions are welcome.