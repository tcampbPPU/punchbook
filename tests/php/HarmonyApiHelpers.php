<?php

namespace Tests;

trait HarmonyApiHelpers
{
    /**
     * Helper function to assert results from a Harmony render()
     * @param array $result
     * @return array
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
     * @param string $key
     * @param array $replace
     * @param string|null $status
     * @return array
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
