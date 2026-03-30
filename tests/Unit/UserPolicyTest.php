<?php

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->policy = new UserPolicy();
    $this->user = User::factory()->create();
});

test('any user can view any models', function () {
    expect($this->policy->viewAny($this->user))->toBeTrue();
});

test('any user can view any model', function () {
    $otherUser = User::factory()->create();

    expect($this->policy->view($this->user, $otherUser))->toBeTrue();
});

test('any user can create models', function () {
    expect($this->policy->create($this->user))->toBeTrue();
});

test('any user can update any model', function () {
    $otherUser = User::factory()->create();

    expect($this->policy->update($this->user, $otherUser))->toBeTrue();
});

test('user cannot delete themselves', function () {
    expect($this->policy->delete($this->user, $this->user))->toBeFalse();
});

test('user can delete other users', function () {
    $otherUser = User::factory()->create();

    expect($this->policy->delete($this->user, $otherUser))->toBeTrue();
});