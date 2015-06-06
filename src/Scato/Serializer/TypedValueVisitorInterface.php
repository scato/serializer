<?php


namespace Scato\Serializer;


interface TypedValueVisitorInterface extends ValueVisitorInterface
{
    public function visitType($type);
}
