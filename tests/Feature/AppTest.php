<?php

test('The application returns a successful response', function () {
    $this->get(route('home'))->assertOk();
});

test('The API returns a successful response', function () {
    $this->get(route('home.api'))->assertOk();
});
