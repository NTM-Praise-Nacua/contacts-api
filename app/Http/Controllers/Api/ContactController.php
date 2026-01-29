<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Contact::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'contact_no' => 'required',
            'added_by' => 'required',
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'contact_no' => $request->contact_no,
            'added_by' => $request->added_by,
        ]);

        if ($contact) {
            return response()->json([
                'status' => 'success',
                'data' => $contact,
                'message' => 'Contact Added'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Failed to add'
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'contact_no' => $contact->contact_no,
                ],
                'message' => 'Contact Retrieved'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Contact not found'
            ], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd('test', $request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'contact_no' => 'required',
            'added_by' => 'required',
        ]);

        $contact = Contact::find($id);
        if ($contact) {
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->contact_no = $request->contact_no;
            $contact->added_by = $request->added_by;
            $contact->save();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'name' => $request->name,
                    'email' => $request->email,
                    'contact_no' => $request->contact_no,
                    'added_by' => $request->added_by,
                ],
                'message' => 'Contact Updated',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => "Contact not found"
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getContactsByUser($id)
    {
        $contact = Contact::where('added_by', $id)->select('id', 'name')->get();
        return response()->json([
            'status' => 'success',
            'data' => $contact,
            'message' => 'Retrieve successfully',
        ], 200);
    }
}
