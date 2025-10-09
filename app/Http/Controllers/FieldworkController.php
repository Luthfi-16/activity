<?php
namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Fieldwork;
use App\Models\FieldworkCategory;
use App\Models\FieldworkStatus;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class FieldworkController extends Controller
{
    public function index()
    {
        $fieldwork = Fieldwork::with(['branch', 'category', 'status', 'users'])
            ->latest()
            ->get();

        return view('fieldwork.index', compact('fieldwork'));
    }

    public function create()
    {
        $regions  = Region::all(); // ambil semua region
        $branches = Branch::all();
        $category = FieldworkCategory::all();
        $status   = FieldworkStatus::all();
        $users = User::where('is_admin', 0)->orderBy('name')->get();

        return view('fieldwork.create', compact('branches', 'status', 'category', 'users', 'regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
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

        // Simpan fieldwork baru
        $fieldwork = Fieldwork::create([
            'description' => $request->description,
            'note'        => $request->note,
            'branch_id'   => $request->branch_id,
            'category_id' => $request->category_id,
            'status_id'   => $request->status_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
        ]);

        // Simpan relasi user
        $fieldwork->users()->sync($request->users);

        // 🔔 Kirim WA ke semua user yang dipilih
        $users = User::with('phone')->whereIn('id', $request->users)->get();

        foreach ($users as $user) {
            foreach ($user->phone as $phone) {
                $this->sendWhatsAppMessage($phone->number, $fieldwork);
            }
        }

        Alert::success('Success', 'Data added successfully & WhatsApp sent!');
        return redirect()->route('fieldwork.index');
    }


    public function show(string $id)
    {
        $fieldwork = Fieldwork::with(['branch', 'category', 'status', 'users'])->findOrFail($id);
        return view('fieldwork.show', compact('fieldwork'));
    }

    public function edit(string $id)
    {
        $regions = Region::all();
        $fieldwork = Fieldwork::with('users')->findOrFail($id);
        $branches    = Branch::all();
        $categories  = FieldworkCategory::all();
        $statuses    = FieldworkStatus::all();
        $users = User::where('is_admin', 0)->orderBy('name')->get();
        // Ambil region dari branch yang sudah terpasang (jika ada)
    $selectedRegionId = $fieldwork->branch ? $fieldwork->branch->region_id : null;

    // Ambil hanya branch yang sesuai region tersebut
    $branches = $selectedRegionId
        ? Branch::where('region_id', $selectedRegionId)->get()
        : collect(); // kosong kalau gak ada region/branch

        return view('fieldwork.edit', compact('fieldwork', 'statuses', 'branches', 'categories', 'users', 'regions'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
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

        $fieldwork = Fieldwork::findOrFail($id);
        $fieldwork->update([
            'description' => $request->description,
            'note'        => $request->note,
            'branch_id'   => $request->branch_id,
            'category_id' => $request->category_id,
            'status_id'   => $request->status_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
        ]);

        // update pivot user_fieldworks
        $fieldwork->users()->sync($request->users);

        // Kirim ulang WA notifikasi ke user terupdate
        $users = User::with('phone')->whereIn('id', $request->users)->get();
        foreach ($users as $user) {
            foreach ($user->phone as $phone) {
                $this->sendWhatsAppMessage($phone->number, $fieldwork);
            }
        }

        Alert::success('Success', 'Data edited successfully');
        return redirect()->route('fieldwork.index');
    }

    public function destroy(string $id)
    {
        $fieldwork = Fieldwork::findOrFail($id);
        $fieldwork->delete();

        Alert::warning('Deleted', 'Data deleted successfully');
        return redirect()->route('fieldwork.index');
    }

    private function sendWhatsAppMessage($phone, $fieldwork)
    {
        $token = env('FONNTE_TOKEN'); // token dari .env

        $message = "Halo! Anda telah ditugaskan dalam Fieldwork: *{$fieldwork->category->name}*\n"
                    . "Tanggal: " . Carbon::parse($fieldwork->start_date)->translatedFormat('d F Y')
                    . " s/d " . Carbon::parse($fieldwork->end_date)->translatedFormat('d F Y') . "\n" 
                    . "Lokasi: *{$fieldwork->branch->address}*" . ",\n"
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
