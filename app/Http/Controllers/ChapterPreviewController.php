<?php

namespace App\Http\Controllers;

use App\Models\ChapterPreview;
use Illuminate\Http\Request;

class ChapterPreviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($comicId)
    {
        return response()->json(ChapterPreview::where('comic_id', $comicId)->orderBy('chapter')->get(), 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChapterPreview  $chapterPreview
     * @return \Illuminate\Http\Response
     */
    public function show(ChapterPreview $chapterPreview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChapterPreview  $chapterPreview
     * @return \Illuminate\Http\Response
     */
    public function edit(ChapterPreview $chapterPreview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChapterPreview  $chapterPreview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChapterPreview $chapterPreview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChapterPreview  $chapterPreview
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChapterPreview $chapterPreview)
    {
        //
    }
}
