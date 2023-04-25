<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $student = Student::all();
        if($student->count() > 0){
            $data = [
                'status' => 200,
                'student' => $student
            ];
            return response()->json($data ,200);
        }
        else{
            $data = [
                'status' => 404,
                'student' => 'No Record Found'
            ];
            return response()->json($data ,404);
        }

    }

    public function store(Request $request)
    {
        $validator = validator::make($request->all(),[
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422, //input error
                'errors' => $validator->messages()
            ],422);
        }else{
            
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if($student){
                return response()->json([
                    'status' => 200,
                    'message' => 'Student Added Created Successfully'
                ],200);
            }else{
                
                return response()->json([
                    'status' => 500,
                    'message' => 'Something went wrong'
                ],500);
            }
        }
    }

    public function show($id)
    {
        $student = Student::find($id);
        if($student){

            return response()->json([
                'status' => 200,
                'student' => $student
            ],200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "No such student found!"
            ],404);
        }
    }
    public function edit($id){
        $student = Student::find($id);
        if($student){

            return response()->json([
                'status' => 200,
                'student' => $student
            ],200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "No such student found!"
            ],404);
        }

    }

    public function update(REquest $request, int $id)
    {
        $validator = validator::make($request->all(),[
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        if($validator->fails()){

            return response()->json([
                'status' => 422, //input error
                'errors' => $validator->messages()
            ],422);
        }else{

            $student = Student::find($id);

            
            if($student){
                $student->update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Student Updated Successfully'
                ],200);
            }else{
                
                return response()->json([
                    'status' => 404,
                    'message' => 'Something went wrong'
                ],404);
            }
        }
    }
    public function destroy($id)
    {
        $student = Student::find($id);
        if($student){

            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => "Student Deleted Successfully"
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Such Student Found!"
            ],404);
        }
    }
}

