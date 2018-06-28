<?php

namespace Demv\Smtp\Discovery;

/**
 * Interface DiscoveryStateInterface
 * @package Demv\Smtp\Discovery
 */
interface DiscoveryStateInterface
{
    /**
     * @param DiscoveryInterface $discovery
     *
     */
    public function setNextMethod(DiscoveryInterface $discovery): void;

    /**
     * @return DiscoveryInterface
     */
    public function getNext(): DiscoveryInterface;

    /**
     * @return bool
     */
    public function hasNext(): bool;
}