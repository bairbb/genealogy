<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PersonController extends Controller
{
    public function index()
    {
        $persons = Person::all()->toTree();
        return Inertia::render('Persons/Index', ['persons' => $persons]);
    }

    public function show(Request $request, Person $person)
    {
//        $person = Person::find($request->id);
//        dd($person->name);
        return Inertia::render('Persons/Show', ['person' => $person]);
    }
}
