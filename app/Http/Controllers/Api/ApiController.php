<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    public function register(Request $request)
    {

        // Data validation
        $request->validate([
            "organizationName" => "required",
            "legalEntityName" => "",
            "firstName" => "required",
            "lastName" => "required",
            "agentRole" => "required",
            "Country" => "required",
            "mobile_number" => "required",
            "email" => "required|email|unique:users",
            "password" => "required"
        ]);

        // Data save
        User::create([
            "organizationName" => $request->organizationName,
            "legalEntityName" => $request->legalEntityName,
            // "name" => $request->firstName . ' ' . $request->lastName,
            "firstName" => $request->firstName,
            "lastName" => $request->lastName,
            "agentRole" => $request->agentRole,
            "Country" => $request->Country,
            "mobile_number" => $request->mobile_number,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);


        // Response
        return response()->json([
            "status" => true,
            "message" => "User registered successfully",
        ]);
    }



    // Add admin User API (POST, form-data)
    public function createNewUser(Request $request)
    {

        // Data validation
        $request->validate([
            "fname" => "required",
            "lname" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed",
            "role" => "required"

        ]);

        // Data save
        User::create([
            "fname" => $request->fname,
            "lname" => $request->lname,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "role" => $request->role
        ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "Admin User Created successfully"
        ]);
    }





    // Login API (POST, form-data)
    public function login(Request $request)
    {
        // Data validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // JWTAuth and attempt

        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);

        //Response

        if (!empty($token)) {

            return response()->json([
                "status" => true,
                "message" => "User logged in successfully",
                "token" => $token
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Invalid Login details"
        ]);
    }


    // Profile API (get)
    public function profile()
    {
        $id = Auth::user()->id;
        // $profileData = User::find($id);

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            // "user" => $profileData
        ]);
    }

    // Refresh token API (get)
    public function refreshToken()
    {
        $newToken = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "New Access Token Generated",
            "token" => $newToken
        ]);
    }

    // Logout API (get)
    public function logout()
    {
        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);
    }


    public function addStudent( Request $request)
    {
        // Define validation rules
        $rules = [
            'salutation' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'date_of_birth' => 'required|date',
            'student_phone_number' => 'required|string|max:20|unique:students,student_phone_number',
            'language' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'marital_status' => 'required|in:single,married,divorced,widowed,engaged,de_facto,separated',
            'country_of_birth' => 'required|in:bangladesh,australia,other',
            'passport_number' => 'required|string|max:255',
            'passport_expiry_date' => 'required|date',
            'current_student_location' => 'required|string|max:255',
            'is_18_or_older' => 'required|boolean',
            'team_assignment' => 'nullable|string|max:255',
        ];

        // Validate the request
        $validatedData = $request->validate($rules);

        // Create a new student record
        $student = Student::create([
            'salutation' => $validatedData['salutation'],
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'student_phone_number' => $validatedData['student_phone_number'],
            'language' => $validatedData['language'],
            'gender' => $validatedData['gender'],
            'marital_status' => $validatedData['marital_status'],
            'country_of_birth' => $validatedData['country_of_birth'],
            'passport_number' => $validatedData['passport_number'],
            'passport_expiry_date' => $validatedData['passport_expiry_date'],
            'current_student_location' => $validatedData['current_student_location'],
            'is_18_or_older' => $validatedData['is_18_or_older'],
            'team_assignment' => $validatedData['team_assignment'] ?? null,
        ]);

        // Return a response
        return response()->json([
            "status" => true,
            'message' => 'Student created successfully!',
            'student' => $student
        ], 201);
    }

    // Show all students' details
    public function showAllStudents()
    {
        // Retrieve all students
        $students = Student::all();

        // Return the student details
        return response()->json([
            "status" => true,
            'message' => 'Student show successfully!',
            'students' => $students
        ], 200);
    }

   // Return show a specific student's details
    public function showStudent($id)
    {
        // Find the student by ID
        $studentData = Student::find($id);

        // Check if the student exists
        if (!$studentData) {
            return response()->json([
                "status" => false,
                'message' => 'Student not found!'
            ], 404);
        }

        // Return the student details
        return response()->json([
            "status" => true,
            'message' => 'show Specific Student data successfully!',
            'student' => $studentData
        ], 200);
    }
}
