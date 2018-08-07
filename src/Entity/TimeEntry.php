<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimeEntryRepository")
 */
class TimeEntry
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $entryId;

    /**
     * @var Milestone
     * @ORM\ManyToOne(targetEntity="App\Entity\Milestone")
     * @ORM\JoinColumn(nullable=true)
     */
    private $milestone;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $uid;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private $tags;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $exported = 0;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

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
    public function getEntryId(): int
    {
        return $this->entryId;
    }

    /**
     * @param int $entryId
     */
    public function setEntryId(int $entryId)
    {
        $this->entryId = $entryId;
    }

    /**
     * @return Milestone
     */
    public function getMilestone(): ?Milestone
    {
        return $this->milestone;
    }

    /**
     * @param Milestone $milestone
     */
    public function setMilestone(Milestone $milestone)
    {
        $this->milestone = $milestone;
    }

    /**
     * @return int
     */
    public function getUid(): int
    {
        return $this->uid;
    }

    /**
     * @param int $uid
     */
    public function setUid(int $uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return \DateTime
     */
    public function getStart(): \DateTime
    {
        return $this->start;
    }

    /**
     * @param \DateTime $start
     */
    public function setStart(\DateTime $start)
    {
        $this->start = $start;
    }

    /**
     * @return \DateTime
     */
    public function getEnd(): \DateTime
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     */
    public function setEnd(\DateTime $end)
    {
        $this->end = $end;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return bool
     */
    public function isExported(): bool
    {
        return $this->exported;
    }

    /**
     * @param bool $exported
     */
    public function setExported(bool $exported)
    {
        $this->exported = $exported;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
