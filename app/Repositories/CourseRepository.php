<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository
{
    public function getAll()
    {
        return Course::latest()->get();
    }

    public function getByUser(string $userId)
    {
        return Course::where('user_id', $userId)->latest()->get();
    }

    public function find(string $id): Course
    {
        return Course::findOrFail($id);
    }

    public function create(array $data): Course
    {
        return Course::create($data);
    }

    public function update(string $id, array $data): Course
    {
        $course = $this->find($id);
        $course->update($data);
        return $course;
    }

    public function delete(string $id): bool
    {
        return $this->find($id)->delete();
    }
}
