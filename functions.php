<?php
/**
 * Pico JSON CMS - Global Functions
 *
 * Author: Elmahdi
 * GitHub: https://github.com/almhdy24/pico-json-cms
 * Description:
 *   Global helper functions for hooks and pagination.
 *
 * License: MIT
 */

use Core\Hooks;

function add_action($hook, $callback) {
    Hooks::add_action($hook, $callback);
}

function do_action($hook, ...$args) {
    Hooks::do_action($hook, ...$args);
}

function add_filter($hook, $callback) {
    Hooks::add_filter($hook, $callback);
}

function apply_filters($hook, $value, ...$args) {
    return Hooks::apply_filters($hook, $value, ...$args);
}

/**
 * Paginate an array of items.
 *
 * @param array $items Full array of items
 * @param int $perPage Number of items per page
 * @param int $currentPage Current page number
 * @return array ['items' => [], 'totalPages' => int]
 */
function paginate(array $items, int $perPage = 5, int $currentPage = 1): array
{
    $totalItems = count($items);
    $totalPages = max(1, ceil($totalItems / $perPage));

    $currentPage = max(1, min($currentPage, $totalPages));
    $offset = ($currentPage - 1) * $perPage;

    return [
        'items' => array_slice($items, $offset, $perPage, true),
        'totalPages' => $totalPages,
        'currentPage' => $currentPage,
    ];
}