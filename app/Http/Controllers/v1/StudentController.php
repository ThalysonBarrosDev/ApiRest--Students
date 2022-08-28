<?php

namespace App\Http\Controllers\v1;

use Exception;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller {

    public function create(Request $request) {

        $rules = [
            'registration' => 'required|min:6',
            'name' => 'required|min:3',
            'course' => 'required|min:5'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) { 

            return response()->json(['error' => true, 'message' => $validator->messages()], 500); 

        }

        $registration = $request->input('registration');
        $name = $request->input('name');
        $course = $request->input('course');

        $student = new Student();
        $student->registration = $registration;
        $student->name = $name;
        $student->course = $course;
        $student->save();

        return response()->json(['success' => true, 'message' => 'Aluno(a) cadastrado(a) com sucesso.'], 200); 

    }

    public function readAll() {

        try {

            $students = Student::all();

            return response()->json(['success' => true, 'data' => $students], 200);

        } catch (Exception $e) {

            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());

        }

    }

    public function read($id) {

        try {

            $student = Student::find($id);

            if ($student) {

                return response()->json(['success' => true, 'data' => $student], 200);

            } else {

                return response()->json(['error' => true, 'message' => 'Aluno(a) '.$id.' não encontrado(a), verifique.'], 500); 

            }

        } catch (Exception $e) {

            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());

        }

    }

    public function update(Request $request, $id) {

        $rules = [
            'registration' => 'min:6',
            'name' => 'min:3',
            'course' => 'min:5'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) { 

            return response()->json(['error' => true, 'message' => $validator->messages()], 500); 

        }

        $registration = $request->input('registration');
        $name = $request->input('name');
        $course = $request->input('course');

        $student = Student::find($id);

        if ($student) {

            $registration = isset($registration) ? $student->registration = $registration : NULL;
            $name = isset($name) ? $student->name = $name : NULL;
            $course = isset($course) ? $student->course = $course : NULL;

            $student->save();

            return response()->json(['success' => true, 'data' => $student], 200);

        } else {

            return response()->json(['error' => true, 'message' => 'Aluno(a) '.$id.' não encontrado(a), verifique.'], 500); 

        }

    }

    public function delete($id) {

        try {

            $student = Student::find($id);

            if ($student) {

                $student->delete();

                return response()->json(['success' => true, 'message' => 'Aluno(a) '.$id.' deletado(a) com sucesso.'], 200); 

            } else {

                return response()->json(['error' => true, 'message' => 'Aluno(a) '.$id.' não encontrado(a), verifique.'], 500); 

            }


        } catch (Exception $e) {

            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());

        }

    }
   
}