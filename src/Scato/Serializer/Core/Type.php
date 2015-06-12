<?php

namespace Scato\Serializer\Core;

use LogicException;

class Type
{
    private $string;

    private static $primitiveTypes = array(
        'string',
        'int',
        'integer',
        'float',
        'bool',
        'boolean',
        'array',
        'resource',
        'null',
        'callable'
    );

    private static $specialTypes = array(
        'mixed',
        'void',
        'object',
        'false',
        'true',
        'self',
        'static',
        '$this'
    );

    private function __construct($string)
    {
        $this->string = $string;
    }

    public static function fromString($string = null)
    {
        if ($string === null) {
            $string = 'mixed';
        }

        return new self($string);
    }

    public function toString()
    {
        return $this->string;
    }

    public function isClass()
    {
        if (in_array($this->string, self::$primitiveTypes)) {
            return false;
        }

        if (in_array($this->string, self::$specialTypes)) {
            return false;
        }

        if (preg_match('/\\[\\]$/', $this->string)) {
            return false;
        }

        return true;
    }

    public function isArray()
    {
        if ($this->string === 'array') {
            return true;
        }

        if (preg_match('/\\[\\]$/', $this->string)) {
            return true;
        }

        return false;
    }

    public function isInteger()
    {
        if (in_array($this->string, array('int', 'integer'))) {
            return true;
        }

        return false;
    }

    public function isFloat()
    {
        if (in_array($this->string, array('float'))) {
            return true;
        }

        return false;
    }

    public function isBoolean()
    {
        if (in_array($this->string, array('bool', 'boolean'))) {
            return true;
        }

        return false;
    }

    public function getElementType()
    {
        if ($this->string === 'array') {
            return self::fromString('mixed');
        }

        if (preg_match('/\\[\\]$/', $this->string)) {
            return self::fromString(preg_replace('/\\[\\]$/', '', $this->string));
        }

        throw new LogicException("Type '{$this->string}' is not an array type");
    }

    public function getArrayType()
    {
        if ($this->string === 'mixed') {
            return self::fromString('array');
        }

        return self::fromString($this->string . '[]');
    }
}
