<?php

namespace App\Service;

use App\Entity\Milestone;
use App\Entity\TimeEntry;
use App\Repository\TeamleaderRepository;

define('DEFAULT_TASK_TYPE_ID', 6605);

class TeamleaderService
{
    private $teamleaderRepository;

    /**
     * TogglService constructor.
     * @param $teamleaderRepository
     */
    public function __construct(TeamleaderRepository $teamleaderRepository)
    {
        $this->teamleaderRepository = $teamleaderRepository;
    }

    public function getProjects($details = false)
    {
        $projects = $this->teamleaderRepository->getProjects();

        if ($details) {
            foreach ($projects as &$project) {
                $project =  $this->teamleaderRepository->getProject($project->id);
            }
        }

        return $projects;
    }

    /**
     * @param TimeEntry $timeEntry
     * @throws \Exception
     */
    public function createTimeEntry(TimeEntry $timeEntry)
    {
        try {
            $created = $this->teamleaderRepository->addTimeTracking(
                $timeEntry->getStart()->getTimestamp(),
                $timeEntry->getEnd()->getTimestamp(),
                $timeEntry->getDescription(),
                $this->getMilestoneId($timeEntry),
                $this->getTaskTypeId($timeEntry),
                $timeEntry->getUser()->getTeamleaderWorkerId()
            );

            if (!$created) {
                throw new \Exception('Could not add time entry in teamleader');
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function getMilestoneId(TimeEntry $timeEntry)
    {
        if ($timeEntry->getMilestone() instanceof Milestone) {
            return $timeEntry->getMilestone()->getMilestoneId();
        }

        throw new \Exception('Milestone not set');
    }

    private function getTaskTypeId(TimeEntry $timeEntry)
    {
        $tags = $timeEntry->getTags();
        if (!empty($tags)) {
            $taskTypeId = $this->getStringBetween(reset($tags), '[', ']');
            if ($taskTypeId) {
                return $taskTypeId;
            }
        }

        return DEFAULT_TASK_TYPE_ID;
    }

    private function getStringBetween($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return '';
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
