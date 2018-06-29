<?php

namespace Demv\Smtp\Discovery\Guess;

use Demv\Smtp\Discovery\AbstractDiscoveryState;
use Demv\Smtp\Discovery\DiscoveryInterface;
use Demv\Smtp\Discovery\DiscoveryStateInterface;
use Demv\Smtp\Discovery\ServerConfig\OutgoingServer;
use Demv\Smtp\Discovery\ServerConfig\OutGoingServerContainer;
use Demv\Smtp\Discovery\ServerConfig\SocketType;
use EmailAuth\Discover;

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
        $discover = new Discover();
        try {


            $result = $discover->smtp($mailAddress);

            if ($this->isValid($result ?? [])) {
                $server     = new OutgoingServer();
                $encryption = $result['encryption'];
                $server->setSocketType($encryption === 'TLS' ? SocketType::TLS : SocketType::SSL);
                $server->setHostname($result['host']);
                $server->setPort((int) $result['port']);

                $container = new OutGoingServerContainer();
                $container->add($server);

                return $container;
            }
        } catch (\Exception $exception) {

        }

        return OutGoingServerContainer::none();
    }

    private function isValid(array $result)
    {
        return !empty($result['encryption']) &&
               !empty($result['host']) &&
               !empty($result['port']);
    }
}