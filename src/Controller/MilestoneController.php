<?php

namespace App\Controller;

use App\Reporting\ReportingService;
use App\Service\ExportToTogglService;
use App\Service\ImportFromTeamleaderService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MilestoneController
{
    private $reportingService;
    private $importFromTeamleaderService;
    private $exportToTogglService;

    public function __construct(
        ReportingService $reportingService,
        ImportFromTeamleaderService $importFromTeamleaderService,
        ExportToTogglService $exportToTogglService
    ) {
        $this->reportingService = $reportingService;
        $this->importFromTeamleaderService = $importFromTeamleaderService;
        $this->exportToTogglService = $exportToTogglService;
    }


    /**
     * @Route("/milestone/import")
     */
    public function milestoneImportAction()
    {
        $report = $this->importFromTeamleaderService->milestones();

        return new Response(
            $this->reportingService->printReport($report)
        );
    }

    /**
     * @Route("/milestone/export")
     */
    public function milestoneExportAction()
    {
        $report = $this->exportToTogglService->milestones();

        return new Response(
            $this->reportingService->printReport($report)
        );
    }
}
