<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttachmentRequest;
use App\Models\invoice_attechments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// use Storage;

class InvoiceAttechmentsController extends Controller
{
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
    public function store(StoreAttachmentRequest $request)
    {
        $data = $request->all();
        $file_name = $data['file_name']->getClientOriginalName();
        $invoice_number = $request->invoice_number;
        invoice_attechments::create([
            "file_name" => $file_name,
            "invoice_number" => $request->invoice_number,
            "created_by" => Auth::user()->name,
            "invoice_id" => $request->invoice_id,

        ]);
        $request->file_name->move(public_path("Attachments/" . $invoice_number), $file_name);

    }

    /**
     * Display the specified resource.
     */
    public function show(invoice_attechments $invoice_attechments)
    {
        // dd($invoice_attechments, $invoice_number);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice_attechments $invoice_attechments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice_attechments $invoice_attechments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        invoice_attechments::where('id', $request->id_file)->delete();
        $path = "$request->invoice_number/$request->file_name"; // Relative path within the disk
        Storage::disk('public_uploads')->delete($path);
        return back()->with("delete", "تم الحذف بنجاح");

    }
    public function file($invoice_number, $file_name)
    {
        $path = Storage::disk('public_uploads')->path("$file_name/$invoice_number");

        return response()->file($path);
    }
    public function download($invoice_number, $file_name)
    {
        $path = Storage::disk('public_uploads')->path("$file_name/$invoice_number");

        return response()->download($path);



    }

}
