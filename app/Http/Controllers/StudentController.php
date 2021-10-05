<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentRequest;

class StudentController extends Controller {
    public function index() {
        return view('student');
    }

    public function getAllStudent() {
        return response()->json(Student::latest()->get());
    }

    public function store(StoreStudentRequest $request) {

        $request->validated();

        Student::create($request->all());
        return 1;
    }

    public function edit($id) {
        return Student::find($id);
    }

    public function update(StoreStudentRequest $request, $id) {
        $request->validated();

        $student = Student::find($id);
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->father_name = $request->father_name;
        $student->mother_name = $request->mother_name;
        $student->email = $request->email;
        $student->save();
        return 'ok';
    }

    public function destroy($id) {
        Student::find($id)->delete();
        return 'ok';
    }
}
