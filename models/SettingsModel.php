<?php
/**
 * Pico JSON CMS - SettingsModel
 *
 * Author: Elmahdi
 * GitHub: https://github.com/almhdy24/pico-json-cms
 * Description:
 *   Model for handling application settings stored in JSON.
 *
 * License: MIT
 */

namespace Models;
use Core\App;
use Core\Model;

class SettingsModel extends Model {
    protected $file = App::path('content', 'settings.json');

    public function get($key, $default = null) {
        $data = $this->all();
        return $data[$key] ?? $default;
    }

    public function update($key, $value) {
        $data = $this->all();
        $data[$key] = $value;
        $this->save($data);
    }
}