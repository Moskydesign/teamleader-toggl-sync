<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MilestoneRepository")
 */
class Milestone
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $milestoneId;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="milestones")
     * @ORM\JoinColumn(nullable=true)
     */
    private $project;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $remoteId;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $closed;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getMilestoneId(): int
    {
        return $this->milestoneId;
    }

    /**
     * @param int $milestoneId
     */
    public function setMilestoneId(int $milestoneId): void
    {
        $this->milestoneId = $milestoneId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject(Project $project): void
    {
        $this->project = $project;
    }

    /**
     * @return int
     */
    public function getRemoteId(): ?int
    {
        return $this->remoteId;
    }

    /**
     * @param int $remoteId
     */
    public function setRemoteId(int $remoteId): void
    {
        $this->remoteId = $remoteId;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->closed;
    }

    /**
     * @param bool $closed
     */
    public function setClosed(bool $closed): void
    {
        $this->closed = $closed;
    }
}
