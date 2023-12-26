Company email validator
=
The **v3labs/company-email-validator** package is a PHP library designed 
to validate whether an email address belongs to a company domain or not.

Installation
-
You can install the package via Composer:
```bash
composer require v3labs/company-email-validator
```

Usage
-
To use the Company Email Validator, instantiate the CompanyEmailValidator 
class and call the isCompanyEmail method with the email address you 
want to validate.

```php
<?php

$validator = new \V3labs\Validator\CompanyEmailValidator(
    checkDns: false,      // default
    additionalDomains: [] // default
);

$isCompanyEmail1 = $validator->isValid('john.doe@example.com'); // false
$isCompanyEmail2 = $validator->isValid('info@acme.com'); // true
```

Note
-
The validation is based on the presence of common free email domains, 
and emails matching these domains will be considered as non-company emails.