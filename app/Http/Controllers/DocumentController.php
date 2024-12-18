<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'client' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'discipline' => 'required|string|max:255',
            'document_category' => 'required|string|max:255',
            'document_drawing' => 'required|string|max:255',
            'pdf' => 'required|file|mimes:pdf|max:2048',
            'document_title' => 'required|string|max:255',
            'revision' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'revision_date' => 'required|date',
        ]);

        if ($request->hasFile('pdf')) {
            $pdfFileName = time() . '_' . str_replace(' ', '_', $request->document_title) . '.pdf';
            $pdfFilePath = $request->file('pdf')->storeAs('documents/pdfs', $pdfFileName, 'public');
        }

        $document = new Document();
        $document->client = $request->client;
        $document->project_name = $request->project_name;
        $document->discipline = $request->discipline;
        $document->document_category = $request->document_category;
        $document->document_drawing = $request->document_drawing;
        $document->pdf = $pdfFilePath ?? null;
        $document->document_title = $request->document_title;
        $document->revision = $request->revision;
        $document->status = $request->status;
        $document->revision_date = $request->revision_date;
        $document->save();

        return redirect()->back()->with('success', 'Document added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'client' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'discipline' => 'required|string|max:255',
            'document_category' => 'required|string|max:255',
            'document_drawing' => 'required|string|max:255',
            'pdf' => 'nullable|file|mimes:pdf|max:2048',
            'document_title' => 'required|string|max:255',
            'revision' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'revision_date' => 'required|date',
        ]);

        $document = Document::findOrFail($id);

        if ($request->hasFile('pdf')) {
            if ($document->pdf) {
                Storage::delete('public/' . $document->pdf);
            }

            $pdfFileName = time() . '_' . str_replace(' ', '_', $request->document_title) . '.pdf';
            $pdfFilePath = $request->file('pdf')->storeAs('documents/pdfs', $pdfFileName, 'public');
            $document->pdf = $pdfFilePath;
        }

        $document->client = $request->client;
        $document->project_name = $request->project_name;
        $document->discipline = $request->discipline;
        $document->document_category = $request->document_category;
        $document->document_drawing = $request->document_drawing;
        $document->document_title = $request->document_title;
        $document->revision = $request->revision;
        $document->status = $request->status;
        $document->revision_date = $request->revision_date;

        $document->save();

        return redirect()->back()->with('success', 'Document updated successfully.');
    }

    public function delete($id)
    {
        $document = Document::find($id);
        $document->delete();
        return redirect()->back()->with('success', 'Document deleted successfully.');
    }
}
