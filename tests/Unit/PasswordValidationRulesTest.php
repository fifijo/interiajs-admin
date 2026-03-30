<?php

use App\Concerns\PasswordValidationRules;
use Illuminate\Validation\Rules\Password;

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
    expect($rules)->toHaveCount(4);
    expect(in_array('required', $rules))->toBeTrue();
    expect(in_array('string', $rules))->toBeTrue();
    expect(in_array('confirmed', $rules))->toBeTrue();
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
    expect($rules)->toHaveCount(3);
    expect(in_array('required', $rules))->toBeTrue();
    expect(in_array('string', $rules))->toBeTrue();
    expect(in_array('current_password', $rules))->toBeTrue();
});