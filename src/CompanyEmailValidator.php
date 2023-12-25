<?php

namespace V3labs\CompanyEmailValidator;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\NoRFCWarningsValidation;

class CompanyEmailValidator
{
    private EmailValidator $emailValidator;

    /** @var string[] */
    private array $domainMap;

    public function __construct(private bool $checkDns = false, array $additionalDomains = [])
    {
        $this->emailValidator = new EmailValidator();
        $this->domainMap = array_flip(array_map(
            fn(string $domain) => mb_strtolower($domain, 'UTF-8'),
            array_merge(
                file(__DIR__ . '/../resources/free_email_domains.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES),
                $additionalDomains
            )
        ));
    }

    public function isValid(string $email): bool
    {
        $validation = $this->checkDns
            ? new MultipleValidationWithAnd([new NoRFCWarningsValidation(), new DNSCheckValidation()])
            : new NoRFCWarningsValidation();

        if (!$this->emailValidator->isValid($email, $validation)) {
            return false;
        }

        $domain = mb_strtolower(array_reverse(explode('@', $email))[0], 'UTF-8');

        return !array_key_exists($domain, $this->domainMap);
    }
}