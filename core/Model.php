<?php

declare(strict_types=1);

namespace Core;

/**
 * ------------------------------------------------------
 * Pico JSON CMS — Base Model (CORE)
 * ------------------------------------------------------
 *
 * CORE VERSION: 1.0.0
 *
 * This class is intentionally minimal.
 * It defines the ONLY supported way to interact
 * with JSON-backed storage in Pico JSON CMS.
 *
 * ⚠️ CORE FREEZE NOTICE
 * - Public methods MUST NOT change after v1.0.0
 * - Child models should add domain logic only
 * - No database logic belongs here
 * ------------------------------------------------------
 */
abstract class Model
{
    /**
     * Absolute path to JSON storage file
     * Must be defined by child models.
     */
    protected string $file;

    /**
     * Model constructor
     *
     * Ensures:
     * - $file is defined
     * - Storage file exists
     */
    final public function __construct()
    {
        if (empty($this->file)) {
            throw new \RuntimeException(
                static::class . ' must define a $file property'
            );
        }

        if (!file_exists($this->file)) {
            $this->initializeFile();
        }
    }

    /**
     * Initialize an empty JSON file
     * This method is intentionally protected
     * to prevent external misuse.
     */
    protected function initializeFile(): void
    {
        $dir = dirname($this->file);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents(
            $this->file,
            json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );
    }

    /* =====================================================
     * Read Operations
     * ===================================================== */

    /**
     * Retrieve all records
     *
     * @return array<string|int, mixed>
     */
    public function all(): array
    {
        $json = file_get_contents($this->file);

        if ($json === false) {
            return [];
        }

        $data = json_decode($json, true);

        return is_array($data) ? $data : [];
    }

    /**
     * Find a record by ID
     */
    public function find(string|int $id): mixed
    {
        $items = $this->all();
        return $items[$id] ?? null;
    }

    /* =====================================================
     * Write Operations
     * ===================================================== */

    /**
     * Persist dataset atomically
     *
     * Uses temp file + rename to avoid corruption.
     */
    final public function save(array $data): bool
    {
        $temp = $this->file . '.tmp';

        $json = json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        if ($json === false) {
            return false;
        }

        if (file_put_contents($temp, $json, LOCK_EX) === false) {
            return false;
        }

        return rename($temp, $this->file);
    }
}