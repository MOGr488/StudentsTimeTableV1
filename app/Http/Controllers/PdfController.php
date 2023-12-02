<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return "Hello World!";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pdfs.create') ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the file is pdf
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:2048'
        ]);
        // handle file upload
        $file = $request->file('pdf');
        $filename = $file->getClientOriginalName();
        $path = $file->store('public/pdfs');
        $size = $file->getSize();
        $pageCount = $this->getPageCount($path);
        // save file record to database
    $pdf = new Pdf(
        [
            'filename' => $filename,
            'path' => $path,
            'size' => $size,
            'page_count' => $pageCount,
        ]
    );

    }

    /**
     * Display the specified resource.
     */
    public function show(Pdf $pdf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pdf $pdf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pdf $pdf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pdf $pdf)
    {
        //
    }

    private function getPageCount($path)
    {
        return (new Parser())->parseFile(storage_path('app/' . $path))->getDetails()['Pages'];
    }
}
