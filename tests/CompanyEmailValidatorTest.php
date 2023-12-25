<?php

namespace V3labs\CompanyEmailValidator\Tests;

use PHPUnit\Framework\TestCase;
use V3labs\CompanyEmailValidator\CompanyEmailValidator;

class CompanyEmailValidatorTest extends TestCase
{
    public function testValidator(): void
    {
        $validator = new CompanyEmailValidator();

        $this->assertFalse($validator->isValid("test@example.com"));
        $this->assertFalse($validator->isValid("test@EXAmple.com"));
        $this->assertFalse($validator->isValid("not-an-email"));
        $this->assertFalse($validator->isValid("jack.smith@ymail.com"));
        $this->assertTrue($validator->isValid("bill@microsoft.com"));
        $this->assertTrue($validator->isValid("bill@MICROSOFT.com"));
    }

    public function testAdditionalDomains(): void
    {
        $validator = new CompanyEmailValidator(additionalDomains: [
            'additional-free-domain-to-check.com'
        ]);

        $this->assertFalse($validator->isValid('user@additional-free-domain-to-check.com'));
    }

    public function testCheckDns(): void
    {
        $validatorWithDnsCheck = new CompanyEmailValidator(true);
        $this->assertFalse($validatorWithDnsCheck->isValid('user@this-is-not-a-real-domain.abc'));

        $validatorWithoutDnsCheck = new CompanyEmailValidator();
        $this->assertTrue($validatorWithoutDnsCheck->isValid('user@this-is-not-a-real-domain.abc'));
    }
}