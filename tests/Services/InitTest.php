<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\UserStatus;
use Throwable;

class InitTest extends \Tests\TestCase
{

    /**
     * A basic test example.
     */
    public function test__invoke(): void
    {
        $this->createApplication();
        $this->assertTrue(true);
    }

}
