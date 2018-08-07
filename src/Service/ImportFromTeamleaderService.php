<?php

namespace App\Service;

use App\Entity\Project;
use App\Reporting\ReportingService;
use App\Repository\ClientRepository;
use App\Repository\ProjectRepository;

class ImportFromTeamleaderService
{

    private $togglService;
    private $projectService;
    private $projectRepository;
    private $clientRepository;
    private $clientService;
    private $reportingService;
    private $milestoneService;
    private $teamleaderService;
    private $errorService;

    public function __construct(
        ProjectService $projectService,
        TogglService $togglService,
        ProjectRepository $projectRepository,
        ClientService $clientService,
        ClientRepository $clientRepository,
        ReportingService $reportingService,
        MilestoneService $milestoneService,
        TeamleaderService $teamleaderService,
        ErrorService $errorService
    ) {
        $this->projectService = $projectService;
        $this->togglService = $togglService;
        $this->projectRepository = $projectRepository;
        $this->clientService = $clientService;
        $this->clientRepository = $clientRepository;
        $this->reportingService = $reportingService;
        $this->milestoneService = $milestoneService;
        $this->teamleaderService = $teamleaderService;
        $this->errorService = $errorService;
    }

    public function clients()
    {
        try {
            $error = false;
            $report = $this->reportingService->createReport('client_import', 'Client Import');

            $projects = $this->projectRepository->findAll();

            /** @var Project $project */
            foreach ($projects as $project) {
                try {
                    $this->projectService->setProject($project);
                    $company = $this->projectService->getCompany();
                    if ($company) {
                        $client = $this->clientService->fromTeamleader($company);
                        $this->clientService->save();
                        $project->setClient($client);
                        $this->projectService->save();

                        $report->addLine($client->getName() . ' - ' . $client->getClientId(), 'success');
                    }
                } catch (\Exception $e) {
                    $report->addLine($e->getMessage(), 'error');
                    $error = true;
                }
            }

            if ($error) {
                $this->errorService->mail($this->reportingService->printReport($report));
            }

            return $report;

        } catch (\Exception $e) {
            $this->errorService->mail($e->getMessage());
        }

        return false;
    }

    public function milestones()
    {
        try {
            $error = false;
            $report = $this->reportingService->createReport('milestone_import', 'Milestone Import');

            $projects = $this->projectRepository->findAll();

            /** @var Project $project */
            foreach ($projects as $project) {
                $this->projectService->setProject($project);
                $milestones = $this->projectService->getMilestones();
                foreach ($milestones as $milestone) {
                    try {
                        $milestone = $this->milestoneService->fromTeamleader($milestone);
                        $milestone->setProject($project);
                        $this->milestoneService->save();

                        $report->addLine($milestone->getTitle() . ' - ' . $milestone->getMilestoneId(), 'success');
                    } catch (\Exception $e) {
                        $report->addLine($e->getMessage(), 'error');
                        $error = true;
                    }
                }
            }

            if ($error) {
                $this->errorService->mail($this->reportingService->printReport($report));
            }

            return $report;

        } catch (\Exception $e) {
            $this->errorService->mail($e->getMessage());
        }

        return false;
    }

    public function projects()
    {
        try {
            $error = false;
            $report = $this->reportingService->createReport('project_import', 'Project Import');

            $teamleaderProjects = $this->teamleaderService->getProjects(true);

            foreach ($teamleaderProjects as $teamleaderProject) {
                try {
                    $project = $this->projectService->fromTeamleader($teamleaderProject);
                    $this->projectService->save();

                    $report->addLine($project->getTitle() . ' - ' . $project->getProjectId(), 'success');
                } catch (\Exception $e) {
                    $report->addLine($e->getMessage(), 'error');
                    $error = true;
                }
            }

            if ($error) {
                $this->errorService->mail($this->reportingService->printReport($report));
            }

            return $report;

        } catch (\Exception $e) {
            $this->errorService->mail($e->getMessage());
        }

        return false;
    }
}
