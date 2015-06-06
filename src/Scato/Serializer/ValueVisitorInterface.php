<?php

namespace Scato\Serializer;

interface ValueVisitorInterface
{
    public function getResult();

    public function visitObjectStart($class);
    public function visitObjectEnd($class);
    public function visitPropertyStart($name);
    public function visitPropertyEnd($name);

    public function visitArrayStart();
    public function visitArrayEnd();
    public function visitElementStart($key);
    public function visitElementEnd($key);

    public function visitString($value);
    public function visitNull();
    public function visitNumber($value);
    public function visitBoolean($value);

}
