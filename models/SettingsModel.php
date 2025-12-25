<?php
/**
 * Pico JSON CMS - Settings Model
 *
 * Stores global site configuration.
 * Intended for low-frequency writes.
 */

declare(strict_types=1);

namespace Models;

use Core\App;
use Core\Model;

class SettingsModel extends Model
{
    protected string $file;

    public function __construct()
    {
        $this->file = App::path('content', 'settings.json');
        parent::__construct();
    }

    /**
     * Retrieve a setting value
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();
        return $settings[$key] ?? $default;
    }

    /**
     * Update a single setting
     */
    public function set(string $key, mixed $value): bool
    {
        $settings = $this->all();
        $settings[$key] = $value;

        return $this->save($settings);
    }

    /**
     * Update multiple settings at once
     */
    public function setMany(array $values): bool
    {
        return $this->save(
            array_merge($this->all(), $values)
        );
    }
}