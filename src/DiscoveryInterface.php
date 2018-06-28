<?php

namespace Demv\Smtp\Discovery;

use Demv\Smtp\Discovery\ServerConfig\OutGoingServerContainer;

interface DiscoveryInterface
{
    /**
     * @param string $mailAddress
     *
     * @return OutGoingServerContainer
     */
    public function discoverSmtp(string $mailAddress): OutGoingServerContainer;
}