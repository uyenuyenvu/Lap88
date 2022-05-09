<?php


namespace App\Http\Views;


use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MenuCategoryComposer
{
    public function compose(View $view)
    {
        $menus = Cache::remember('menuCategories', 60, function() {
            return Category::where('parent_id', 0)->get();
        });

        $menus = $this->getCategoryWithChild($menus);

        $view->with([
            'menus' => $menus
        ]);
    }

    private function getCategoryWithChild($categories){
        foreach ($categories as $category) {
            $children = Category::where('parent_id', $category->id)->get();

            if (count($children)>0){
                $category->children = $this->getCategoryWithChild($children);
            }
        }

        return $categories;
    }
}
