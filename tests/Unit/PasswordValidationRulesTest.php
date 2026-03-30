<?php

use App\Concerns\PasswordValidationRules;
use Illuminate\Validation\Rules\Password;
use PHPUnit\Framework\TestCase;

class MockPasswordValidationRules
{
    use PasswordValidationRules;

    public function publicPasswordRules(): array
    {
        return $this->passwordRules();
    }

    public function publicCurrentPasswordRules(): array
    {
        return $this->currentPasswordRules();
    }
}

beforeEach(function () {
    $this->trait = new MockPasswordValidationRules();
});

test('password rules are returned correctly', function () {
    $rules = $this->trait->publicPasswordRules();

    expect($rules)->toBeArray();
    expect($rules)->toContain('required');
    expect($rules)->toContain('string');
    expect($rules)->toContain('confirmed');
    expect($rules)->toHaveCount(4);
});

test('password rules contain default password rule', function () {
    $rules = $this->trait->publicPasswordRules();

    // The Password::default() should be in the rules
    $passwordRuleFound = false;
    foreach ($rules as $rule) {
        if ($rule instanceof Password) {
            $passwordRuleFound = true;
            break;
        }
    }
    expect($passwordRuleFound)->toBeTrue();
});

test('current password rules are returned correctly', function () {
    $rules = $this->trait->publicCurrentPasswordRules();

    expect($rules)->toBeArray();
    expect($rules)->toContain('required');
    expect($rules)->toContain('string');
    expect($rules)->toContain('current_password');
    expect($rules)->toHaveCount(3);
});