<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Author::pipe(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['string', 'required', 'max:140'],
            'description' => ['string', 'required'],
            'social_media_links' => ['json', 'nullable'],
            'email' => ['string', 'required', 'max:140'],
            'profile_picture_url' => ['image', 'required'],
        ]);

        $validated['profile_picture_url'] = $this->storeFileFromRequest($request, 'profile_picture_url', 'public/media/authors');

        return response()->json(Author::create($validated), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        return response()->json($author, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => ['string', 'required', 'max:140'],
            'description' => ['string', 'required'],
            'social_media_links' => ['json', 'nullable'],
            'email' => ['string', 'required', 'max:140'],
            'profile_picture_url' => ['image', 'nullable'],
        ]);

        if(!empty($validated['profile_picture_url'])){
            $validated['profile_picture_url'] = $this->storeFileFromRequest($request, 'profile_picture_url', 'public/media/authors');
        }

        return response()->json($author->update($validated), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        return response()->json($author->delete());
    }
}
