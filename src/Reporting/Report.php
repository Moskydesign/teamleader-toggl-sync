<?php

namespace App\Reporting;

class Report
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var array
     */
    private $lines = array();

    /**
     * Report constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function addLine(string $message, string $type = '')
    {
        $this->lines[] = [
            'message' => $message,
            'type' => $type
        ];
    }

    public function getLinesOfType($type) : array
    {
        $lines = array_filter($this->lines, function ($line) use ($type) {
            return $line['type'] == $type ? true : false;
        });

        return $lines;
    }

    /**
     * @return array
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    public function getLinesPerType(): array
    {
        $lines = [];
        foreach ($this->lines as $line) {
            $lines[$line['type']][] = $line['message'];
        }

        return $lines;
    }
}
