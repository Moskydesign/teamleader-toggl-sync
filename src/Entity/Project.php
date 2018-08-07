<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $projectId;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $projectNr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contactOrCompany;

    /**
     * @ORM\Column(type="integer")
     */
    private $contactOrCompanyId;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Milestone", mappedBy="project")
     */
    private $milestones;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    public function __construct()
    {
        $this->milestones = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getProjectId() : ?int
    {
        return $this->projectId;
    }

    /**
     * @param mixed $projectId
     */
    public function setProjectId(int $projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * @return int
     */
    public function getProjectNr() : int
    {
        return $this->projectNr;
    }

    /**
     * @param int $projectNr
     */
    public function setProjectNr(int $projectNr)
    {
        $this->projectNr = $projectNr;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title ?? "";
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContactOrCompany() : string
    {
        return $this->contactOrCompany ?? "";
    }

    /**
     * @param string $contactOrCompany
     */
    public function setContactOrCompany(string $contactOrCompany)
    {
        $this->contactOrCompany = $contactOrCompany;
    }

    /**
     * @return int
     */
    public function getContactOrCompanyId() : ?int
    {
        return $this->contactOrCompanyId;
    }

    /**
     * @param int $contactOrCompanyId
     */
    public function setContactOrCompanyId(?int $contactOrCompanyId)
    {
        $this->contactOrCompanyId = $contactOrCompanyId;
    }

    /**
     * @return Client
     */
    public function getClient(): ?Client
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
}
