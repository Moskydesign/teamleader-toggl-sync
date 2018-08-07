<?php

namespace App\Commands;

use App\Reporting\ReportingService;
use App\Service\ExportToTeamleaderService;
use App\Service\ExportToTogglService;
use App\Service\ImportFromTeamleaderService;
use App\Service\ImportFromTogglService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncCommand extends Command
{
    private $importFromTeamleaderService;
    private $exportToTogglService;
    private $exportToTeamleaderService;
    private $importFromTogglService;
    private $reportingService;

    public function __construct(
        ImportFromTeamleaderService $importFromTeamleaderService,
        ExportToTogglService $exportToTogglService,
        ImportFromTogglService $importFromTogglService,
        ExportToTeamleaderService $exportToTeamleaderService,
        ReportingService $reportingService
    ) {
        $this->importFromTeamleaderService = $importFromTeamleaderService;
        $this->exportToTogglService = $exportToTogglService;
        $this->exportToTeamleaderService = $exportToTeamleaderService;
        $this->importFromTogglService = $importFromTogglService;
        $this->reportingService = $reportingService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:sync')

            // the short description shown while running "php bin/console list"
            ->setDescription('Syncs projects, milestones and time entries between Toggl and teamleader.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Import Projects
        $report = $this->importFromTeamleaderService->projects();

        $output->writeln(
            $this->reportingService->printReportCli($report)
        );

        // Import Clients
        $report = $this->importFromTeamleaderService->clients();

        $output->writeln(
            $this->reportingService->printReportCli($report)
        );

        // Export Clients
        $report = $this->exportToTogglService->clients();

        $output->writeln(
            $this->reportingService->printReportCli($report)
        );

        // Import Milestones
        $report = $this->importFromTeamleaderService->milestones();

        $output->writeln(
            $this->reportingService->printReportCli($report)
        );

        // Export Milestones
        $report = $this->exportToTogglService->milestones();

        $output->writeln(
            $this->reportingService->printReportCli($report)
        );

        // Import TimeEntries
        $report = $this->importFromTogglService->timeEntries();

        $output->writeln(
            $this->reportingService->printReportCli($report)
        );

        // Export TimeEntries
        $report = $this->exportToTeamleaderService->timeEntries();

        $output->writeln(
            $this->reportingService->printReportCli($report)
        );
    }

}
