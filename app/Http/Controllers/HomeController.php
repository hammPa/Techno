<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        $category = $request->query('category');

        $muaList = User::query()
            ->where('role', 'mua')
            ->whereNotNull('email_verified_at')
            ->whereHas('muaProfile', function ($query) {
                $query->where('verification_status', 'verified');
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhereHas('muaProfile', function ($qp) use ($search) {
                          $qp->where('studio_name', 'like', "%{$search}%")
                             ->orWhere('city', 'like', "%{$search}%");
                      });
                });
            })
            ->when($category, function ($query, $category) {
                $query->whereHas('services', function ($q) use ($category) {
                    $q->where('category', $category);
                });
            })
            // Optimasi Eager Loading: jangan load semua portofolio jika hanya butuh thumbnail di card
            ->with([
                'muaProfile',
                'services:id,user_id,name,price,category',
                'portfolios' => function ($q) {
                    $q->latest()->take(3); // Ambil 3 portofolio teratas saja per MUA
                },
            ])
            ->withCount('muaReviews')
            ->withAvg('muaReviews', 'rating')
            ->latest()
            ->take(9)
            ->get();

        return view('welcome', compact('muaList', 'search', 'category'));
    }
}