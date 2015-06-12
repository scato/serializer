<?php
namespace Scato\Serializer\Common;

use Scato\Serializer\Core\Type;

interface ObjectFactoryInterface
{
    public function createObject(Type $type, $properties);
}
