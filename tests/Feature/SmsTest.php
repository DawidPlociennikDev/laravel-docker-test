<?php

namespace Tests\Feature;

use App\Http\Controllers\SmsController;
use App\Models\Sms;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SmsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_sms_page_exist(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_sms_table_exist(): void
    {
        if (Schema::hasTable('smses')) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    public function test_send_sms(): void
    {
        $response = $this->call('POST', 'sms', array(
            '_token' => csrf_token(),
            'phone_number' => '123123132',
            'message' => 'Test message',
        ));
        $this->assertEquals(200, $response->getStatusCode());
    }
}
