<?php

namespace Demv\Smtp\Discovery\Isp;

use Demv\Smtp\Discovery\AbstractDiscoveryState;
use Demv\Smtp\Discovery\DiscoveryInterface;
use Demv\Smtp\Discovery\DiscoveryStateInterface;
use Demv\Smtp\Discovery\EmailAddress;
use Demv\Smtp\Discovery\ServerConfig\OutGoingServerContainer;

/**
 * Class Provider
 * @package Demv\Smtp\Discovery
 */
class Discovery extends AbstractDiscoveryState implements DiscoveryInterface, DiscoveryStateInterface
{
    private const AUTOCONFIG_URLS = [
        'https://autoconfig.%s/mail/config-v1.1.xml?emailaddress=%s'
    ];

    /**
     * @param string $mailAddress
     *
     * @return OutGoingServerContainer
     */
    public function discoverSmtp(string $mailAddress): OutGoingServerContainer
    {
        $domain = EmailAddress::create($mailAddress)->extractDomain();
        foreach (self::AUTOCONFIG_URLS as $url) {
            $outgoingServers = $this->tryUrl(sprintf($url, $domain, $mailAddress));
            if ($outgoingServers->hasAny()) {
                return $outgoingServers;
            }
        }

        return OutGoingServerContainer::none();
    }

    /**
     * @param string $url
     *
     * @return OutGoingServerContainer
     */
    private function tryUrl(string $url): OutGoingServerContainer
    {
        return OutGoingServerContainer::none();
    }
}