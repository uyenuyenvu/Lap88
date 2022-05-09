<?php


namespace App\Http\Views;


use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ListCategoryComposer
{
    public function compose(View $view)
    {
        $listCategories = Cache::remember('listCategories', 60, function() {
            return Category::all();
        });

        $view->with([
            'categories' => $listCategories
        ]);
    }
}
