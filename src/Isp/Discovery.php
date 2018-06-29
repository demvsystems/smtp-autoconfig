<?php

namespace Demv\Smtp\Discovery\Isp;

use Demv\Smtp\Discovery\AbstractDiscoveryState;
use Demv\Smtp\Discovery\DiscoveryInterface;
use Demv\Smtp\Discovery\DiscoveryStateInterface;
use Demv\Smtp\Discovery\EmailAddress;
use Demv\Smtp\Discovery\ServerConfig\OutGoingServerContainer;
use Demv\Smtp\Discovery\Xml\OutgoingServerCreator;
use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Provider
 * @package Demv\Smtp\Discovery
 */
class Discovery extends AbstractDiscoveryState implements DiscoveryInterface, DiscoveryStateInterface
{
    private const AUTOCONFIG_URLS = [
        'https://autoconfig.%s/mail/config-v1.1.xml?emailaddress=%s',
        'http://autoconfig.%s/mail/config-v1.1.xml?emailaddress=%s',
        'https://%s/.well-known/autoconfig/mail/config-v1.1.xml?emailaddress=%s',
        'http://%s/.well-known/autoconfig/mail/config-v1.1.xml?emailaddress=%s',
        'https://autoconfig.thunderbird.net/v1.1/%s?emailaddress=%s', //ISPDB
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
        $client = new GuzzleClient(['verify' => false, 'redirect' => true]);

        try {
            $result = $client->get($url);
            if ($result->getStatusCode() !== 200) {
                throw new \Exception();
            }
            $xml      = new \SimpleXMLElement($client->get($url)->getBody()->getContents(), LIBXML_NOERROR | LIBXML_NOWARNING);
            $elements = $xml->xpath("//outgoingServer");

            if ($elements !== null) {
                $container = new OutGoingServerContainer();
                foreach ($elements as $element) {
                    $server = OutgoingServerCreator::createWithSimpleXmlElement($element);
                    if ($server !== null) {
                        $container->add($server);
                    }
                }

                return $container;
            }
        } catch (\Exception $e) {
        }

        return OutGoingServerContainer::none();
    }
}