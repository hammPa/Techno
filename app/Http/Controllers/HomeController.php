<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->query('q');
        $category = $request->query('category');
        $city     = $request->query('city');

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
                          $qp->where('studio_name', 'like', "%{$search}%");
                      });
                });
            })
            ->when($city, function ($query, $city) {
                $query->whereHas('muaProfile', function ($q) use ($city) {
                    $q->where('city', 'like', "%{$city}%");
                });
            })
            ->when($category, function ($query, $category) {
                $query->whereHas('services', function ($q) use ($category) {
                    $q->where('category', $category);
                });
            })
            ->with(['muaProfile', 'services', 'portfolios'])
            ->withCount('muaReviews')
            ->withAvg('muaReviews', 'rating')
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('welcome', compact('muaList', 'search', 'category', 'city'));
    }
}