# Bohudur PHP Library
<img src="https://bohudur.one/bohudurlogo.png" alt="Bohudur Logo" width="328"/>

The Bohudur PHP Library enables effortless integration of the Bohudur payment gateway into your PHP-based websites, streamlining your payment processing with ease and reliability.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
  - [Initializing the Library](#initializing-the-library)
  - [Initializing Bohudur](#initializing-bohudur)
  - [Creating a Request](#creating-a-request)
  - [Verify a Payment](#verify-a-payment)
  - [Execute a Payment](#execute-a-payment)

## Installation

To include this library in your project, simply copy the bohudur.php file into your project directory.

## Usage

### Initializing the Library

Before using the library, make sure to include or require the `bohudur.php` file in your script. You need to define BOHUDUR first then script will work. Here how to do:

```php
define('BOHUDUR',true);
require 'bohudur.php';
```

### Initializing Bohudur

Initialize the `Bohudur` class with your API Key:

```php
$bohudur = new Bohudur("YOUR_API_KEY");
```

#### Creating a Request

Here is a demo code how you can create a simple request:
```php
$data = [
    'fullname' => 'Jane Doe',
    'email' => 'test@gmail.com',
    'amount' => 150,
    'return_type' => 'POST',
    'currency' => 'USD',
    'currency_value' => 120,
    'redirect_url' => 'http://redirect.com/call.php',
    'cancelled_url' => 'http://cancelled.com/call.php',
    'metadata' => ["demo1" => "data1", "demo2" => "data2"],
    'webhook' => ["success" => "https://webhook.com/success.php", "cancel" => "https://webhook.com/cancelled.php"],
];

$requestResponse = $bohudur->sendRequest($data);
```
| **Key**            | **Required** | **Description**                                                                 |
|--------------------|--------------|---------------------------------------------------------------------------------|
| `fullname`         | ✅ Yes       | Full name of the customer.                                                     |
| `email`            | ✅ Yes       | Customer's email address.                                                      |
| `amount`           | ✅ Yes       | Payment amount                                                                 |
| `return_type`      | ✅ Yes       | Method used to return payment response (`POST` or `GET`).                      |
| `redirect_url`     | ✅ Yes       | URL to redirect after successful payment.                                      |
| `cancelled_url`    | ✅ Yes       | URL to redirect if the payment is cancelled.                                   |
| `currency`         | ❌ No        | You can get the list of supported currencies from: [https://currencies.bohudur.one/](https://currencies.bohudur.one/) |
| `currency_value`   | ❌ No        | Exchange rate value if using a different currency.                             |
| `metadata`         | ❌ No        | Additional data as a key-value array for custom tracking or reference.         |
| `webhook`          | ❌ No        | JSON of webhook URLs for payment events like `success` and `cancel`.          |

### Verify a Payment

Get payment data using verify method:

```php
$verifyResponse = $bohudur->verifyPayment('paymentkey');
```

### Execute a Payment

Execute helps to protect from using same payment multiple times as it can be executed only one time.

```php
$executeResponse = $bohudur->executePayment('paymentkey');
```
