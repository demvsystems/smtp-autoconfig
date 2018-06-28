<?php

namespace Demv\Smtp\Discovery\ServerConfig;

/**
 * Interface SocketType
 * @package Demv\Smtp\Discovery\ServerConfig
 */
interface SocketType
{
    const SSL = 'SSL';
    const TLS = 'STARTTLS';
}