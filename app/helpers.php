<?php

use App\Models\Advertisement;
use App\Models\Menu;

if (!function_exists('getMenus')) {
    /**
     * Get active menus ordered by sort_order
     */
    function getMenus()
    {
        try {
            return Menu::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        } catch (\Exception $e) {
            return collect();
        }
    }
}

if (!function_exists('renderAdSlot')) {
    /**
     * Render an advertisement slot
     */
    function renderAdSlot($placementKey, $class = '')
    {
        try {
            $ad = Advertisement::where('status', true)
                ->where('placement_key', $placementKey)
                ->where(function ($query) {
                    $query->whereNull('start_date')->orWhere('start_date', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('end_date')->orWhere('end_date', '>=', now());
                })
                ->first();

            if (!$ad) {
                return ''; // Return empty string if no ad found
            }

            // Increment views (optional, could be done via AJAX for better accuracy)
            // $ad->increment('views');

            $html = '<div class="ad-slot-wrapper ' . $class . '">';

            if ($ad->type === 'image') {
                $html .= '<a href="' . ($ad->redirect_url ?? '#') . '" target="_blank" rel="noopener noreferrer">';
                $html .= '<img src="' . asset($ad->image_path) . '" alt="' . e($ad->title) . '" class="img-fluid rounded">';
                $html .= '</a>';
            } elseif ($ad->type === 'code') {
                $html .= $ad->script_code;
            }

            $html .= '</div>';

            return $html;
        } catch (\Exception $e) {
            return '';
        }
    }
}

if (!function_exists('toBengaliNumber')) {
    /**
     * Convert English numbers to Bengali digits
     */
    function toBengaliNumber($number)
    {
        $en_num = ['0','1','2','3','4','5','6','7','8','9'];
        $bn_num = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        return str_replace($en_num, $bn_num, $number);
    }
}

