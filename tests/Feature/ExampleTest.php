<?php

test("application returns a successful response", function() {
    $response = $this->get('/');

    $response->assertStatus(200);
});

// it('returns a successful response', function () {
//     $response = $this->get('/');

//     $response->assertStatus(200);
// });