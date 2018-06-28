<?php

namespace Demv\Smtp\Discovery\ServerConfig;

/**
 * Class OutgoingServer
 * @package Demv\Smtp\Discovery\ServerConfig
 */
class OutgoingServer
{
    /**
     * @var string;
     */
    private $hostname;
    /**
     * @var int
     */
    private $port;
    /**
     * @var string
     */
    private $socketType;
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $authentication;

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @param string $hostname
     */
    public function setHostname(string $hostname): void
    {
        $this->hostname = $hostname;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getSocketType(): string
    {
        return $this->socketType;
    }

    /**
     * @param string $socketType
     */
    public function setSocketType(string $socketType): void
    {
        $this->socketType = $socketType;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getAuthentication(): string
    {
        return $this->authentication;
    }

    /**
     * @param string $authentication
     */
    public function setAuthentication(string $authentication): void
    {
        $this->authentication = $authentication;
    }

    /**
     * @param OutgoingServer $otherServer
     *
     * @return bool
     */
    public function isEquals(OutgoingServer $otherServer): bool
    {
        return $this->hostname === $otherServer->getHostname() &&
               $this->socketType === $otherServer->socketType &&
               $this->port === $otherServer->getPort();
    }
}