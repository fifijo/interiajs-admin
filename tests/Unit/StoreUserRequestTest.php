<?php

use App\Http\Requests\Admin\StoreUserRequest;

beforeEach(function () {
    $this->request = new StoreUserRequest();
});

test('store user request has correct authorization', function () {
    expect($this->request->authorize())->toBeTrue();
});

test('store user request has correct validation rules', function () {
    $rules = $this->request->rules();

    expect($rules)->toBeArray();
    expect($rules)->toHaveKeys(['name', 'email', 'password']);
    expect($rules['name'])->toContain('required');
    expect($rules['email'])->toContain('required');
    expect($rules['password'])->toContain('required');
    expect($rules['password'])->toContain('confirmed');
    // Email should have unique rule
    expect(array_filter($rules['email'], fn ($r) => $r instanceof \Illuminate\Validation\Rule && is_a($r, \Illuminate\Validation\Rule\Unique::class, true)))->toHaveCount(1);
});

test('store user request has password confirmation required', function () {
    $rules = $this->request->rules();

    expect($rules['password'])->toContain('confirmed');
});