<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;

use App\Models\AlertModel;
use App\Models\AlertSignatureModel;

class DashboardController extends Controller
{
    public function getAlerts()
    {
        try {
            return AlertModel::all()->load([
                'author',
                'signatures.user',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao carregar os avisos para a equipe',
            ]);
        }
    }

    public function createSignature(Request $request, $alertIdentifier)
    {
        try {
            $alert = AlertModel::findOrFail($alertIdentifier);

            AlertSignatureModel::create([
                'user_id' => $request->user()->id,
                'alert_id' => $alert->id,
            ]);

            return redirect()->back()->with('flash', [
                'type' => 'success',
                'message' => 'Você confirmou que leu o aviso',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('flash', [
                'type' => 'error',
                'message' => 'Erro ao confirmar leitura do aviso',
            ]);
        }
    }

    public function render()
    {
        return Inertia::render('Admin/Dashboard', [
            'alerts' => $this->getAlerts(),
        ]);
    }
}
