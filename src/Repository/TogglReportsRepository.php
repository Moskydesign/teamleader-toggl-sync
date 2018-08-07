<?php

namespace App\Repository;

use GuzzleHttp\Client;

class TogglReportsRepository
{
    const TOGGL_REPORTS_API_URL='https://www.toggl.com/reports/api/v2/';

    private $togglClient;

    /**
     * Teamleader constructor.
     */
    public function __construct()
    {
        $this->togglClient = new Client([
            'base_uri' => self::TOGGL_REPORTS_API_URL,
            'timeout' => 2.0,
        ]);
    }

    /**
     * Fetch all toggl items (of last x days) for a specific project id.
     * @param string $since
     * @return mixed
     */
    public function getTimeEntries(string $since)
    {
        $page = 1;
        $data = [];

        $response = $this->getTimeEntriesPage($since, $page);
        $data = array_merge($data, $response->data);
        $totalCount = $response->total_count;
        while ($totalCount > count($data) + 1) {
            $page++;
            $response = $this->getTimeEntriesPage($since, $page);
            $data = array_merge($data, $response->data);
        }

        return $data;
    }

    public function getTimeEntriesPage($since, $page = 1)
    {
        $query = [];
        $query['user_agent'] = getenv('TOGGL_API_USER_AGENT');
        $query['workspace_id'] = getenv('TOGGL_API_WORKSPACE_ID');
        $query['since'] = $since;
        $query['page'] = $page;

        $response = $this->request('details', $query);

        $response = json_decode($response->getBody());

        return $response;
    }


    private function request($path, $query = [])
    {
        return $this->togglClient->request('GET', $path, [
            'query' => $query,
            'auth' => [
                getenv('TOGGL_API_TOKEN'),
                'api_token'
            ]
        ]);
    }
}
