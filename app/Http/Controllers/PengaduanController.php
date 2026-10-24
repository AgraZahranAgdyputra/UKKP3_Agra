<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Pengaduan::query();

        if (! auth()->user()->can('pengaduan.view.all')) {
            $query->where('email', auth()->user()->email);
        }

        $pengaduans = $query->latest()->get();

        return view('pengaduans.index', compact('pengaduans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::query()->orderBy('nama')->get();

        return view('pengaduans.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori' => 'required|string|exists:kategoris,nama',
            'upload_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'nama_perusahaan' => 'nullable|string|max:255',
            'lokasi' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:10000',
            'no_hp' => 'required|string|max:20',
        ]);

        $data['nama'] = $request->user()->name;
        $data['email'] = $request->user()->email;

        if ($request->hasFile('upload_file')) {
            $data['upload_file'] = $request->file('upload_file')->store('pengaduans');
        }

        Pengaduan::create($data);

        return redirect()->route('pengaduans.index')
            ->with('success', 'Pengaduan berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengaduan $pengaduan)
    {
        //
    }

    public function photos(Pengaduan $pengaduan)
    {
        $this->authorizePengaduanAccess($pengaduan);

        return view('pengaduans.photos', compact('pengaduan'));
    }

    public function file(Pengaduan $pengaduan)
    {
        $this->authorizePengaduanAccess($pengaduan);

        abort_if(blank($pengaduan->upload_file), 404);

        $disk = Storage::disk('local');

        if (! $disk->exists($pengaduan->upload_file)) {
            $disk = Storage::disk('public');
        }

        abort_unless($disk->exists($pengaduan->upload_file), 404);

        return $disk->response($pengaduan->upload_file);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengaduan $pengaduan)
    {
        $this->authorizePengaduanAccess($pengaduan);

        $kategoris = Kategori::query()->orderBy('nama')->get();

        return view('pengaduans.edit', compact('pengaduan', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        $this->authorizePengaduanAccess($pengaduan);

        $data = $request->validate([
            'kategori' => 'required|string|exists:kategoris,nama',
            'upload_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'nama_perusahaan' => 'nullable|string|max:255',
            'lokasi' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:10000',
            'no_hp' => 'required|string|max:20',
        ]);

        if ($request->hasFile('upload_file')) {
            $data['upload_file'] = $request->file('upload_file')->store('pengaduans');
        } else {
            unset($data['upload_file']);
        }

        $pengaduan->update($data);

        return redirect()->route('pengaduans.index')
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengaduan $pengaduan)
    {
        abort_unless(auth()->user()->can('pengaduan.delete'), 403);

        $pengaduan->delete();

        return redirect()->route('pengaduans.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }

    private function authorizePengaduanAccess(Pengaduan $pengaduan): void
    {
        abort_unless(
            auth()->user()->can('pengaduan.view.all')
                || $pengaduan->email === auth()->user()->email,
            403
        );
    }
}
