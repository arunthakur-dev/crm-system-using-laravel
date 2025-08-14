<?php

use Illuminate\Support\Facades\URL;

function avatarLink($item, $displayValue, $routeName, $initialField = null)
{
    $initial = $initialField
        ? strtoupper(substr($item->{$initialField}, 0, 1))
        : strtoupper(substr($displayValue, 0, 1));

    $route = route($routeName, $item->id);

    return <<<HTML
    <div class="flex items-center space-x-3">
        <div class="w-8 h-8 bg-blue-500 text-white flex items-center justify-center rounded-full font-bold uppercase">
            $initial
        </div>
        <a href="$route" class="text-blue-600 font-semibold hover:underline">
            $displayValue
        </a>
    </div>
    HTML;
}



