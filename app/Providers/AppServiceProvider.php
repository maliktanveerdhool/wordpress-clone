<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $settings = once(fn () => [
                'siteTitle' => Setting::get('site_title', config('app.name')),
                'siteTagline' => Setting::get('tagline', 'Just another WordPress site'),
                'siteDescription' => Setting::get('description', ''),
                'footerText' => Setting::get('footer_text', ''),
            ]);

            $view->with($settings);
        });

        View::composer(['partials.site-header', 'partials.site-footer'], function ($view) {
            $view->with([
                'navCategories' => Category::withCount(['posts' => fn ($query) => $query->published()])
                    ->orderBy('name')
                    ->get(),
                'navPages' => Page::where('status', 'published')->orderBy('title')->get(),
            ]);
        });

        View::composer('partials.admin.sidebar', function ($view) {
            $view->with('pendingComments', \App\Models\Comment::pending()->count());
        });
    }
}
