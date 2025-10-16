<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fieldwork;
use App\Models\Branch;
use App\Models\FieldworkCategory;
use App\Models\FieldworkStatus;
use App\Models\User;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FieldworkController extends Controller
{
    // GET /api/fieldwork
    public function index()
    {
        $fieldwork = Fieldwork::with(['branch', 'category', 'status', 'users'])
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'List of fieldwork retrieved successfully',
            'data' => $fieldwork
        ]);
    }

    // POST /api/fieldwork
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'note'        => 'nullable|string',
            'branch_id'   => 'required|exists:branches,id',
            'category_id' => 'required|exists:fieldwork_categories,id',
            'status_id'   => 'required|exists:fieldwork_statuses,id',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'users'       => 'required|array',
            'users.*'     => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $fieldwork = Fieldwork::create([
            'description' => $request->description,
            'note'        => $request->note,
            'branch_id'   => $request->branch_id,
            'category_id' => $request->category_id,
            'status_id'   => $request->status_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
        ]);

        $fieldwork->users()->sync($request->users);

        // Kirim WA ke semua user terpilih
        $users = User::with('phone')->whereIn('id', $request->users)->get();
        foreach ($users as $user) {
            foreach ($user->phone as $phone) {
                $this->sendWhatsAppMessage($phone->number, $fieldwork);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Fieldwork created successfully and WhatsApp notifications sent',
            'data' => $fieldwork->load(['branch', 'category', 'status', 'users'])
        ], 201);
    }

    // GET /api/fieldwork/{id}
    public function show($id)
    {
        $fieldwork = Fieldwork::with(['branch', 'category', 'status', 'users'])->find($id);

        if (!$fieldwork) {
            return response()->json([
                'status' => false,
                'message' => 'Fieldwork not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Fieldwork detail retrieved successfully',
            'data' => $fieldwork
        ]);
    }

    // PUT /api/fieldwork/{id}
    public function update(Request $request, $id)
    {
        $fieldwork = Fieldwork::find($id);

        if (!$fieldwork) {
            return response()->json([
                'status' => false,
                'message' => 'Fieldwork not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'note'        => 'nullable|string',
            'branch_id'   => 'required|exists:branches,id',
            'category_id' => 'required|exists:fieldwork_categories,id',
            'status_id'   => 'required|exists:fieldwork_statuses,id',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'users'       => 'required|array',
            'users.*'     => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $fieldwork->update([
            'description' => $request->description,
            'note'        => $request->note,
            'branch_id'   => $request->branch_id,
            'category_id' => $request->category_id,
            'status_id'   => $request->status_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
        ]);

        $fieldwork->users()->sync($request->users);

        // Kirim ulang WA
        $users = User::with('phone')->whereIn('id', $request->users)->get();
        foreach ($users as $user) {
            foreach ($user->phone as $phone) {
                $this->sendWhatsAppMessage($phone->number, $fieldwork);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Fieldwork updated successfully',
            'data' => $fieldwork->load(['branch', 'category', 'status', 'users'])
        ]);
    }

    // DELETE /api/fieldwork/{id}
    public function destroy($id)
    {
        $fieldwork = Fieldwork::find($id);

        if (!$fieldwork) {
            return response()->json([
                'status' => false,
                'message' => 'Fieldwork not found'
            ], 404);
        }

        $fieldwork->delete();

        return response()->json([
            'status' => true,
            'message' => 'Fieldwork deleted successfully'
        ]);
    }

    // Fungsi kirim WhatsApp (masih sama)
    private function sendWhatsAppMessage($phone, $fieldwork)
    {
        $token = env('FONNTE_TOKEN');

        $message = "Halo! Anda telah ditugaskan dalam Fieldwork: *{$fieldwork->category->name}*\n"
                 . "Tanggal: " . Carbon::parse($fieldwork->start_date)->translatedFormat('d F Y')
                 . " s/d " . Carbon::parse($fieldwork->end_date)->translatedFormat('d F Y') . "\n"
                 . "Lokasi: *{$fieldwork->branch->address}*\n"
                 . "Harap konfirmasi kehadiran Anda.";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.fonnte.com/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => [
                'target' => $phone,
                'message' => $message,
            ],
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
