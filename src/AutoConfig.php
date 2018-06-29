<?php

namespace Demv\Smtp\Discovery;

use Demv\Smtp\Discovery\ServerConfig\OutGoingServerContainer;

/**
 * Class AutoConfig
 * @package Demv\Smtp\Discovery
 */
class AutoConfig implements DiscoveryInterface
{
    /**
     * @var DiscoveryInterface
     */
    private $discovery;

    /**
     * AutoConfig constructor.
     *
     * @param DiscoveryStateInterface $discovery
     */
    public function __construct(DiscoveryStateInterface $discovery)
    {
        $this->discovery = $discovery;
    }

    /**
     * @param string $mailAddress
     *
     * @return OutGoingServerContainer
     */
    public function discoverSmtp(string $mailAddress): OutGoingServerContainer
    {
        $discovery = $this->discovery;
        while ($discovery !== null) {
            $servers = $discovery->discoverSmtp($mailAddress);
            if ($servers->hasAny()) {
                return $servers;
            }
            $discovery = $discovery->getNext();
        }

        return new OutGoingServerContainer();
    }
}