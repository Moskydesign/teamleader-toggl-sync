<?php

namespace App\Service;

use App\Entity\TimeEntry;
use App\Reporting\ReportingService;
use App\Repository\TimeEntryRepository;

class ExportToTeamleaderService
{
    private $togglService;
    private $reportingService;
    private $timeEntryService;
    private $timeEntryRepository;
    private $teamleaderService;
    private $errorService;

    public function __construct(
        TogglService $togglService,
        ReportingService $reportingService,
        TimeEntryService $timeEntryService,
        TimeEntryRepository $timeEntryRepository,
        TeamleaderService $teamleaderService,
        ErrorService $errorService
    ) {
        $this->togglService = $togglService;
        $this->reportingService = $reportingService;
        $this->timeEntryService = $timeEntryService;
        $this->timeEntryRepository = $timeEntryRepository;
        $this->teamleaderService = $teamleaderService;
        $this->errorService = $errorService;
    }

    public function timeEntries()
    {
        $error = false;
        $report = $this->reportingService->createReport('time_entries_export', 'Time Entries Export');

        $exportEntries = $this->timeEntryRepository->findAllExportEntries();

        /** @var TimeEntry $entry */
        foreach ($exportEntries as $entry) {
            try {
                $this->teamleaderService->createTimeEntry($entry);
                $entry->setExported(true);
                $this->timeEntryService->save($entry);

                $report->addLine($entry->getDescription() . ' (' . $entry->getEntryId() . ')', 'success');
            } catch (\Exception $e) {
                $report->addLine(
                    'Entry ' . $entry->getDescription() .
                    ' (' . $entry->getEntryId() . ') ' . ' - ' .
                    $e->getMessage(),
                    'error'
                );
                $error = true;
            }
        }

        if ($error) {
            $this->errorService->mail($this->reportingService->printReport($report));
        }

        return $report;
    }

}
