<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmolumentoDto extends Model
{
    public $timestamps = false;
    protected $table = null;

    public $codigo;
    public $valor;
    public $duc;

    public function __construct(array|string $attributes = [])
    {
        if (is_string($attributes)) {
            $attributes = json_decode($attributes, true) ?? [];
        }

        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}