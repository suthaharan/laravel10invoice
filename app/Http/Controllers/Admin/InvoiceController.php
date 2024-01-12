<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:invoice_list', ['only' => ['index', 'show']]);
        $this->middleware('can:invoice_create', ['only' => ['create', 'store']]);
        $this->middleware('can:invoice_edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:invoice_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = (new Invoice)->newQuery();
        $invoices->latest();
        $invoices = $invoices->paginate(10)->appends(request()->query());

        return Inertia::render('Admin/Invoice/Index', [
            'invoices' => $invoices,
            'can' => [
                'create' => Auth::user()->can('invoice_create'),
                'edit' => Auth::user()->can('invoice_edit'),
                'delete' => Auth::user()->can('invoice_delete'),
            ]
        ]);
    }


    public function destroy(Invoice $invoice){
        $invoice->delete();
        sleep(1);
        return redirect()->route('invoice.index')->with('message', 'Invoice Deleted Successfully');
    }

}
