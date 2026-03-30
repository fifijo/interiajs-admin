<?php

use App\Concerns\ProfileValidationRules;

class MockProfileValidationRules
{
    use ProfileValidationRules;

    public function publicProfileRules(?int $userId = null): array
    {
        return $this->profileRules($userId);
    }

    public function publicNameRules(): array
    {
        return $this->nameRules();
    }

    public function publicEmailRules(?int $userId = null): array
    {
        return $this->emailRules($userId);
    }
}

beforeEach(function () {
    $this->trait = new MockProfileValidationRules();
});

test('profile rules return correct structure', function () {
    $rules = $this->trait->publicProfileRules();

    expect($rules)->toBeArray();
    expect($rules)->toHaveKeys(['name', 'email']);
});

test('name rules are returned correctly', function () {
    $rules = $this->trait->publicNameRules();

    expect($rules)->toBeArray();
    expect($rules)->toHaveCount(3);
    expect(in_array('required', $rules))->toBeTrue();
    expect(in_array('string', $rules))->toBeTrue();
    expect(in_array('max:255', $rules))->toBeTrue();
});

test('email rules are returned correctly without user id', function () {
    $rules = $this->trait->publicEmailRules();

    expect($rules)->toBeArray();
    expect(in_array('required', $rules))->toBeTrue();
    expect(in_array('string', $rules))->toBeTrue();
    expect(in_array('email', $rules))->toBeTrue();
    expect(in_array('max:255', $rules))->toBeTrue();
    // Should contain unique rule - check for Rules\Unique (plural)
    expect(array_filter($rules, fn ($r) => $r instanceof \Illuminate\Validation\Rules\Unique))->toHaveCount(1);
});