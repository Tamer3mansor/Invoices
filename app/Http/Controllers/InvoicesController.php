<?php

namespace App\Http\Controllers;

use App\Models\invoice_attechments;
use App\Models\invoices;
use App\Models\Invoices_details;
use App\Models\Product;
use App\Models\Section;
use App\Models\User;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = invoices::get();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::get();
        return view("invoices.add_invoices", compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $val = invoices::create([
            "invoice_number" => $request->invoice_number,
            "invoice_date" => $request->invoice_Date,
            "due_date" => $request->Due_date,
            "product" => $request->product,
            "section_id" => $request->Section,
            "amount_collection" => $request->Amount_collection,
            "amount_commission" => $request->Amount_Commission,
            "discount" => $request->Discount,
            "value_vat" => $request->Value_VAT,
            "rate_vat" => $request->Rate_VAT,
            "total" => $request->Total,
            "status" => "غير مدفوعه",
            "value_status" => 2,
            "note" => $request->note,
        ]);
        $invoice_id = $val->id;
        Invoices_details::create([
            "invoice_id" => $invoice_id,
            "invoice_number" => $request->invoice_number,
            "product" => $request->product,
            "section" => $request->Section,
            "status" => "غير مدفوعه",
            "value_status" => 2,
            "note" => $request->note,
            "user" => Auth::user()->name,
        ]);
        if ($request->hasFile('pic')) {
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            invoice_attechments::create([
                "file_name" => $file_name,
                "invoice_number" => $invoice_number,
                "created_by" => Auth::user()->name,
                "invoice_id" => $invoice_id

            ]);
            $request->pic->move(public_path("Attachments/" . $invoice_number), $file_name);
        }
        ;
         $user = Auth::user();
        $user->notify(new AddInvoice($invoice_id));


        return back()->with("ADD", "تمام تم الإضافه بنجاح");

    }

    /**
     * Display the specified resource.
     */
    public function show(invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices $invoice)
    {
        $invoices = invoices::findOrFail($invoice->id);
        $sections = Section::get();
        // dd($invoice);
        return view('invoices.edit_invoices', compact('invoices', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices $invoice)
    {

        $val = $invoice->update([
            "invoice_number" => $request->invoice_number,
            "invoice_date" => $request->invoice_Date,
            "due_date" => $request->Due_date,
            "product" => $request->product,
            "section_id" => $request->Section,
            "amount_collection" => $request->Amount_collection,
            "amount_commission" => $request->Amount_Commission,
            "discount" => $request->Discount,
            "value_vat" => $request->Value_VAT,
            "rate_vat" => $request->Rate_VAT,
            "total" => $request->Total,
            "status" => "غير مدفوعه",
            "value_status" => 2,
            "note" => $request->note,
        ]);
        return back()->with('edit', 'اتعدلت بنجاح');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();
        $Details = invoice_attechments::where('invoice_id', $id)->first();

        $id_page = $request->id_page;


        if (!$id_page == 2) {

            if (!empty($Details->invoice_number)) {

                Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
            }

            $invoices->forceDelete();
            session()->flash('delete_invoice');
            return redirect('/invoices');

        } else {

            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('/Archive');
        }
    }
    public function get_products($id)
    {
        // $product = DB::table('products')->where("section_id", $id)->pluck("product_name", "id");
        // return json_encode($product);
        $product = Product::where('section_id', $id)->pluck('product_name', 'id');
        return response()->json($product);
    }
    public function details($id)
    {

        $invoices = Invoices::find($id);
        $details = Invoices_details::where("invoice_id", $id)->get();
        $attachments = invoice_attechments::where("invoice_id", $id)->get();
        // dd($details);
        return view("invoices.details_invoices", compact('invoices', 'details', 'attachments'));
    }
    public function status_show($id)
    {
        $invoices = invoices::findOrFail($id);
        return view('invoices.status_update', compact('invoices'));
    }
    public function status_update(invoices $invoice, Request $request)
    {
        $data = $request->all();
        $status = $request->Status;
        $invoice->status = $status;
        $invoice->payment_date = $request->Payment_Date;
        if ($status == 'مدفوعه')
            $val = 1;
        else
            $val = 3;
        $invoice->value_status = $val;
        $invoice->save();
        Invoices_details::create([
            "invoice_id" => $data['invoice_id'],
            "invoice_number" => $request->invoice_number,
            "product" => $request->product,
            "section" => $request->Section,
            "status" => $status,
            "value_status" => $val,
            "note" => $request->note,
            "user" => Auth::user()->name,
        ]);
        return back()->with("", "");
        // dd($invoice, $request);

        // $invoices = invoices::findOrFail($id);
        // return view('invoices.status_update', compact('invoices'));
    }
    public function paid()
    {

        $invoices = invoices::where('value_status', '3')->get();
        return view('invoices.paid_invoices', compact('invoices'));
    }
    public function un_paid()
    {

        $invoices = invoices::where('value_status', '2')->get();
        return view('invoices.paid_invoices', compact('invoices'));
    }
    public function p_paid()
    {

        $invoices = invoices::where('value_status', '1')->get();
        return view('invoices.paid_invoices', compact('invoices'));
    }
    public function print_invoice($id)
    {
        // dd("LL");
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.print_invoice', compact('invoices'));
    }
}



/*


*/
