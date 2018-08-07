<?php

namespace App\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;

class ClientService
{
    /** @var Client */
    private $client;
    private $entityManager;
    private $clientRepository;

    /**
     * client constructor.
     * @param EntityManagerInterface $entityManager
     * @param ClientRepository $clientRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ClientRepository $clientRepository
    ) {
        $this->entityManager = $entityManager;
        $this->clientRepository = $clientRepository;
    }

    public function fromTeamleader($client)
    {
        $this->hydrate($client);
        return $this->client;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function save()
    {
        $this->entityManager->persist($this->client);
        $this->entityManager->flush();
    }

    private function hydrate($client)
    {
        $this->client = $this->clientRepository->findOneBy(['clientId' => $client->id]);
        if (!$this->client) {
            $this->client = new client();
        }

        $this->client->setclientId($client->id);
        $this->client->setName($client->name);
    }
}
