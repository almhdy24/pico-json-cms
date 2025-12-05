<?php
namespace Core;

class Model {
    protected $file;

    public function all() {
        return json_decode(file_get_contents($this->file), true) ?: [];
    }

    public function find($id) {
        $items = $this->all();
        return $items[$id] ?? null;
    }

    public function save($data) {
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }
}