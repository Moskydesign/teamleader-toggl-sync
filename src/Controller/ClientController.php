<?php

namespace App\Controller;

use App\Reporting\ReportingService;
use App\Service\ExportToTogglService;
use App\Service\ImportFromTeamleaderService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController
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
     * @Route("/client/import")
     */
    public function clientImportAction()
    {
        $report = $this->importFromTeamleaderService->clients();

        return new Response(
            $this->reportingService->printReport($report)
        );
    }

    /**
     * @Route("/client/export")
     */
    public function clientExportAction()
    {
        $report = $this->exportToTogglService->clients();

        return new Response(
            $this->reportingService->printReport($report)
        );
    }

}