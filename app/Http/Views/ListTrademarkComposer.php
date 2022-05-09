<?php


namespace App\Http\Views;


use App\Models\Trademark;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ListTrademarkComposer
{
    public function compose(View $view)
    {
        $listTrademarks = Cache::remember('listTrademarks', 60, function() {
            return Trademark::all();
        });

        $view->with([
            'trademarks' => $listTrademarks
        ]);
    }
}
