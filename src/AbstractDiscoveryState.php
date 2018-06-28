<?php

namespace Demv\Smtp\Discovery;

/**
 * Class AbstractDiscoveryState
 * @package Demv\Smtp\Discovery
 */
abstract class AbstractDiscoveryState implements DiscoveryStateInterface
{
    /**
     * @var DiscoveryInterface
     */
    private $next;

    /**
     * @param DiscoveryInterface $discovery
     */
    public function setNextMethod(DiscoveryInterface $discovery): void
    {
        $this->next = $discovery;
    }

    /**
     * @return DiscoveryInterface
     */
    public function getNext(): DiscoveryInterface
    {
        return $this->next;
    }

    /**
     * @return bool
     */
    public function hasNext(): bool
    {
        return $this->next !== null;
    }
}