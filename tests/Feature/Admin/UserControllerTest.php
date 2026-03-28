<?php

use App\Models\User;

beforeEach(function () {
    $this->withoutVite();
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('users index page is displayed', function () {
    $response = $this->get(route('admin.users.index'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page->component('admin/users/index'));
});

test('users index page shows users', function () {
    User::factory(5)->create();

    $response = $this->get(route('admin.users.index'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('admin/users/index')
        ->has('users.data', 6)
    );
});

test('users can be searched', function () {
    User::factory()->create(['name' => 'John Doe', 'email' => 'john@example.com']);
    User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@example.com']);

    $response = $this->get(route('admin.users.index', ['search' => 'John Doe']));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('admin/users/index')
        ->has('users.data', 1)
    );
});

test('create user page is displayed', function () {
    $response = $this->get(route('admin.users.create'));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page->component('admin/users/create'));
});

test('a new user can be created', function () {
    $response = $this->post(route('admin.users.store'), [
        'name' => 'New User',
        'email' => 'newuser@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('admin.users.index'));
    $response->assertSessionHas('success', 'User created successfully.');

    $this->assertDatabaseHas('users', [
        'name' => 'New User',
        'email' => 'newuser@example.com',
    ]);
});

test('edit user page is displayed', function () {
    $targetUser = User::factory()->create();

    $response = $this->get(route('admin.users.edit', $targetUser));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('admin/users/edit')
        ->has('user')
    );
});

test('a user can be updated', function () {
    $targetUser = User::factory()->create();

    $response = $this->put(route('admin.users.update', $targetUser), [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);

    $response->assertRedirect(route('admin.users.index'));
    $response->assertSessionHas('success', 'User updated successfully.');

    $targetUser->refresh();
    expect($targetUser->name)->toBe('Updated Name');
    expect($targetUser->email)->toBe('updated@example.com');
});

test('a user can be deleted', function () {
    $targetUser = User::factory()->create();

    $response = $this->delete(route('admin.users.destroy', $targetUser));

    $response->assertRedirect(route('admin.users.index'));
    $response->assertSessionHas('success', 'User deleted successfully.');

    $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
});

test('a user cannot delete themselves', function () {
    $response = $this->delete(route('admin.users.destroy', $this->user));

    $response->assertRedirect(route('admin.users.index'));
    $response->assertSessionHas('error', 'You cannot delete your own account.');

    $this->assertDatabaseHas('users', ['id' => $this->user->id]);
});
