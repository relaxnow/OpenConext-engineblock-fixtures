<?php

namespace OpenConext\Component\EngineBlockFixtures;

use OpenConext\Component\EngineBlockFixtures\DataStore\AbstractDataStore;

/**
 * Ids
 * @package OpenConext\Component\EngineBlockFixtures
 */
class IdFixture
{
    protected $dataStore;
    protected $frames = array();

    /**
     * @param AbstractDataStore $dataStore
     */
    function __construct(AbstractDataStore $dataStore)
    {
        $this->dataStore = $dataStore;
        $this->frames = $this->dataStore->load();
    }

    /**
     * Get the top frame off the queue for use.
     */
    public function shiftFrame()
    {
        return array_shift($this->frames);
    }

    /**
     * Queue up another set of ids to use.
     *
     * @param IdFrame $frame
     */
    public function addFrame(IdFrame $frame)
    {
        $this->frames[] = $frame;
        return $this;
    }

    /**
     * Remove all frames.
     */
    public function clear()
    {
        $this->frames = array();
        return $this;
    }

    /**
     * On destroy write out the current state.
     */
    public function __destruct()
    {
        $this->dataStore->save($this->frames);
    }
}
