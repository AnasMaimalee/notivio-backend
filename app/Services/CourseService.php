<?php

namespace App\Services;

use App\Repositories\CourseRepository;

class CourseService
{
    protected $repo;

    public function __construct(CourseRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllCourses($userId)
    {
        return $this->repo->allByUser($userId);
    }

    public function getCourse($id)
    {
        return $this->repo->find($id);
    }

    public function createCourse($data)
    {
        return $this->repo->create($data);
    }

    public function updateCourse($id, $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deleteCourse($id)
    {
        return $this->repo->delete($id);
    }
    public function listCourses($user)
    {
        if ($user->role === 'superadmin') {
            return $this->repo->getAll();
        }

        return $this->repo->getByUser($user->id);
    }

}
