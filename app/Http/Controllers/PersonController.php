<?php

namespace App\Http\Controllers;

use App\Events\PersonCreated;
use App\Http\Requests\CreatePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $persons = Person::with(['language', 'interests'])->get();
        return PersonResource::collection($persons);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return PersonResource
     */
    public function store(CreatePersonRequest $request)
    {
        $validated = $request->validated();
        $validated['birth_date'] = Carbon::parse($validated['birth_date'])->format('Y-m-d');
        $validated['language_id'] = $validated['language'];
        $person = Person::create($validated);

        if ($request->has('interests')) {
            $person->interests()->attach($request->input('interests'));
        }

        event(new PersonCreated($person));

        return new PersonResource($person->load(['language', 'interests']));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return PersonResource
     */
    public function update(UpdatePersonRequest $request, $id): PersonResource
    {
        $person = Person::findOrFail($id);

        $person->update($request->validated());

        if ($request->has('interests')) {
            $interests = $request->input('interests');
            $interestIds = array_column($interests, 'id');
            $person->interests()->sync($interestIds);
        }

        return new PersonResource($person->load(['language', 'interests']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $person = Person::findOrFail($id);
        $person->interests()->detach();
        $person->delete();


        return response()->json(['message' => 'Person deleted successfully'], 200);
    }
}
