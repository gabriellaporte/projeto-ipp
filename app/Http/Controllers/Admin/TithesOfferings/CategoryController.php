<?php

namespace App\Http\Controllers\Admin\TithesOfferings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\TithesOfferings\TitheOfferingType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = TitheOfferingType::orderBy('id', 'asc')->paginate(10);

        return view('content.admin.tithes_offerings.categories', compact('categories'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        TitheOfferingType::create($request->validated());

        return back()->withSuccess('Você criou a categoria ' . $request->type_name . ' com sucesso!');
    }

    public function update(TitheOfferingType $category, StoreCategoryRequest $request): RedirectResponse
    {
        $category->update($request->validated());

        return back()->withSuccess('Você editou a categoria ' . $request->type_name . ' com sucesso!');
    }

    public function delete(TitheOfferingType $category): RedirectResponse
    {
        $category->delete();

        return back()->withSuccess('Você deletou a categoria ' . $category->type_name . '!');
    }
}
