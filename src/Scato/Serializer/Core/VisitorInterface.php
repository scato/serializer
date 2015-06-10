<?php

namespace Scato\Serializer\Core;

interface VisitorInterface
{
    public function getResult();

    public function visitObjectStart();
    public function visitObjectEnd();
    public function visitPropertyStart($name);
    public function visitPropertyEnd($name);

    public function visitArrayStart();
    public function visitArrayEnd();
    public function visitElementStart($key);
    public function visitElementEnd($key);

    public function visitValue($value);

}
