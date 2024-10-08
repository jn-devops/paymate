# Homeful Paymate Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jn-devops/paymate.svg?style=flat-square)](https://packagist.org/packages/jn-devops/paymate)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jn-devops/paymate/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jn-devops/paymate/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jn-devops/paymate/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jn-devops/paymate/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jn-devops/paymate.svg?style=flat-square)](https://packagist.org/packages/jn-devops/paymate)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require jn-devops/paymate
```

This is the contents of the published config file:

```php
return [
    
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="paymate-views"
```

## Usage

```php
```ENV Setup```
    'PAYMATE_MERCHANT_ID'   = ""
    'PAYMATE_SIGN_KEY'      = ""
    'PAYMATE_BASE_URL'      = ""
    'PAYMATE_MERPUBKEY'     = ""
    'PAYMATE_JWSKEY'        = ""
    'PAYMATE_JWEKEY'        = ""
    'PAYMATE_CALLBACKURL'   = ""
    'PAYMATE_NOTIFYURL'     = ""
```ENV Setup```

$paymate = new Homeful\Paymate();
```Generate public and private key```
$response = $paymate->generateKey();

```Generate link for AUbpaymate```
$jsonInput =[{   
    "referenceCode"=>"",//alpha-numeric
    "amount"=> ""//integer include two decimal w/o '.' ; Ex. 1.00 = 100
}];
$response = $paymate->payment_cashier($jsonInput);

```Send card payment```

$jsonInput =[{  
    "buyerName"=>"", //text 
    "email"=> "",
    "expirationMonth"=>"",// mm 
    "expirationYear"=>"",// yyyy
    "securityCode"=>"",// interger/CVV
    "pan"=>"",//card number
    "referenceCode"=>"",//alpha-numeric
    "amount"=>""//integer include two decimal w/o '.' ; Ex. 1.00 = 100
}];
$response = $paymate->payment_online($jsonInput);
```Generate link for qrph```
$jsonInput = [{
    "referenceCode" => "", //alpha-numberic
    "amount" => ""//interger include two decimal w/o '.' ; Ex. 1.00 = 100
}]
$response = $paymate->payment_qrph($jsonInput);
```Get transaction details```
$jsonInput =[{  
    "orderID"=>"",//alpha-numeric
}];
$response = $paymate->payment_inquiry($jsonInput);


```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Gari Vivar](https://github.com/jn-devops)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
