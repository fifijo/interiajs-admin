<?php

use App\Concerns\ProfileValidationRules;
use App\Models\User;

beforeEach(function () {
    $this->trait = new class {
        use ProfileValidationRules;
    };
});

test('profile rules return correct structure', function () {
    $rules = $this->trait->profileRules();

    expect($rules)->toBeArray();
    expect($rules)->toHaveKeys(['name', 'email']);
});

test('name rules are returned correctly', function () {
    $rules = $this->trait->nameRules();

    expect($rules)->toBeArray();
    expect($rules)->toContain('required');
    expect($rules)->toContain('string');
    expect($rules)->toContain('max:255');
    expect($rules)->toHaveCount(3);
});

test('email rules are returned correctly without user id', function () {
    $rules = $this->trait->emailRules();

    expect($rules)->toBeArray();
    expect($rules)->toContain('required');
    expect($rules)->toContain('string');
    expect($rules)->toContain('email');
    expect($rules)->toContain('max:255');
    // Should contain unique rule
    expect(array_filter($rules, fn ($r) => $r instanceof \Illuminate\Validation\Rule && is_a($r, \Illuminate\Validation\Rule\Unique::class, true)))->toHaveCount(1);
});

test('email rules ignore specific user id', function () {
    $user = User::factory()->create();
    $rules = $this->trait->emailRules($user->id);

    expect($rules)->toBeArray();
    // Should contain unique rule that ignores the user
    $uniqueRules = array_filter($rules, fn ($r) => $r instanceof \Illuminate\Validation\Rule\Unique);
    expect($uniqueRules)->toHaveCount(1);
});