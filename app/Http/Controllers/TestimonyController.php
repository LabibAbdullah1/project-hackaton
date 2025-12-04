<?php

namespace App\Http\Controllers;

use App\Models\Testimony;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonyController extends Controller
{
    public function index()
    {
        $testimonies = Testimony::with('user')->paginate(10);
        return view('testimonies.index', compact('testimonies'));
    }

    public function create()
    {
        return view('testimonies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        Testimony::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'rating' => $request->rating ?? null,
        ]);

        return redirect()->route('testimonies.index')->with('success', 'Testimoni berhasil dikirim!');
    }

    public function show(Testimony $testimony)
    {
        return view('testimonies.show', compact('testimony'));
    }

    public function edit(Testimony $testimony)
    {
        return view('testimonies.edit', compact('testimony'));
    }

    public function update(Request $request, Testimony $testimony)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $testimony->update($request->all());

        return redirect()->route('testimonies.index')->with('success', 'Testimoni berhasil diperbarui!');
    }

    public function destroy(Testimony $testimony)
    {
        $testimony->delete();

        return redirect()->route('testimonies.index')->with('success', 'Testimoni berhasil dihapus!');
    }
}
