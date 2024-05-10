<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajuan = Pengajuan::all();
        $role = Auth::user()->role;

        return view('dashboard',['pengajuan' => $pengajuan, 'role' => $role]);
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
    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required','string'],
            'no_ktp'=> ['required','string'],
            'foto_ktp'=> ['required', 'image'],
            'kartu_vaksin' => ['required', 'image'],
            'area' => ['required'],
            'unit_kerja' => ['required','string'],
            'nama_perusahaan' => ['required','string'],
            'lama_bekerja' => ['required'],
            'tanggal_mulai' => ['required']
        ]);

        try {
            $foto_ktp = $request->file('foto_ktp');
            $foto_ktp->storeAs('public/foto_ktp', $foto_ktp->hashName());

            $kartu_vaksin = $request->file('kartu_vaksin');
            $kartu_vaksin->storeAs('public/kartu_vaksin', $kartu_vaksin->hashName());

            Pengajuan::create([
                'user_id' => Auth::user()->id,
                'nama' => $request->nama,
                'no_ktp' => $request->no_ktp,
                'foto_ktp' => $foto_ktp->hashName(),
                'kartu_vaksin' => $kartu_vaksin->hashName(),
                'area' => $request->area,
                'unit_kerja' => $request->unit_kerja,
                'nama_perusahaan' => $request->nama_perusahaan,
                'lama_bekerja' => $request->lama_bekerja,
                'tanggal_mulai' => $request->tanggal_mulai,
                'status' => "Menunggu Approval"
            ]);

        } catch (\Exception $e) {
            Log::error("Error in storing data: " . $e->getMessage());
            return redirect()->back()->with(['error' => 'Data Gagal Disimpan!']);
        }

       
        return redirect()->route('dashboard')->with(['success' => 'Data Berhasil Disimpan!']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        return view('pengajuan.dtail',['pengajuan' => $pengajuan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
