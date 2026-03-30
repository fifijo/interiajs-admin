<?php

use App\Models\User;
use App\Policies\UserPolicy;

beforeEach(function () {
    $this->policy = new UserPolicy();
});

test('any user can view any models', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    expect($this->policy->viewAny($user))->toBeTrue();
});

test('any user can view any model', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    expect($this->policy->view($user, $otherUser))->toBeTrue();
});

test('any user can create models', function () {
    $user = User::factory()->create();

    expect($this->policy->create($user))->toBeTrue();
});

test('any user can update any model', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    expect($this->policy->update($user, $otherUser))->toBeTrue();
});

test('user cannot delete themselves', function () {
    $user = User::factory()->create();

    expect($this->policy->delete($user, $user))->toBeFalse();
});

test('user can delete other users', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    expect($this->policy->delete($user, $otherUser))->toBeTrue();
});