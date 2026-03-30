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
    expect($rules)->toContain('required');
    expect($rules)->toContain('string');
    expect($rules)->toContain('max:255');
    expect($rules)->toHaveCount(3);
});

test('email rules are returned correctly without user id', function () {
    $rules = $this->trait->publicEmailRules();

    expect($rules)->toBeArray();
    expect($rules)->toContain('required');
    expect($rules)->toContain('string');
    expect($rules)->toContain('email');
    expect($rules)->toContain('max:255');
    // Should contain unique rule
    expect(array_filter($rules, fn ($r) => $r instanceof \Illuminate\Validation\Rule && is_a($r, \Illuminate\Validation\Rule\Unique::class, true)))->toHaveCount(1);
});