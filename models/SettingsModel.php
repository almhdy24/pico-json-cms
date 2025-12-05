<?php
namespace Models;
use Core\Model;

class SettingsModel extends Model {
    protected $file = __DIR__ . '/../content/settings.json';

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