<?php

namespace App\Reporting;

define('REPORT_MSG_TYPE_SUCCESS', 'success');
define('REPORT_MSG_TYPE_NOTIFICATION', 'notification');
define('REPORT_MSG_TYPE_ERROR', 'error');

class ReportingService
{
    private $reports = [];

    public function addNotification($message)
    {
        $this->report[] = [
            'message' => $message,
            'type' => REPORT_MSG_TYPE_NOTIFICATION
        ];
    }

    public function addError($message)
    {
        $this->report[] = [
            'message' => $message,
            'type' => REPORT_MSG_TYPE_ERROR
        ];
    }

    /**
     * Create a report.
     *
     * @param $name
     * @param string $title
     * @return Report
     */
    public function createReport($name, $title = '')
    {
        $report = new Report($name);
        $report->setTitle($title);

        $this->reports[$name] = $report;

        return $report;
    }

    public function getReport($name) : ?Report
    {
        return $this->reports[$name] ?? null;
    }

    public function printReport(Report $report)
    {
        $output = '';

        if ($report->getTitle()) {
            $output .= '<h1>' . $report->getTitle() . '</h1>';
        }

        foreach ($report->getLines() as $line) {
            $output .= '<div class="type-' . $line['type'] . '">' . $line['message'] . ' [' . $line['type'] . ']</div>';
        }

        $output .= '<hr>';

        foreach ($report->getLinesPerType() as $type => $lines) {
            $output .= $type . ': ' . count($lines);
        }

        return $output;
    }

    public function printReportCli(Report $report)
    {
        $output = [];

        if ($report->getTitle()) {
            $output[] = $report->getTitle();
            $output[] = '====================';
        }

        foreach ($report->getLines() as $line) {
            $output[] = $line['message'] . ' [' . $line['type'] . ']';
        }

        $output[] = '--------------------';

        foreach ($report->getLinesPerType() as $type => $lines) {
            $output[] = $type . ': ' . count($lines);
        }

        return $output;
    }
}
