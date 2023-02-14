<?php

namespace Tests;

trait HarmonyApiHelpers
{
    /**
     * Helper function to assert results from a Harmony render()
     */
    private function maRender(array $result): array
    {
        return [
            'status' => 'success',
            'data' => $result,
        ];
    }

    /**
     * Helper to assert results from Harmony status helpers like success() and error()
     */
    private function maStatus(string $key, array $replace = [], ?string $status = 'success'): array
    {
        return [
            'status' => $status,
            'data' => [
                'success' => true,
                'message' => __($key, $replace),
            ],
        ];
    }
}
