<?php

class Model
{
    public static function factory($model) {
        Router::includeModel($model);
        $modelName = ucfirst($model) . 'Model';
        $object = new $modelName();
        return $object;
    }
}