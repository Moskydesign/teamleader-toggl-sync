<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $togglUserAgent;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $togglUid;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $teamleaderWorkerId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTogglUserAgent(): string
    {
        return $this->togglUserAgent;
    }

    /**
     * @param string $togglUserAgent
     */
    public function setTogglUserAgent(string $togglUserAgent)
    {
        $this->togglUserAgent = $togglUserAgent;
    }

    /**
     * @return int
     */
    public function getTogglUid(): int
    {
        return $this->togglUid;
    }

    /**
     * @param int $togglUid
     */
    public function setTogglUid(int $togglUid)
    {
        $this->togglUid = $togglUid;
    }

    /**
     * @return int
     */
    public function getTeamleaderWorkerId(): int
    {
        return $this->teamleaderWorkerId;
    }

    /**
     * @param int $teamleaderWorkerId
     */
    public function setTeamleaderWorkerId(int $teamleaderWorkerId)
    {
        $this->teamleaderWorkerId = $teamleaderWorkerId;
    }
}
