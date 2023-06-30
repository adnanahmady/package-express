<?php

namespace Tests\Support\Traits;

trait AssertionsTrait
{
    /**
     * @param array<string> $keys    Keys.
     * @param array         $array   Target array.
     * @param string        $message Throwing Message.
     *
     * @return void
     */
    protected function assertArrayHasKeys(
        array $keys,
        array $array,
        string $message = ''
    ): void {
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $array, $message);
        }
    }
}
