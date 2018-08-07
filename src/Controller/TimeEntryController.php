<?php

namespace App\Controller;

use App\Entity\TimeEntry;
use App\Entity\User;
use App\Reporting\ReportingService;
use App\Repository\TimeEntryRepository;
use App\Repository\UserRepository;
use App\Service\ExportToTeamleaderService;
use App\Service\ImportFromTogglService;
use App\Service\TeamleaderService;
use App\Service\TimeEntryService;
use App\Service\TogglService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TimeEntryController
{
    private $togglService;
    private $teamleaderService;
    private $timeEntryService;
    private $timeEntryRepository;
    private $reportingService;
    private $userRepository;
    private $importFromToggleService;
    private $exportToTeamleaderService;

    public function __construct(
        TogglService $togglService,
        TeamleaderService $teamleaderService,
        TimeEntryService $timeEntryService,
        TimeEntryRepository $timeEntryRepository,
        ReportingService $reportingService,
        UserRepository $userRepository,
        ImportFromTogglService $importFromToggleService,
        ExportToTeamleaderService $exportToTeamleaderService
    ) {
        $this->togglService = $togglService;
        $this->teamleaderService = $teamleaderService;
        $this->timeEntryService = $timeEntryService;
        $this->timeEntryRepository = $timeEntryRepository;
        $this->reportingService = $reportingService;
        $this->userRepository = $userRepository;
        $this->importFromToggleService = $importFromToggleService;
        $this->exportToTeamleaderService = $exportToTeamleaderService;
    }

    /**
     * @Route("/time-entries/import")
     */
    public function timeEntriesImportAction()
    {
        $report = $this->importFromToggleService->timeEntries();

        return new Response(
            $this->reportingService->printReport($report)
        );
    }

    /**
     * @Route("/time-entries/export")
     */
    public function timeEntriesExportAction()
    {
        $report = $this->exportToTeamleaderService->timeEntries();

        return new Response(
            $this->reportingService->printReport($report)
        );
    }
}
