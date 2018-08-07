<?php

namespace App\Repository;

use GuzzleHttp\Client;

class TogglRepository
{
    const TOGGL_API_URL = 'https://www.toggl.com/api/v8/';

    private $togglClient;

    /**
     * Teamleader constructor.
     */
    public function __construct()
    {
        $this->togglClient = new Client([
            'base_uri' => self::TOGGL_API_URL,
            'timeout' => 7.0
        ]);
    }

    public function createClient(array $client)
    {
        $response = $this->post('clients', ['client' => $client]);
        return json_decode($response->getBody())->data;
    }

    public function updateClient($id, array $client)
    {
        $response = $this->put('clients/' . $id, ['client' => $client]);
        return json_decode($response->getBody());
    }

    public function createProject($project)
    {
        $response = $this->post('projects', ['project' => $project]);
        return json_decode($response->getBody())->data;
    }

    public function updateProject($id, array $project)
    {
        $response = $this->put('projects/' . $id, ['project' => $project]);
        return json_decode($response->getBody());
    }

    /**
     * @param $projectId
     * @return array
     */
    public function getProject($projectId) : array
    {
        $request = $this->request('projects/' . $projectId);
        return json_decode($request->getBody());
    }

    /**
     * @param $startDate
    ISO8601
     * @param int $endDate
    ISO8601
     * @return array
     */
    public function getTimeEntries($startDate, $endDate = 0) : array
    {
        $request = $this->get('time_entries', [
            'start_date' => $startDate,
            'end_date' => $endDate ? $endDate : date('c', time())
        ]);

        return json_decode($request->getBody());
    }

    private function post($path, $data = [])
    {
        return $this->request(
            $path,
            ['body' => json_encode($data)],
            'POST'
        );
    }

    private function put($path, $data = [])
    {
        return $this->request(
            $path,
            ['body' => json_encode($data)],
            'PUT'
        );
    }

    private function get($path, $query = [])
    {
        return $this->request(
            $path,
            ['query' => json_encode($query)],
            'PUT'
        );
    }

    private function request($path, $variables = [], $method = 'GET')
    {
        // Toogle has a request per second limit.
        sleep(1);

        $variables['auth'] = [
            getenv('TOGGL_API_TOKEN'),
            'api_token',
            'connect_timeout' => 5
        ];

        return $this->togglClient->request($method, $path, $variables);
    }
}