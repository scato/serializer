<?php


namespace Scato\Serializer\Common;


interface TypeProviderInterface
{
    public function getType($class, $name);
}
