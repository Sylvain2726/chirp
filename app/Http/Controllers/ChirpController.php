<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ChirpController extends Controller
{

    public function index() : View

    {

        return view('chips.index' , ['chirps'=>Chirp::with('user')->latest()->get()]);
    }

    /**
     * Montrer le formulaire de créaion.
     */
    public function create()
    {
        //
    }

    /**
     * Enregistrer les donnée du formulaire.
     */
    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            "message"=>'required|string|max:255'
        ]);

        $request->user()->chirps()->create($validated);
        return redirect(route('chirps.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        Gate::authorize('update', $chirp);

        return view('chips.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        Gate::authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
    }
}
