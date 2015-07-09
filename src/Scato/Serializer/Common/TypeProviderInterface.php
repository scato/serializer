<?php

namespace Scato\Serializer\Common;

use Scato\Serializer\Core\Type;

interface TypeProviderInterface
{
    public function getType(Type $class, $name);
}
