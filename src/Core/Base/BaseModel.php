<?php

declare (strict_types = 1);

namespace Core\Base;

use Utils\Libs\Converter;

class BaseModel {

    public function __construct($data = null) {
        if ($data) {
            $object = Converter::ToObject($data);
            $this->mapFromArray($object);
        }
    }

    protected function mapFromArray(object $object): void {

        $modelProperties = get_class_vars(get_class($this));
        foreach ($modelProperties as $key => $value) {
            $this->$key = property_exists($object, $key) ? $object->$key : null;
        }
    }
}