<?php

namespace App\Service;

use App\Entity\Milestone;
use App\Entity\TimeEntry;
use App\Repository\MilestoneRepository;
use App\Repository\TimeEntryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Time;

class TimeEntryService
{
    private $timeEntry;
    private $timeEntryRepository;
    private $entityManager;
    private $milestoneRepository;
    private $userRepository;

    /**
     * TimeEntryService constructor.
     * @param TimeEntryRepository $timeEntryRepository
     * @param EntityManagerInterface $entityManager
     * @param MilestoneRepository $milestoneRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        TimeEntryRepository $timeEntryRepository,
        EntityManagerInterface $entityManager,
        MilestoneRepository $milestoneRepository,
        UserRepository $userRepository
    ) {
        $this->timeEntryRepository = $timeEntryRepository;
        $this->entityManager = $entityManager;
        $this->milestoneRepository = $milestoneRepository;
        $this->userRepository = $userRepository;
    }

    public function fromToggl($entry) : TimeEntry
    {
        $this->hydrate($entry);
        return $this->timeEntry;
    }

    /**
     * @return TimeEntry
     */
    public function getTimeEntry(): TimeEntry
    {
        return $this->timeEntry;
    }

    /**
     * @param TimeEntry $timeEntry
     */
    public function setTimeEntry(TimeEntry $timeEntry): void
    {
        $this->timeEntry = $timeEntry;
    }

    public function save(TimeEntry $timeEntry = null)
    {
        $entryToSave = $this->timeEntry;
        if ($timeEntry) {
            $entryToSave = $timeEntry;
        }

        $this->entityManager->persist($entryToSave);
        $this->entityManager->flush();
    }

    private function hydrate($entry)
    {
        try {
            $this->timeEntry = $this->timeEntryRepository->findOneBy(['entryId' => $entry->id]);
            if (!$this->timeEntry) {
                $this->timeEntry = new TimeEntry();
            }

            $this->timeEntry->setEntryId($entry->id);
            $this->timeEntry->setDescription($entry->description);

            // Convert dates to UTC because the database doesn't store the timezone.
            $startDate = new \DateTime($entry->start);
            $startDate->setTimeZone(new \DateTimeZone('UTC'));
            $this->timeEntry->setStart($startDate);

            $endDate = new \DateTime($entry->end);
            $endDate->setTimeZone(new \DateTimeZone('UTC'));
            $this->timeEntry->setEnd($endDate);

            $this->timeEntry->setUpdated(new \DateTime($entry->updated));
            $this->timeEntry->setDuration($entry->dur);
            $this->timeEntry->setUid($entry->uid);
            $this->timeEntry->setTags($entry->tags);
            $user = $this->userRepository->findOneBy(['togglUid' => $entry->uid]);
            if (!$user) {
                throw new \Exception('Cannot find user with toggl Uid ' . $entry->uid);
            }
            $this->timeEntry->setUser($user);
            /** @var Milestone $milestone */
            $milestone = $this->milestoneRepository->findOneBy(['remoteId' => $entry->pid]);
            $milestone ? $this->timeEntry->setMilestone($milestone) : null;
        } catch (\Exception $e) {
            print_r($e->getMessage() . '<br>');
        }
    }
}