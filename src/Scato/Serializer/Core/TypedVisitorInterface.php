<?php

namespace Scato\Serializer\Core;

interface TypedVisitorInterface extends VisitorInterface
{
    public function visitType(Type $type);
}
