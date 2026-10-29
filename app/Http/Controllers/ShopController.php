<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;


class ShopController extends Controller
{

public function index(Request $request)
{
    $categories = Category::orderBy('name')->get();
    $sort = $request->query('sort', 'newest');

    $products = Products::published()
    ->with('category')
    ->when($request->query('q'), fn ($query, $term) => $query->where('name', 'ilike', '%'. $term. '%'))
    ->
    ->
    ->
    ->
    ->
    ->
    ->
    ->
    ->
    ->
}
}