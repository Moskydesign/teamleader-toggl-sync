<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\Milestone;
use App\Entity\Project;
use App\Repository\TogglReportsRepository;
use App\Repository\TogglRepository;

class TogglService
{
    private $togglRepository;
    private $togglReportsRepository;

    /**
     * TogglService constructor.
     * @param TogglRepository $togglRepository
     * @param TogglReportsRepository $togglReportsRepository
     */
    public function __construct(
        TogglRepository $togglRepository,
        TogglReportsRepository $togglReportsRepository
    ) {
        $this->togglRepository = $togglRepository;
        $this->togglReportsRepository = $togglReportsRepository;
    }

    /**
     * @param $userAgent
     * @param int $days
     * @return array
     */
    public function getTimeEntriesByDays(int $days = 6)
    {
        return $this->togglReportsRepository->getTimeEntries(
            date("Y-m-d", time() - (86400 * $days))
        );
    }

    /**
     * @param Client $client
     */
    public function createOrUpdateClient(Client $client)
    {
        if (!$client->getRemoteId()) {
            $this->createClient($client);
        } else {
            $this->updateClient($client);
        }
    }

    /**
     * @param Client $client
     */
    public function createClient(Client $client)
    {
        $togglClient = $this->togglRepository->createClient([
            'name' => $this->clientName($client),
            'wid' => getenv('TOGGL_API_WORKSPACE_ID'),
        ]);

        if ($togglClient) {
            $client->setRemoteId($togglClient->id);
        }
    }

    /**
     * @param Client $client
     */
    public function updateClient(Client $client)
    {
        $this->togglRepository->updateClient($client->getRemoteId(), [
            'name' => $this->clientName($client),
        ]);
    }

    /**
     * @param Milestone $milestone
     * @param Project $project
     * @param Client $client
     */
    public function createOrUpdateProject(Milestone $milestone, Project $project, Client $client = null)
    {
        if (!$milestone->getRemoteId()) {
            $this->createProject($milestone, $project, $client);
        } else {
            $this->updateProject($milestone, $project, $client);
        }
    }

    /**
     * @param Milestone $milestone
     * @param Project $project
     * @param Client $client
     */
    public function createProject(Milestone $milestone, Project $project, Client $client = null)
    {
        $clientId = null;
        if ($client) {
            $clientId = $client->getRemoteId();
        }

        $togglProject = $this->togglRepository->createProject([
            'name' => $this->projectName($milestone, $project),
            'cid' => $clientId,
            'wid' => getenv('TOGGL_API_WORKSPACE_ID'),
            'active' => !$milestone->isClosed(),
            'is_private' => false
        ]);

        if ($togglProject) {
            $milestone->setRemoteId($togglProject->id);
        }
    }

    /**
     * @param Milestone $milestone
     * @param Project $project
     * @param Client $client
     */
    public function updateProject(Milestone $milestone, Project $project, Client $client = null)
    {
        $clientId = null;
        if ($client) {
            $clientId = $client->getRemoteId();
        }

        $this->togglRepository->updateProject($milestone->getRemoteId(), [
            'name' => $this->projectName($milestone, $project),
            'cid' => $clientId,
            'active' => !$milestone->isClosed(),
            'is_private' => false
        ]);
    }

    /**
     * @param Milestone $milestone
     * @param Project $project
     * @return string
     */
    private function projectName(Milestone $milestone, Project $project)
    {
        return $milestone->getTitle() . ' - ' . $project->getTitle() . ' [' . $milestone->getMilestoneId() . ']';
    }

    /**
     * @param Client $client
     * @return string
     */
    private function clientName(Client $client)
    {
        return $client->getName() . ' [' . $client->getClientId() . ']';
    }
}
