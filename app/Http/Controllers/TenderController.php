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
    public function create()
    {
        return view('tender.create', ['title' => 'Create Tender']);
    }

    public function store(Request $request)
    {
        try {
            // Lấy người dùng hiện tại từ JWT token
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

    public function listContractor(Request $request)
    {

        $accessToken = $request->cookie('access_token');

        try {
            if (!$accessToken) {
                return redirect()->route('login')->with('error', 'Access token is missing.');
            }

            $user = JWTAuth::setToken($accessToken)->authenticate();
            if (!$user) {
                return redirect()->route('login')->with('error', 'User not found.');
            }
        } catch (JWTException $e) {
            return redirect()->route('login')->with('error', 'Token is invalid or expired.');
        }

        $tenders = TenderModel::where('creator_id', $user->id)->get();

        return view('tender.list_contractor', [
            'title' => 'My Tenders (Contractor)',
            'tenders' => $tenders,
        ]);
    }


    public function edit($id)
    {
        // Tìm tender theo ID và kiểm tra quyền truy cập
        $tender = TenderModel::findOrFail($id);

        return view('tender.edit', compact('tender'));
    }

    // Cập nhật tender
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'visibility' => 'required|string|in:public,private',
        ]);

        $tender = TenderModel::findOrFail($id);

        $tender->update([
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
        ]);
        return redirect()->route('tender.list_contractor')->with('success', 'Tender updated successfully');
    }

    // Xóa tender
    public function destroy($id)
    {

        $tender = TenderModel::findOrFail($id);

        $tender->delete();

        return response()->json(['success' => 'Tender deleted successfully']);
    }

    // Danh sách các tender khả dụng cho supplier
    public function listSupplier(Request $request)
    {
        $accessToken = $request->cookie('access_token');

        try {
            if (!$accessToken) {
                return redirect()->route('login')->with('error', 'Access token is missing.');
            }

            $user = JWTAuth::setToken($accessToken)->authenticate();
            if (!$user) {
                return redirect()->route('login')->with('error', 'User not found.');
            }
        } catch (JWTException $e) {
            return redirect()->route('login')->with('error', 'Token is invalid or expired.');
        }

        $userId = $user->id;
        $userEmail = $user->email;

        $tenderModel = new TenderModel();

        $publicTenders = $tenderModel
            ->where('visibility', 'public')
            ->where('creator_id', '!=', $userId)
            ->get();

        $inviteModel = new InviteModel();
        $invites = $inviteModel->where('supplier_email', $userEmail)->get();

        // Use pluck to get an array of tender_ids
        $invitedTenderIds = $invites->pluck('tender_id')->toArray();

        $privateTenders = [];
        if (!empty($invitedTenderIds)) {
            $privateTenders = $tenderModel
                ->whereIn('id', $invitedTenderIds)
                ->where('visibility', 'private')
                ->get();
        }
        return view('tender.list_supplier', [
            'title' => 'Available Tenders (Supplier)',
            'publicTenders' => $publicTenders,
            'privateTenders' => $privateTenders
        ]);
    }

    public function detail($id)
    {
        $tender = TenderModel::findOrFail($id);

        if ($tender->visibility === 'private' && !$this->canAccessTender($tender)) {
            abort(403, 'You do not have access to this tender.');
        }

        return view('tender.detail', compact('tender'));
    }

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
