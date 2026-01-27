<?php

namespace App\Http\Controllers\API\Course;

use App\Http\Controllers\Controller;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $service;

    public function __construct(CourseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $user = auth('api')->user();
        $courses = $this->service->listCourses($user);

        return response()->json([
            'message' => 'Courses Retrieved Successfully',
            'data' => $courses
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['title', 'description']);
        $data['user_id'] = auth('api')->id();

        $course = $this->service->createCourse($data);

        return response()->json([
            'message' => 'Course Created Successfully',
            'data' => $course
        ]);
    }

    public function show($id)
    {
        $course = $this->service->getCourse($id);
        return response()->json([
            'message' => 'Course Retrieved Successfully',
            'data' => $course
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course = $this->service->updateCourse($id, $request->only(['title', 'description']));

        return response()->json([
            'message' => "Course Updated Successfully",
            'data' => $course
        ]);
    }

    public function destroy($id)
    {
        $this->service->deleteCourse($id);
        return response()->json(['message' => 'Course deleted successfully']);
    }
}
