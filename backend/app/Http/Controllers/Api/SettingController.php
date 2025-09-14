<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::where('user_id', Auth::id())->pluck('value', 'key');

        return response()->json($settings);
    }

    /**
     * Обновить или создать настройки текущего пользователя.
     */
    public function update(Request $request)
    {
        $userId = Auth::id();
        $data = $request->all();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['user_id' => $userId, 'key' => $key],
                ['value' => $value]
            );
        }

        $updated = Setting::where('user_id', $userId)->pluck('value', 'key');

        return response()->json($updated);
    }
}
