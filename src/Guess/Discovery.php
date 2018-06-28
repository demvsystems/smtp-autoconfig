<?php

namespace Demv\Smtp\Discovery\Guess;

use Demv\Smtp\Discovery\AbstractDiscoveryState;
use Demv\Smtp\Discovery\DiscoveryInterface;
use Demv\Smtp\Discovery\DiscoveryStateInterface;
use Demv\Smtp\Discovery\ServerConfig\OutGoingServerContainer;

/**
 * Class Provider
 * @package Demv\Smtp\Discovery
 */
class Discovery extends AbstractDiscoveryState implements DiscoveryInterface, DiscoveryStateInterface
{
    /**
     * @param string $mailAddress
     *
     * @return OutGoingServerContainer
     */
    public function discoverSmtp(string $mailAddress): OutGoingServerContainer
    {
        // TODO: Implement discoverSmtp() method.
    }
}