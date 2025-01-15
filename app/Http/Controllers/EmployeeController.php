<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Action;
use Illuminate\Http\Request;
use App\Http\Requests\ActionRequest;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function AddActionToCustomer(ActionRequest $request)
    {
        try {
            $action = Action::create(
                array_merge($request->all(),
                [
                    'created_by' => Auth::user()->id
                ])
            );

            return response()->json([
                'message' => 'Action added successfully',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something wrong, please confirm your data and try again.',
            ], 403);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
