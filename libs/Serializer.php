<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of serializer
 *
 * @author pkoltermann
 */
class Serializer
{
    
    protected $inputFormats = [
        'serialized',
        'json'
    ];
    
    protected $outputFormats = [
        'array',
        'serialized',
        'json'
    ];
    
    public function __get($name) {
        if (!empty($this->$name)) {
            return $this->$name;
        }
        return null;
    }
    
    public function convert($data)
    {
        $decodedVal = '';
        $result = null;
        if (empty($data['from']) || empty($data['to'])  || empty($data['source'])) {
            throw new Exception("Missing mandatory fields");
        }
        
        $decodeMethod = 'decode' . ucfirst($data['from']);
        $encodeMethod = 'encode' .  ucfirst($data['to']);
        try {
            $decodedVal = $this->$decodeMethod($data['source']);
        } catch (Exception $ex) {
            throw new Exception("Input format: '{$data['from']}' not supported");
        }
        if (!$decodedVal) {
            throw new Exception("Could not decode input");
        }

        try {
            $result = $this->$encodeMethod($decodedVal);
        } catch (Exception $ex) {
            throw new Exception("Output format: '{$data['from']}' not supported");
        }
        
        return $result;
    }
    
    public function decodeSerialized($str)
    {
        return unserialize($str);
    }
    
    public function decodeJson($str)
    {
        return json_decode($str);
    }
    
    public function encodeSerialozed($var)
    {
        return serialize($var);
    }
    
    protected function encodeJson($var)
    {
        return json_encode($var);
    }
    
    public function encodeArray($var)
    {
        if (!is_array($var)) {
            return $var;
        }
        $result = "[\n";
        
        foreach ($var as $key=>$value) {
            $result .= "\t'{$key}' => '{$value}'\n";
        }
        
        $result .= "]\n";
        return $result;
    }
}
