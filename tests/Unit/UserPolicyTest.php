<?php

use App\Policies\UserPolicy;

class MockUser
{
    public function __construct(public int $id) {}
}

beforeEach(function () {
    $this->policy = new UserPolicy();
});

test('any user can view any models', function () {
    $user = new MockUser(1);

    expect($this->policy->viewAny($user))->toBeTrue();
});

test('any user can view any model', function () {
    $user = new MockUser(1);
    $otherUser = new MockUser(2);

    expect($this->policy->view($user, $otherUser))->toBeTrue();
});

test('any user can create models', function () {
    $user = new MockUser(1);

    expect($this->policy->create($user))->toBeTrue();
});

test('any user can update any model', function () {
    $user = new MockUser(1);
    $otherUser = new MockUser(2);

    expect($this->policy->update($user, $otherUser))->toBeTrue();
});

test('user cannot delete themselves', function () {
    $user = new MockUser(1);

    expect($this->policy->delete($user, $user))->toBeFalse();
});

test('user can delete other users', function () {
    $user = new MockUser(1);
    $otherUser = new MockUser(2);

    expect($this->policy->delete($user, $otherUser))->toBeTrue();
});