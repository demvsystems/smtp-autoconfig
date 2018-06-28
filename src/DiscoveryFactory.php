<?php

namespace Demv\Smtp\Discovery;

use Demv\Smtp\Discovery\Guess\Discovery as Guess;
use Demv\Smtp\Discovery\Isp\Discovery as IspLookup;
use Demv\Smtp\Discovery\Ispdb\Discovery as IspdbLookup;

/**
 * Class DiscoveryFactory
 * @package Demv\Smtp\Discovery
 */
class DiscoveryFactory
{
    /**
     * @return DiscoveryInterface
     */
    public static function createAutoConfigDiscovery(): DiscoveryInterface
    {
        $ispLookup   = new IspLookup();
        $ispdbLookup = new IspdbLookup();
        $guess       = new Guess();
        $ispLookup->setNextMethod($ispdbLookup);
        $ispdbLookup->setNextMethod($guess);

        return new AutoConfig($ispLookup);
    }
}