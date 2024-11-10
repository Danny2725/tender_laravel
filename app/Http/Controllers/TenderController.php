<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenderModel;
use App\Models\InviteModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TenderController extends Controller
{
    // Hiển thị form tạo tender
    public function create()
    {
        return view('tender.create', ['title' => 'Create Tender']);
    }

    public function store(Request $request)
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
            }
        
        } catch (JWTException $e) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid or expired'], 401);
        }
    
        $this->validateRequest($request);
    
        $tender = TenderModel::create([
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'creator_id' => $user->id,
        ]);
    
        $this->handleInvites($tender, $request->suppliers);
    
        Session::flash('success', 'Tender created successfully!');
        return response()->json(['status' => 'success', 'message' => 'Tender created successfully!']);
    }

    public function listContractor()
    {
        $tenders = TenderModel::where('creator_id', Auth::id())->get();

        return view('tender.list_contractor', [
            'title' => 'My Tenders (Contractor)',
            'tenders' => $tenders,
        ]);
    }

    // Hiển thị form chỉnh sửa tender
    public function edit($id)
    {
        $tender = $this->findTenderByIdAndOwner($id);

        if (!$tender) {
            return redirect()->route('tender.listContractor')->with('error', 'Tender not found.');
        }

        return view('tender.edit', compact('tender'));
    }

    // Cập nhật thông tin tender
    public function update(Request $request, $id)
    {
        $this->validateRequest($request);

        $tender = $this->findTenderByIdAndOwner($id);

        if (!$tender) {
            return redirect()->route('tender.listContractor')->with('error', 'Tender not found.');
        }

        $tender->update([
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
        ]);

        $this->handleInvites($tender, $request->suppliers);

        Session::flash('success', 'Tender updated successfully!');
        return redirect()->route('tender.listContractor');
    }

    // Danh sách các tender khả dụng cho supplier
    public function listSupplier()
    {
        $tenders = TenderModel::where('visibility', 'public')
            ->orWhereHas('invites', function ($query) {
                $query->where('supplier_email', Auth::user()->email);
            })
            ->get();

        return view('tender.list_supplier', [
            'title' => 'Available Tenders (Supplier)',
            'tenders' => $tenders,
        ]);
    }

    // Xem chi tiết một tender
    public function detail($id)
    {
        $tender = TenderModel::findOrFail($id);

        if ($tender->visibility === 'private' && !$this->canAccessTender($tender)) {
            abort(403, 'You do not have access to this tender.');
        }

        return view('tender.detail', compact('tender'));
    }

    // Xóa một tender
    public function destroy($id)
    {
        $tender = $this->findTenderByIdAndOwner($id);

        if (!$tender) {
            return redirect()->route('tender.listContractor')->with('error', 'Tender not found.');
        }

        $tender->delete();
        Session::flash('success', 'Tender deleted successfully!');
        return redirect()->route('tender.listContractor');
    }

    // Xử lý lời mời cho tender
    protected function handleInvites($tender, $suppliers)
    {
        if ($tender->visibility === 'private' && $suppliers) {
            $tender->invites()->delete(); // Xóa lời mời cũ
            $tender->invites()->createMany(
                collect($suppliers)->map(fn($email) => ['supplier_email' => $email])->toArray()
            );
        }
    }

    // Kiểm tra quyền truy cập vào tender
    protected function canAccessTender($tender)
    {
        return $tender->creator_id === Auth::id() || $tender->invites->contains('supplier_email', Auth::user()->email);
    }

    // Tìm một tender bởi ID và người tạo
    protected function findTenderByIdAndOwner($id)
    {
        return TenderModel::where('id', $id)->where('creator_id', Auth::id())->first();
    }

    // Xác thực dữ liệu đầu vào
    protected function validateRequest(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'visibility' => 'required|in:public,private',
            'suppliers' => 'nullable|array',
            'suppliers.*' => 'email'
        ]);
    }
}