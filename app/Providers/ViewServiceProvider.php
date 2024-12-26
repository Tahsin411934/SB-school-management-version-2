<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        View::composer('*', function ($view) {
            $categories = Category::all();
            $view->with('categories', $categories);
        });
        // View::composer('*', function ($view) {
        //     $user = Auth::user();

        //     if ($user) {
        //         $transaction = Transaction::where('user_id', $user->id)->with('product')->get();
        //     } else {
        //         $transaction = collect();
        //     }
        //     $view->with('transaction', $transaction);
        // });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}