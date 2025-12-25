<?php

declare(strict_types=1);

namespace Core;

/**
 * Pico JSON CMS — Plugin Loader
 *
 * Manifest-based plugin system ONLY.
 * Legacy plugins are NOT supported.
 *
 * Core contract:
 * - load() MUST return array<string>
 */

final class PluginLoader
{
    public function __construct(
        private readonly string $pluginPath
    ) {}

    /**
     * Load plugins and return loaded plugin names
     */
    public function load(): array
    {
        $loaded = [];

        if (!is_dir($this->pluginPath)) {
            return $loaded;
        }

        foreach (scandir($this->pluginPath) as $dir) {
            if ($dir === '.' || $dir === '..') {
                continue;
            }

            $pluginDir = $this->pluginPath . DIRECTORY_SEPARATOR . $dir;
            if (!is_dir($pluginDir)) {
                continue;
            }

            $manifestFile = $pluginDir . '/plugin.json';
            if (!is_file($manifestFile)) {
                continue;
            }

            $manifest = json_decode(
                file_get_contents($manifestFile),
                true
            );

            if (!is_array($manifest)) {
                App::log("Invalid plugin manifest: {$dir}", 'error');
                continue;
            }

            if (!$this->isCompatible($manifest)) {
                App::log("Plugin incompatible: {$dir}", 'warning');
                continue;
            }

            $entry = $manifest['bootstrap'] ?? $manifest['entry'] ?? null;
            if (!$entry) {
                App::log("Plugin entry missing: {$dir}", 'error');
                continue;
            }

            $entryFile = $pluginDir . DIRECTORY_SEPARATOR . $entry;
            if (!is_file($entryFile)) {
                App::log("Plugin entry not found: {$dir}", 'error');
                continue;
            }

            require_once $entryFile;
            $loaded[] = $dir;
        }

        return $loaded;
    }

    /**
     * Compatibility checks
     */
    private function isCompatible(array $manifest): bool
    {
        if (isset($manifest['requires']['php'])) {
            if (!version_compare(PHP_VERSION, $manifest['requires']['php'], '>=')) {
                return false;
            }
        }

        if (isset($manifest['requires']['pico'])) {
            if (!version_compare(
                App::CORE_VERSION,
                ltrim($manifest['requires']['pico'], '>='), 
                '>='
            )) {
                return false;
            }
        }

        return true;
    }
}