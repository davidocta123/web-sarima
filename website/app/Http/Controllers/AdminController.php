<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\SarimaApiService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    protected $sarimaService;

    public function __construct(SarimaApiService $sarimaService)
    {
        $this->sarimaService = $sarimaService;
    }

    public function dashboard()
    {
        $stats = $this->sarimaService->getStats();
        $modelInfo = $this->sarimaService->getModelInfo();
        $historical = $this->sarimaService->getHistoricalMonthly();
        $usersCount = User::count();
        
        $data = [
            'total_visitors' => $stats['data']['total_visitors'] ?? 0,
            'peak_month' => $stats['data']['max_month'] ?? '-',
            'metrics' => $modelInfo['data']['metrics'] ?? null,
            'users_count' => $usersCount,
            'status' => $stats['success'] ?? false,
            'historical' => $historical['data'] ?? []
        ];

        return view('admin.dashboard', compact('data'));
    }

    public function dataInput()
    {
        $apiInfo = $this->sarimaService->getDatasetInfo();
        
        $datasets = [
            [
                'id' => 1,
                'filename' => $apiInfo['filename'] ?? 'Drafting Data Bunihayu Rev.csv',
                'uploaded_at' => $apiInfo['last_updated'] ?? '-',
                'status' => ($apiInfo['exists'] ?? false) ? 'Active' : 'Missing',
                'rows' => $apiInfo['rows'] ?? 0
            ]
        ];

        return view('admin.data-input', compact('datasets'));
    }

    public function modelSettings()
    {
        $modelInfo = $this->sarimaService->getModelInfo();
        return view('admin.model-settings', compact('modelInfo'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function retrainModel(Request $request)
    {
        $result = $this->sarimaService->retrain();
        
        if ($result['success']) {
            return redirect()->back()->with('success', 'Model SARIMA berhasil di-retrain! Akurasi terbaru: ' . ($result['metrics']['quality'] ?? 'N/A'));
        }

        return redirect()->back()->with('error', 'Gagal melakukan retrain: ' . ($result['error'] ?? 'Unknown error'));
    }

    public function uploadDataset(Request $request)
    {
        $request->validate([
            'dataset' => 'required|file|mimes:csv,txt'
        ]);

        try {
            $result = $this->sarimaService->uploadDataset($request->file('dataset'));
            
            if ($result['success']) {
                return redirect()->back()->with('success', 'Dataset berhasil diupload ke server API! Silakan klik Retrain Model.');
            }
            
            return redirect()->back()->with('error', 'Gagal upload dataset: ' . ($result['error'] ?? 'Unknown error'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal upload dataset: ' . $e->getMessage());
        }
    }

    public function storeManualData(Request $request)
    {
        $request->validate([
            'tahun' => 'required|numeric',
            'bulan' => 'required|string',
            'minggu' => 'required|numeric|between:1,5',
            'ktm' => 'required|numeric',
            'glamping' => 'required|numeric',
        ]);

        $data = [
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'minggu' => $request->minggu,
            'ktm' => $request->ktm,
            'glamping' => $request->glamping,
            'total' => $request->ktm + $request->glamping
        ];

        try {
            $result = $this->sarimaService->addManualData($data);
            
            if ($result['success']) {
                return redirect()->back()->with('success', 'Data manual berhasil dikirim ke server API! Silakan klik Retrain Model.');
            }
            
            return redirect()->back()->with('error', 'Gagal menambah data: ' . ($result['error'] ?? 'Unknown error'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambah data: ' . $e->getMessage());
        }
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user',
        ]);

        return redirect()->back()->with('success', 'User added successfully');
    }
}