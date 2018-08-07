<?php

namespace App\Repository;

use GuzzleHttp\Client;

class TeamleaderRepository
{
    const TEAMLEADER_API_URL='https://app.teamleader.eu/api/';

    private $teamleaderClient;
    private $requestCounter;

    /**
     * Teamleader constructor.
     */
    public function __construct()
    {
        $this->teamleaderClient = new Client([
            'base_uri' => self::TEAMLEADER_API_URL,
            'timeout' => 2.0,
        ]);
    }

    public function getContact($contactId)
    {
        $data['contact_id'] = $contactId;

        $request = $this->request('getContact.php', $data);
        return json_decode($request->getBody());
    }

    public function getCompany($companyId)
    {
        $data['company_id'] = $companyId;

        $request = $this->request('getCompany.php', $data);
        return json_decode($request->getBody());
    }

    public function getProjects()
    {
        $data['amount'] = 100;
        $data['pageno'] = 0;
        $data['show_active_only'] = 1;

        $request = $this->request('getProjects.php', $data);
        return json_decode($request->getBody());
    }

    public function getProject($projectId)
    {
        $data['project_id'] = $projectId;

        $request = $this->request('getProject.php', $data);
        return json_decode($request->getBody());
    }

    public function getMilestones($projectId)
    {
        $data['project_id'] = $projectId;

        $request = $this->request('getMilestonesByProject.php', $data);
        return json_decode($request->getBody());
    }

    /**
     * Create a timetracking entity in teamleader.
     * @param $startTime
     * @param $endTime
     * @param $description
     * @param $milestoneId
     * @param $taskTypeId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function addTimeTracking($startTime, $endTime, $description, $milestoneId, $taskTypeId, $workerId)
    {
        $data['worker_id'] = $workerId;
        $data['task_type_id'] = $taskTypeId;

        $data['description'] = $description;
        $data['start_date'] = $startTime;
        $data['end_date'] = $endTime;

        $data['invoiceable'] = 1;
        $data['for'] = 'project_milestone';
        $data['for_id'] = $milestoneId;

        $response = $this->request('addTimetracking.php', $data);
        return $response->getStatusCode() == 200 ? true : false;
    }


    private function request($path, $data = [])
    {
        $this->requestCounter++;

        // Teamleader only allow 25 request per 5 sec.
        if ($this->requestCounter >= 24) {
            sleep(5);
            $this->requestCounter = 0;
        }

        $data['api_group'] =  getenv('TEAMLEADER_API_GROUP');
        $data['api_secret'] = getenv('TEAMLEADER_API_SECRET');

        return $this->teamleaderClient->request('POST', $path, ['form_params' => $data]);
    }
}
