<?php

namespace Demv\Smtp\Discovery\ServerConfig;

/**
 * Class OutGoingServerContainer
 * @package Demv\Smtp\Discovery\ServerConfig
 */
class OutGoingServerContainer
{
    /**
     * @var OutgoingServer[]
     */
    private $outgoingServers = [];

    /**
     * @return OutGoingServerContainer
     */
    public static function none(): self
    {
        return new self();
    }

    /**
     * @param OutgoingServer $outgoingServer
     */
    public function add(OutgoingServer $outgoingServer)
    {
        if (!$this->has($outgoingServer)) {
            $this->outgoingServers[] = $outgoingServer;
        }
    }

    /**
     * @param OutGoingServerContainer $container
     */
    public function addAllOfContainer(OutGoingServerContainer $container)
    {
        foreach ($container->getAll() as $outgoingServer) {
            $this->add($outgoingServer);
        }
    }

    /**
     * @return bool
     */
    public function hasAny(): bool
    {
        return count($this->outgoingServers) > 0;
    }

    /**
     * @param OutgoingServer $newServer
     *
     * @return bool
     */
    private function has(OutgoingServer $newServer)
    {
        foreach ($this->outgoingServers as $outgoingServer) {
            if ($outgoingServer->isEquals($newServer)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return OutgoingServer[]
     */
    public function getAll(): array
    {
        return $this->outgoingServers;
    }

    /**
     * @return OutgoingServer[]
     */
    public function getAllTls(): array
    {
        return $this->filter(SocketType::TLS);
    }

    /**
     * @return OutgoingServer[]
     */
    public function getAllSsl(): array
    {
        return $this->filter(SocketType::SSL);
    }

    /**
     * @return array|OutgoingServer[]
     */
    private function filter(string $type)
    {
        return array_filter($this->outgoingServers, function (OutgoingServer $server) use ($type) {
            return $server->getSocketType() === $type;
        });
    }

    /**
     * @return OutgoingServer|null
     */
    public function getBestOutgoingServer(): ?OutgoingServer
    {
        $tls = $this->getAllTls();
        $ssl = $this->getAllSsl();

        if (!empty($tls)) {
            return array_shift($tls);
        }

        if (!empty($ssl)) {
            return array_shift($ssl);
        }

        return null;
    }
}