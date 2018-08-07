<?php

namespace App\Service;

use App\Entity\Milestone;
use App\Repository\MilestoneRepository;
use Doctrine\ORM\EntityManagerInterface;

class MilestoneService
{
    /** @var Milestone */
    private $milestone;
    private $entityManager;
    private $milestoneRepository;

    /**
     * milestone constructor.
     * @param EntityManagerInterface $entityManager
     * @param MilestoneRepository $milestoneRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        MilestoneRepository $milestoneRepository
    ) {
        $this->entityManager = $entityManager;
        $this->milestoneRepository = $milestoneRepository;
    }

    public function fromTeamleader($milestone)
    {
        $this->hydrate($milestone);
        return $this->milestone;
    }

    /**
     * @return Milestone
     */
    public function getMilestone(): Milestone
    {
        return $this->milestone;
    }

    /**
     * @param Milestone $milestone
     */
    public function setMilestone(Milestone $milestone): void
    {
        $this->milestone = $milestone;
    }

    public function save()
    {
        $this->entityManager->persist($this->milestone);
        $this->entityManager->flush();
    }

    private function hydrate($milestone)
    {
        $this->milestone = $this->milestoneRepository->findOneBy(['milestoneId' => $milestone->id]);
        if (!$this->milestone) {
            $this->milestone = new Milestone();
        }

        $this->milestone->setmilestoneId($milestone->id);
        $this->milestone->setTitle($milestone->title);
        $this->milestone->setClosed($milestone->closed);
    }
}