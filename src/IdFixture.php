<?php

namespace OpenConext\Component\EngineBlockFixtures;

use OpenConext\Component\EngineBlockFixtures\DataStore\AbstractDataStore;

/**
 * Ids
 * @package OpenConext\Component\EngineBlockFixtures
 */
class IdFixture
{
    const FRAME_REQUEST = 'request';
    const FRAME_RESPONSE = 'response';

    protected $dataStore;

    /**
     * @var IdFrame[]
     */
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
        if (empty($this->frames)) {
            throw new \RuntimeException('No more IdFrames?');
        }
        return array_shift($this->frames);
    }

    public function hasFrame($frameName)
    {
        return isset($this->frames[$frameName]);
    }

    public function getFrame($frameName)
    {
        if (!isset($this->frames[$frameName])) {
            throw new \RuntimeException("No frame with given name '$frameName'");
        }
        return $this->frames[$frameName];
    }

    /**
     * Queue up another set of ids to use.
     *
     * @param IdFrame $frame
     */
    public function addFrame($frameName, IdFrame $frame)
    {
        $this->frames[$frameName] = $frame;
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
