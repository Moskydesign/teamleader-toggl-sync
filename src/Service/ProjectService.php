<?php

namespace App\Service;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Repository\TeamleaderRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProjectService
{
    private $teamleaderRepository;
    /** @var Project */
    private $project;
    private $entityManager;
    private $projectRepository;


    /**
     * Project constructor.
     * @param TeamleaderRepository $teamleaderRepository
     * @param EntityManagerInterface $entityManager
     * @param ProjectRepository $projectRepository
     */
    public function __construct(
        TeamleaderRepository $teamleaderRepository,
        EntityManagerInterface $entityManager,
        ProjectRepository $projectRepository
    ) {
        $this->teamleaderRepository = $teamleaderRepository;
        $this->entityManager = $entityManager;
        $this->projectRepository = $projectRepository;
    }

    public function fromTeamleader($project)
    {
        $this->hydrate($project);
        return $this->project;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @param Project $project
     */
    public function setProject(Project $project): void
    {
        $this->project = $project;
    }

    public function getClient()
    {
        if ($this->project->getContactOrCompany() == 'contact') {
            return $this->teamleaderRepository->getContact($this->project->getContactOrCompanyId());
        } else {
            return $this->teamleaderRepository->getCompany($this->project->getContactOrCompanyId());
        }
    }

    public function getCompany()
    {
        if ($this->project->getContactOrCompany() == 'company') {
            return $this->teamleaderRepository->getCompany($this->project->getContactOrCompanyId());
        }

        return null;
    }

    public function getMilestones()
    {
        return $this->teamleaderRepository->getMilestones($this->project->getProjectId());
    }

    public function isNew() : bool
    {
        return $this->project->getId() ? true : false;
    }

    public function save()
    {
        $this->entityManager->persist($this->project);
        $this->entityManager->flush();
    }

    private function hydrate($project)
    {
        $this->project = $this->projectRepository->findOneBy(['projectNr' => $project->project_nr]);
        if (!$this->project) {
            $this->project = new Project();
        }

        $this->project->setProjectId($project->id);
        $this->project->setProjectNr($project->project_nr);
        $this->project->setTitle($project->title);
        $this->project->setContactOrCompany($project->contact_or_company);
        $this->project->setContactOrCompanyId($project->contact_or_company_id);
    }
}
