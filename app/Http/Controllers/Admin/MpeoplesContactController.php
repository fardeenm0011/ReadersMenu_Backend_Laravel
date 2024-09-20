<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MpeoplesContact;

class MpeoplesContactController extends Controller
{
    //-----------------------------------------API---------------------------------------------------//
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'type' => 'required|in:contact,course,studentinfo',
            'gender' => 'nullable|in:male,female',
            'birthday' => 'nullable|date',
            'collegeName' => 'nullable|string|max:255',
            'collegeLocation' => 'nullable|string|max:255',
            'degree' => 'nullable|in:ug,pg',
            'degreeName' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'courseInterests' => 'nullable|in:fullstack,ui_development,ui/ux,php-laravel,python,reactjs,nodejs,mysql,mongodb',
        ]);


        $contact = new MpeoplesContact($validatedData);
        $contact->first_name = $validatedData['firstName'];
        $contact->last_name = $validatedData['lastName'];
$contact->type = $validatedData['type'];
       // print_r($validatedData);exit;

        if (isset($validatedData['collegeName']))
            $contact->college_name = $validatedData['collegeName'];
        if (isset($validatedData['collegeLocation']))
            $contact->college_location = $validatedData['collegeLocation'];
        if (isset($validatedData['degreeName']))
            $contact->degree_name = $validatedData['degreeName'];
        if (isset($validatedData['courseInterests']))
            $contact->course_interests = $validatedData['courseInterests'];
        $contact->save();
        return response()->json(['message' => 'Contact message saved successfully'], 200);
    }

    public function getMpeoplesContact(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $currentPage = $request->input('current_page', 1);
        $search = $request->input('search');

        // Start a query on the Employee model
        $query = MpeoplesContact::query();
        $query->where('type', 'contact');
        // Apply search filtering if search term is provided
        if (!empty($search)) {
            $query->where('message', 'like', "%$search%");
        }
        if ($perPage == -1) {
            $contacts = $query->orderBy('id', 'asc')->all();
        } else
            $contacts = $query->orderBy('id', 'asc')->paginate($perPage, ['*'], 'page', $currentPage);
        return response()->json($contacts, 200);
    }
    public function getMpeoplesStudent(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $currentPage = $request->input('current_page', 1);
        $search = $request->input('search');

        // Start a query on the Employee model
        $query = MpeoplesContact::query();
        $query->where('type', 'course');
        // Apply search filtering if search term is provided
        if (!empty($search)) {
            $query->where('message', 'like', "%$search%");
        }
        if ($perPage == -1) {
            $contacts = $query->orderBy('id', 'asc')->all();
        } else
            $contacts = $query->orderBy('id', 'asc')->paginate($perPage, ['*'], 'page', $currentPage);
        return response()->json($contacts, 200);
    }
    public function getMpeoplesStudentDetails(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $currentPage = $request->input('current_page', 1);
        $search = $request->input('search');

        // Start a query on the Employee model
        $query = MpeoplesContact::query();
        $query->where('type', 'studentinfo');
        // Apply search filtering if search term is provided
        if (!empty($search)) {
            $query->where('message', 'like', "%$search%");
        }
        if ($perPage == -1) {
            $contacts = $query->orderBy('id', 'asc')->all();
        } else
            $contacts = $query->orderBy('id', 'asc')->paginate($perPage, ['*'], 'page', $currentPage);
        return response()->json($contacts, 200);
    }

}
