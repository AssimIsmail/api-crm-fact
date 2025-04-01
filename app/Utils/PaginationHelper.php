<?php

namespace App\Utils;

class PaginationHelper
{
    public static function generatePaginationLinks($pagination)
    {
        // Extract pagination links
        $currentPage = $pagination->currentPage();
        $lastPage = $pagination->lastPage();

        $paginationLinks = [];

        // Helper function to extract page number from URL
        $getPageNumber = function ($url) {
            if (!$url) {
                return null;
            }

            // Parse the URL and extract the query string
            $queryString = parse_url($url, PHP_URL_QUERY);
            parse_str($queryString, $params);

            // Return the page number or null if not found
            return $params['page'] ?? null;
        };

        // "Previous" link
        if ($pagination->previousPageUrl()) {
            $paginationLinks[] = [
                'page' => $getPageNumber($pagination->previousPageUrl()),
                'label' => 'PREVIOUS',
                'active' => false
            ];
        }

        // Pages
        for ($i = max(1, $currentPage - 1); $i <= min($lastPage, $currentPage + 1); $i++) {
            $paginationLinks[] = [
                'page' => $i,
                'label' => $i,
                'active' => $i === $currentPage
            ];
        }

        // "Next" link
        if ($pagination->nextPageUrl()) {
            $paginationLinks[] = [
                'page' => $getPageNumber($pagination->nextPageUrl()),
                'label' => 'NEXT',
                'active' => false
            ];
        }

        // Additional information
        $paginationData = [
            'links' => $paginationLinks,
            'current_page' => $currentPage,
            'first_page' => $getPageNumber($pagination->url(1)),
            'last_page' => $getPageNumber($pagination->url($lastPage))
        ];

        return $paginationData;
    }
}
