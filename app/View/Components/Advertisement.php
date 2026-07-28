<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Advertisement as AdModel;

class Advertisement extends Component
{
    public $placement;
    public $ads;
    public $class;

    /**
     * Create a new component instance.
     */
    public function __construct($placement, $ads = null, $class = '')
    {
        $this->placement = $placement;
        $this->ads = $ads;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->ads && isset($this->ads[$this->placement])) {
            $ad = $this->ads[$this->placement]->random();
        } elseif (!$this->ads) {
            $ad = AdModel::active()->where('placement_key', $this->placement)->inRandomOrder()->first();
        } else {
            $ad = null;
        }

        if (!$ad) {
            return '';
        }

        return view('components.advertisement', compact('ad'));
    }
}

