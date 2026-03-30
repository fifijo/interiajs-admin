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
    expect(in_array('required', $rules['name']))->toBeTrue();
    expect(in_array('required', $rules['email']))->toBeTrue();
    expect(in_array('required', $rules['password']))->toBeTrue();
    expect(in_array('confirmed', $rules['password']))->toBeTrue();
    // Email should have unique rule - check for Rules\Unique (plural)
    expect(array_filter($rules['email'], fn ($r) => $r instanceof \Illuminate\Validation\Rules\Unique))->toHaveCount(1);
});

test('store user request has password confirmation required', function () {
    $rules = $this->request->rules();

    expect(in_array('confirmed', $rules['password']))->toBeTrue();
});