<?php


namespace Scato\Serializer\Core;


interface TypedValueVisitorInterface extends ValueVisitorInterface
{
    public function visitType($type);
}
