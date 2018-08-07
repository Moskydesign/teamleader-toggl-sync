<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\Milestone;
use App\Reporting\ReportingService;
use App\Repository\ClientRepository;
use App\Repository\MilestoneRepository;
use App\Repository\ProjectRepository;

class ExportToTogglService
{
    private $togglService;
    private $projectService;
    private $projectRepository;
    private $clientRepository;
    private $clientService;
    private $reportingService;
    private $milestoneService;
    private $milestoneRepository;
    private $errorService;

    public function __construct(
        ProjectService $projectService,
        TogglService $togglService,
        ProjectRepository $projectRepository,
        ClientService $clientService,
        ClientRepository $clientRepository,
        ReportingService $reportingService,
        MilestoneService $milestoneService,
        MilestoneRepository $milestoneRepository,
        ErrorService $errorService
    ) {
        $this->projectService = $projectService;
        $this->togglService = $togglService;
        $this->projectRepository = $projectRepository;
        $this->clientService = $clientService;
        $this->clientRepository = $clientRepository;
        $this->reportingService = $reportingService;
        $this->milestoneService = $milestoneService;
        $this->milestoneRepository = $milestoneRepository;
        $this->errorService = $errorService;
    }

    public function clients()
    {
        $error = false;
        $report = $this->reportingService->createReport('client_export', 'Client Export');

        $clients = $this->clientRepository->findAll();

        /** @var Client $client */
        foreach ($clients as $client) {
            try {
                // Create a client in Toggl for each client.
                $this->togglService->createOrUpdateClient($client);
                // Save client after export, Toggl Id en Wip are set.
                $this->clientService->setClient($client);
                $this->clientService->save();

                $report->addLine($client->getName() . ' - ' . $client->getClientId(), 'success');
            } catch (\Exception $e) {
                $report->addLine($e->getMessage(), 'error');
                $error = true;
            }
        }

        if ($error) {
            $this->errorService->mail($this->reportingService->printReport($report));
        }

        return $report;
    }

    public function milestones()
    {
        $error = false;
        $report = $this->reportingService->createReport('milestone_import', 'Milestone Export');

        $milestones = $this->milestoneRepository->findAll();

        /** @var Milestone $milestone */
        foreach ($milestones as $milestone) {
            try {
                $this->togglService->createOrUpdateProject(
                    $milestone,
                    $milestone->getProject(),
                    $milestone->getProject()->getClient()
                );
                // Save client after export, Toggl Id en Wip are set.
                $this->milestoneService->setMilestone($milestone);
                $this->milestoneService->save();

                $report->addLine($milestone->getTitle() . ' - ' . $milestone->getMilestoneId(), 'success');
            } catch (\Exception $e) {
                $report->addLine($e->getMessage(), 'error');
                $error = true;
            }
        }

        if ($error) {
            $this->errorService->mail($this->reportingService->printReport($report));
        }

        return $report;
    }
}
