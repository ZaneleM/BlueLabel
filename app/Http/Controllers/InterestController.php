<?php

namespace App\Http\Controllers;

use App\Http\Resources\InterestResource;
use App\Models\Interest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InterestController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return InterestResource::collection(Interest::all());
    }
}
