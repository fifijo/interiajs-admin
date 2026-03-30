<?php

use App\Http\Requests\Admin\StoreUserRequest;
use Illuminate\Support\Facades\Validator;

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
    expect($rules['email'])->toContain('unique:users');
    expect($rules['password'])->toContain('required');
    expect($rules['password'])->toContain('confirmed');
});

test('store user request validates valid data', function () {
    $data = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $validator = Validator::make($data, $this->request->rules());
    expect($validator->passes())->toBeTrue();
});

test('store user request fails without required fields', function () {
    $data = [];

    $validator = Validator::make($data, $this->request->rules());
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('name'))->toBeTrue();
    expect($validator->errors()->has('email'))->toBeTrue();
    expect($validator->errors()->has('password'))->toBeTrue();
});

test('store user request fails with invalid email', function () {
    $data = [
        'name' => 'Test User',
        'email' => 'not-an-email',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $validator = Validator::make($data, $this->request->rules());
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('email'))->toBeTrue();
});

test('store user request fails when password confirmation missing', function () {
    $data = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
    ];

    $validator = Validator::make($data, $this->request->rules());
    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('password'))->toBeTrue();
});