<?php

uses(Tests\TestCase::class)->in( __DIR__ );

test('team test returns a successful response', function () {
    $this->get(route('home'))->assertOk();
});