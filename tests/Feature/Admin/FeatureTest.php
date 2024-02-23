<?php

beforeEach(function () {
    $this->admin = createSuperAdmin();
    $this->user = createUser();

    $this->featureName = fake()->colorName;
    Feature::define($this->featureName, true);
    Feature::for('__global')->active($this->featureName);
    $this->assertDatabaseHas('features', ['name' => $this->featureName]);
});

test('frontend can see feature flags', function () {
    $this->get(route('features.index'))
        ->assertOk()
        ->assertJsonStructure([$this->featureName]);
});

test('Super Admin can see Features', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.features.index'))
        ->assertOk();
});

test('User without permission cannot see Features', function () {
    $this->actingAs($this->user)
        ->get(route('admin.features.index'))
        ->assertForbidden();
});

test('User with permission can see Features', function () {
    $this->user->givePermissionTo('view dashboard', 'view features');

    $this->actingAs($this->user)
        ->get(route('admin.features.index'))
        ->assertOk();
});

test('Super Admin can add Features', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.features.create'))
        ->assertOk();
});

test('User without permission cannot add Features', function () {
    $this->actingAs($this->user)
        ->get(route('admin.features.create'))
        ->assertForbidden();
});

test('User with permission can add Features', function () {
    $this->user->givePermissionTo('view dashboard', 'edit features');

    $this->actingAs($this->user)
        ->get(route('admin.features.create'))
        ->assertValid();
});

test('Super Admin can delete Features', function () {
    $this->actingAs($this->admin)
        ->delete(route('admin.features.destroy'), ['featureName' => $this->featureName])
        ->assertValid();

    $this->assertDatabaseMissing('features', ['name' => $this->featureName]);
});

test('User without permission cannot delete Features', function () {
    $this->actingAs($this->user)
        ->delete(route('admin.features.destroy'), ['featureName' => $this->featureName])
        ->assertForbidden();

    $this->assertDatabaseHas('features', ['name' => $this->featureName]);
});

test('User with permission can delete Features', function () {
    $this->user->givePermissionTo('view dashboard', 'edit features');

    $this->actingAs($this->user)
        ->delete(route('admin.features.destroy'), ['featureName' => $this->featureName])
        ->assertValid();

    $this->assertDatabaseMissing('features', ['name' => $this->featureName]);
});

test('Super Admin can store Features', function () {
    $featureName = fake()->userName;

    $this->actingAs($this->admin)
        ->post(route('admin.features.store'), [
            'featureName' => $featureName,
            'active' => 1,
        ])
        ->assertValid();
    $this->assertDatabaseHas('features', ['name' => $featureName]);
});

test('User without permission cannot store Features', function () {
    $featureName = fake()->userName;

    $this->actingAs($this->user)
        ->post(route('admin.features.store'), [
            'featureName' => $featureName,
            'active' => 1,
        ])
        ->assertForbidden();
    $this->assertDatabaseMissing('features', ['name' => $featureName]);
});

test('User with permission can store Features', function () {
    $this->user->givePermissionTo('view dashboard', 'edit features');

    $featureName = fake()->userName;

    $a = $this->actingAs($this->user)
        ->post(route('admin.features.store'), [
            'featureName' => $featureName,
            'active' => 1,
        ])
        ->assertValid();
    $this->assertDatabaseHas('features', ['name' => $featureName]);
});

test('Super Admin can toggle Features', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.features.toggle'), ['featureName' => $this->featureName])
        ->assertValid();
});

test('User without permission cannot toggle Features', function () {
    $this->actingAs($this->user)
        ->post(route('admin.features.toggle'), ['featureName' => $this->featureName])
        ->assertForbidden();
});

test('User with permission can toggle Features', function () {
    $this->user->givePermissionTo('view dashboard', 'edit features');
    $this->actingAs($this->user)
        ->post(route('admin.features.toggle'), ['featureName' => $this->featureName])
        ->assertValid();
});
