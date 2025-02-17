<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Termwind\render;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::get();
        return view('sections.sections', compact('sections'));
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
    public function store(StoreSectionRequest $request)
    {
        $data = $request->validated();
        $b_exists = Section::where('section_name', $data['section_name'])->exists();
        if ($b_exists) {
            SESSION()->flash('Error', "القسم موجود بالفعل");
            return redirect(route('sections.index'));
        } else {
            Section::create([
                'section_name' => $request['section_name'],
                'description' => $request['description'],
                'created_by' => (Auth::user()->name),
            ]);

        }
        return back()->with("edit", "edit success");

    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        Section::find($section);
        return view("");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request)
    {
        $data = $request->all();
        Section::where('id', $data['id'])->update([
            "section_name" => $data['section_name'],
            "description" => $data['description'],
        ]);
        return back()->with("edit", "edit success");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = $request->all();
        Section::where('id', $data['id'])->delete();
        return back()->with("delete", "delete success");

    }
}
