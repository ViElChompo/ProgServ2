<?php

/**
 * Filters definition
 */
function getFilters(): array
{
    return [
        'string' => [
            'filter' => FILTER_CALLBACK,
            'options' => fn($value) => htmlspecialchars($value, ENT_QUOTES, 'UTF-8'),
        ],
        'string[]' => [
            'filter' => FILTER_CALLBACK,
            'options' => fn($value) => is_array($value)
                ? array_map(fn($item) => htmlspecialchars($item, ENT_QUOTES, 'UTF-8'), $value)
                : htmlspecialchars($value, ENT_QUOTES, 'UTF-8'),
        ],
        'email' => FILTER_SANITIZE_EMAIL,
        'int' => [
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'flags' => FILTER_REQUIRE_SCALAR,
        ],
        'int[]' => [
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'flags' => FILTER_REQUIRE_ARRAY,
        ],
        'float' => [
            'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
            'flags' => FILTER_FLAG_ALLOW_FRACTION,
        ],
        'float[]' => [
            'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
            'flags' => FILTER_REQUIRE_ARRAY,
        ],
        'url' => FILTER_SANITIZE_URL,
    ];
}

/**
 * Recursively trim strings in an array.
 *
 * @param array $items
 * @return array
 */
function array_trim(array $items): array
{
    return array_map(function ($item) {
        if (is_string($item)) {
            return trim($item);
        } elseif (is_array($item)) {
            return array_trim($item);
        } else {
            return $item;
        }
    }, $items);
}

/**
 * Sanitize inputs based on rules and optionally trim strings.
 *
 * @param array $inputs
 * @param array $fields
 * @param int $default_filter FILTER_CALLBACK
 * @param bool $trim
 * @return array
 */
function sanitize(array $inputs, array $fields = [], int $default_filter = FILTER_CALLBACK, bool $trim = true): array
{
    // Retrieve the filters
    $filters = getFilters();

    // Clean spaces in the keys of the fields array
    $fields = array_map('trim', $fields);  // This will remove any extra spaces in the keys

    if ($fields) {
        // Sanitize based on the filtered fields
        $options = array_map(fn($field) => isset($filters[$field]) ? $filters[$field] : null, $fields);
        $data = filter_var_array($inputs, array_filter($options)); // array_filter to remove any null values
    } else {
        // Apply default sanitization using htmlspecialchars
        $data = filter_var_array($inputs, [
            'filter' => FILTER_CALLBACK,
            'options' => fn($value) => htmlspecialchars($value, ENT_QUOTES, 'UTF-8'),
        ]);
    }

    return $trim ? array_trim($data) : $data;
}
