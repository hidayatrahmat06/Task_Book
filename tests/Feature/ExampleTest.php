<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Basic availability check for guest pages.
     */
    public function test_guest_can_open_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
}
