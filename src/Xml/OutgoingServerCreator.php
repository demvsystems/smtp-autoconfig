<?php

namespace Demv\Smtp\Discovery\Xml;

use Demv\Smtp\Discovery\ServerConfig\OutgoingServer;
use SimpleXMLElement;

class OutgoingServerCreator
{
    /**
     * @param SimpleXMLElement $element
     *
     * @return OutgoingServer|null
     */
    public static function createWithSimpleXmlElement(SimpleXMLElement $element): ?OutgoingServer
    {
        if (!self::isValidElement($element)) {
            return null;
        }
        $outgoingServer = new OutgoingServer();
        $outgoingServer->setHostname($element->hostname);
        $outgoingServer->setPort((int) $element->port);
        $outgoingServer->setSocketType($element->socketType);

        return $outgoingServer;
    }

    /**
     * @param SimpleXMLElement $element
     *
     * @return bool
     */
    private static function isValidElement(SimpleXMLElement $element): bool
    {
        return !empty($element->hostname) &&
               !empty($element->port) &&
               !empty($element->socketType);
    }
}