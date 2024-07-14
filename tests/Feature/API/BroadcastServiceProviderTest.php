<?php

namespace Tests\Unit\Providers;

use App\Providers\BroadcastServiceProvider;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class BroadcastServiceProviderTest extends TestCase
{
    public function testBroadcastServiceProvider()
    {
        $provider = new BroadcastServiceProvider($this->app);

        $provider->boot();
        $this->assertTrue(
            File::exists(base_path('routes/channels.php')),
            'channels.php file is not loaded.'
        );
        $this->assertStringContainsString(
            'Broadcast::routes();',
            File::get(base_path('routes/channels.php')),
            'Broadcast routes are not registered in channels.php.'
        );
    }
}
