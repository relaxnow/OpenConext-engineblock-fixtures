<?php

namespace OpenConext\Component\EngineBlockFixtures\DataStore;

class SerializedDataStore extends AbstractDataStore
{
    protected function encode($data)
    {
        return serialize($data);
    }

    protected function decode($data)
    {
        return unserialize($data);
    }
}
