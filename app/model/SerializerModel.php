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
class SerializerModel
{
    
    protected $inputFormats = array(
        'serialized',
        'json'
    );
    
    protected $outputFormats = array(
        'array',
        'serialized',
        'json'
    );
    
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
    
    protected function decodeSerialized($str)
    {
        return unserialize($str);
    }
    
    protected function decodeJson($str)
    {
        return json_decode($str, true);
    }
    
    protected function encodeSerialized($var)
    {
        return serialize($var);
    }
    
    protected function encodeJson($var)
    {
        if (is_int(JSON_PRETTY_PRINT)) {
            return json_encode($var, JSON_PRETTY_PRINT);
        } else {
            return $this->prettyPrint(json_encode($var));
        }
    }
    
    protected function encodeArray($var, $indent = '')
    {
        if (!is_array($var)) {
            return "'{$var}'";
        }
        $result = "[\n";
        $newIndent = $indent . "    ";
        
        foreach ($var as $key=>$value) {
            $result .= "{$newIndent}'{$key}' => {$this->encodeArray($value, $newIndent)}\n";
        }
        
        $result .= "{$indent}],\n";
        return $result;
    }
    
    protected function prettyPrint( $json )
    {
        $result = '';
        $level = 0;
        $in_quotes = false;
        $in_escape = false;
        $ends_line_level = NULL;
        $json_length = strlen( $json );

        for( $i = 0; $i < $json_length; $i++ ) {
            $char = $json[$i];
            $new_line_level = NULL;
            $post = "";
            if( $ends_line_level !== NULL ) {
                $new_line_level = $ends_line_level;
                $ends_line_level = NULL;
            }
            if ( $in_escape ) {
                $in_escape = false;
            } else if( $char === '"' ) {
                $in_quotes = !$in_quotes;
            } else if( ! $in_quotes ) {
                switch( $char ) {
                    case '}': case ']':
                        $level--;
                        $ends_line_level = NULL;
                        $new_line_level = $level;
                        break;

                    case '{': case '[':
                        $level++;
                    case ',':
                        $ends_line_level = $level;
                        break;

                    case ':':
                        $post = " ";
                        break;

                    case " ": case "\t": case "\n": case "\r":
                        $char = "";
                        $ends_line_level = $new_line_level;
                        $new_line_level = NULL;
                        break;
                }
            } else if ( $char === '\\' ) {
                $in_escape = true;
            }
            if( $new_line_level !== NULL ) {
                $result .= "\n".str_repeat( "\t", $new_line_level );
            }
            $result .= $char.$post;
        }

        return $result;
    }
}
