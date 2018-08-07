<?php

namespace App\Service;

use App\Reporting\ReportingService;

class ImportFromTogglService
{
    private $togglService;
    private $reportingService;
    private $timeEntryService;
    private $errorService;

    public function __construct(
        TogglService $togglService,
        ReportingService $reportingService,
        TimeEntryService $timeEntryService,
        ErrorService $errorService
    ) {
        $this->togglService = $togglService;
        $this->reportingService = $reportingService;
        $this->timeEntryService = $timeEntryService;
        $this->errorService = $errorService;
    }

    public function timeEntries()
    {
        $error = false;
        $report = $this->reportingService->createReport('time_entries_import', 'Time Entries Import');

        $entries = $this->togglService->getTimeEntriesByDays(
            getenv('TOGGL_TIME_ENTRIES_SINCE')
        );

        foreach ($entries as $entry) {
            try {
                $timeEntry = $this->timeEntryService->fromToggl($entry);
                $this->timeEntryService->save();

                $report->addLine($timeEntry->getDescription() . ' - ' . $timeEntry->getEntryId() . ' (' . $timeEntry->getUser()->getName() . ')', 'success');
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
