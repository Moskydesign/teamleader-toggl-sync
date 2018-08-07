<?php

namespace App\Controller;

use App\Reporting\ReportingService;
use App\Service\ImportFromTeamleaderService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController
{
    private $importFromTeamleaderService;
    private $reportingService;

    public function __construct(
        ImportFromTeamleaderService $importFromTeamleaderService,
        ReportingService $reportingService
    ) {
        $this->importFromTeamleaderService = $importFromTeamleaderService;
        $this->reportingService = $reportingService;
    }

    /**
     * @Route("/project/import")
     */
    public function projectImportAction()
    {
        $report = $this->importFromTeamleaderService->projects();

        return new Response(
            $this->reportingService->printReport($report)
        );
    }
}
