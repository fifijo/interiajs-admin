<?php

use App\Policies\UserPolicy;

test('user policy can be instantiated', function () {
    $policy = new UserPolicy();
    
    expect($policy)->toBeInstanceOf(UserPolicy::class);
});

test('user policy has viewAny method', function () {
    $policy = new UserPolicy();
    
    expect(method_exists($policy, 'viewAny'))->toBeTrue();
});

test('user policy has view method', function () {
    $policy = new UserPolicy();
    
    expect(method_exists($policy, 'view'))->toBeTrue();
});

test('user policy has create method', function () {
    $policy = new UserPolicy();
    
    expect(method_exists($policy, 'create'))->toBeTrue();
});

test('user policy has update method', function () {
    $policy = new UserPolicy();
    
    expect(method_exists($policy, 'update'))->toBeTrue();
});

test('user policy has delete method', function () {
    $policy = new UserPolicy();
    
    expect(method_exists($policy, 'delete'))->toBeTrue();
});
