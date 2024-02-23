<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email_verified_at' => null,
    ]);

});

test('Email can be verified', function () {
    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $this->user->id, 'hash' => sha1($this->user->email)]
    );

    $response = $this->actingAs($this->user)->get($verificationUrl);

    Event::assertDispatched(Verified::class);
    $this->assertTrue($this->user->fresh()->hasVerifiedEmail());
    $url = config('app.frontend_url');
    $path = config('frontend.verified_email_success_redirect');
    $param = Arr::query(['user_name' => $this->user->first_name]);
    $response->assertRedirect($url . $path . "?$param");
});

test('Email cannot be verified more then once', function () {
    $user = User::factory()->create();
    Event::fake();
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );
    $response = $this->actingAs($user)->get($verificationUrl);
    Event::assertNotDispatched(Verified::class);
    $this->assertTrue($user->fresh()->hasVerifiedEmail());
    $url = config('app.frontend_url');
    $path = config('frontend.verified_email_success_redirect');
    $param = Arr::query(['user_name' => $user->first_name]);
    $response->assertRedirect($url . $path . "?$param");
});

test('Email is not verified with invalid hash', function () {
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $this->user->id, 'hash' => sha1('wrong-email')]
    );

    $this->actingAs($this->user)->get($verificationUrl);

    $this->assertFalse($this->user->fresh()->hasVerifiedEmail());
});

test('Email is not verified with invalid route signature', function () {
    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $this->user->id, 'hash' => sha1($this->user->email)]
    );

    $verificationUrl = str_replace("signature=", 'signature=fake_', $verificationUrl);

    $response = $this->actingAs($this->user)->get($verificationUrl);
    Event::assertNotDispatched(Verified::class);
    $this->assertFalse($this->user->fresh()->hasVerifiedEmail());
    $url = config('app.frontend_url');
    $path = config('frontend.verified_email_fail_redirect');
    $response->assertRedirect($url . $path);
});


test('Email is not verified with expired route and contains resend url', function () {
    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->subMinutes(1),
        ['id' => $this->user->id, 'hash' => sha1($this->user->email)]
    );

    $response = $this->actingAs($this->user)->get($verificationUrl);
    Event::assertNotDispatched(Verified::class);
    $this->assertFalse($this->user->fresh()->hasVerifiedEmail());
    $path = config('frontend.verified_email_fail_redirect');
    $response->assertRedirect()
    ->assertRedirectContains($path)
    ->assertRedirectContains('?resend=');
});
