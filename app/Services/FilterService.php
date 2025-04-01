<?php

namespace App\Services;


class FilterService
{
    /**
     * Extract filters from the request for user-related queries.
     *
     * @param array $allowedFilters
     * @return array
     */
    public function getFilters(array $allowedFilters): array
    {
        $filters = request()->only($allowedFilters);

        // Sanitize and process filters
        foreach ($filters as $key => $value) {
            // Remove keys with empty or null-like values
            if ($value === null || (is_string($value) && trim($value) === '') || $value === 'null') {
                unset($filters[$key]);
                continue;
            }

            // Convert 'true'/'false' strings to actual booleans
            if ($this->isBooleanFilter($key) && is_string($value)) {
                $filters[$key] = $value === 'true';
            }

            // Add more sanitization or conversions if needed
        }

        return $filters;
    }
    /**
     * Check if a filter key is expected to be a boolean.
     *
     * @param string $key
     * @return bool
     */
    private function isBooleanFilter(string $key): bool
    {
        // Add more keys if you have other boolean filters
        $booleanFilters = ['is_activated', 'is_verified']; // Example: Add more as needed

        return in_array($key, $booleanFilters);
    }
}
