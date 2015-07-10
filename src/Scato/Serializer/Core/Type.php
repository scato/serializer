<?php

namespace Scato\Serializer\Core;

use LogicException;

/**
 * A class, array or scalar type
 */
class Type
{
    /**
     * @var string
     */
    private $string;

    /**
     * @var array
     */
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

    /**
     * @var array
     */
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

    /**
     * @param string $string
     */
    private function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * Create a Type from its string representation
     *
     * @param string|null $string
     * @return Type
     */
    public static function fromString($string = null)
    {
        if ($string === null) {
            $string = 'mixed';
        }

        return new self($string);
    }

    /**
     * Return the string representation for this Type
     *
     * @return mixed
     */
    public function toString()
    {
        return $this->string;
    }

    /**
     * Is this a class type?
     *
     * @return boolean
     */
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

    /**
     * Is this an array type?
     *
     * @return boolean
     */
    public function isArray()
    {
        if ($this->string === 'array') {
            return true;
        }

        if ($this->string === 'mixed') {
            return true;
        }

        if (preg_match('/\\[\\]$/', $this->string)) {
            return true;
        }

        return false;
    }

    /**
     * Is this one of the integer types?
     *
     * @return boolean
     */
    public function isInteger()
    {
        if (in_array($this->string, array('int', 'integer'))) {
            return true;
        }

        return false;
    }

    /**
     * Is this the float type?
     *
     * @return boolean
     */
    public function isFloat()
    {
        if (in_array($this->string, array('float'))) {
            return true;
        }

        return false;
    }

    /**
     * Is this one of the boolean types?
     *
     * @return boolean
     */
    public function isBoolean()
    {
        if (in_array($this->string, array('bool', 'boolean'))) {
            return true;
        }

        return false;
    }

    /**
     * The type for the elements of an array of this type
     *
     * @return Type
     * @throws LogicException
     */
    public function getElementType()
    {
        if ($this->string === 'array') {
            return self::fromString('mixed');
        }

        if ($this->string === 'mixed') {
            return self::fromString('mixed');
        }

        if (preg_match('/\\[\\]$/', $this->string)) {
            return self::fromString(preg_replace('/\\[\\]$/', '', $this->string));
        }

        throw new LogicException("Type '{$this->string}' is not an array type");
    }

    /**
     * The type for an array containing values of this type
     *
     * @return Type
     */
    public function getArrayType()
    {
        if ($this->string === 'mixed') {
            return self::fromString('array');
        }

        return self::fromString($this->string . '[]');
    }
}
