<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => [
                'site_title' => Setting::get('site_title', config('app.name')),
                'tagline' => Setting::get('tagline', 'Just another WordPress site'),
                'description' => Setting::get('description', ''),
                'footer_text' => Setting::get('footer_text', ''),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_title' => ['required', 'string', 'max:80'],
            'tagline' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:255'],
            'footer_text' => ['nullable', 'string', 'max:120'],
        ]);

        foreach ($validated as $key => $value) {
            Setting::put($key, $value);
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Settings saved.');
    }
}
