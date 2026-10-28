<?php

test('the application returns a successful response', function () {
    $this->seed();

    $this->get('/')
        ->assertOk()
        ->assertSee('WordPress Clone');
});
