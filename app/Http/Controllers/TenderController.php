<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tender;
use Session;

class TenderController extends Controller
{
    public function create()
    {
        return view('tender.create', ['title' => 'Create Tender']);
    }

    public function store(Request $request)
    {
        $title = $request->input('title');
        $description = $request->input('description');
        $visibility = $request->input('visibility');
        $suppliers = $request->input('suppliers');

        $dummyData = [
            'title' => $title,
            'description' => $description,
            'visibility' => $visibility,
            'suppliers' => $suppliers,
        ];

        Session::flash('success', 'Tender created successfully!');

        return redirect()->route('tender.create');
    }


    public function listContractor()
    {
        $tenders = Tender::getDummyDataForContractor();

        $data = [
            'title' => 'My Tenders (Contractor)',
            'tenders' => $tenders,
        ];

        return view('tender.list_contractor', $data);
    }
    public function edit($id)
    {
        $tender = Tender::getDummyDataById($id);

        if (!$tender) {
            return redirect()->route('tender.list_contractor')->with('error', 'Tender not found.');
        }

        return view('tender.edit', ['tender' => $tender]);
    }



    public function listSupplier()
    {
        $tenders = Tender::getDummyDataForSupplier();

        $data = [
            'title' => 'Available Tenders (Supplier)',
            'tenders' => $tenders,
        ];

        return view('tender.list_supplier', $data);
    }

    public function detail($id)
    {
        $tender = Tender::getDummyDataById($id);

        if (!$tender) {
            abort(404, 'Tender not found');
        }

        return view('tender.detail', compact('tender'));
    }


    public function destroy($id)
    {
        Session::flash('success', 'Tender deleted successfully!');
        return redirect()->route('tender.list_contractor');
    }
}
