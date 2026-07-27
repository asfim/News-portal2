<?php

namespace App\View\Components;

use App\Models\News;
use Illuminate\View\Component;

class NewsThumbnail extends Component
{
    public $news;
    public $type;
    public $url;
    public $alt;
    public $classes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(News $news, $classes = 'object-fit-cover w-100 h-100')
    {
        $this->news = $news;
        $this->classes = $classes;
        $this->alt = $news->title;
        $this->determineDisplay();
    }

    protected function determineDisplay()
    {
        if ($this->news->thumbnailImage) {
            $this->type = 'image';
            $this->url = $this->news->thumbnailImage->path;
            return;
        }

        if ($this->news->featuredImage) {
            $this->type = 'image';
            $this->url = $this->news->featuredImage->path;
            return;
        }

        if ($this->news->video_url) {
            if (str_starts_with($this->news->video_url, '/storage/')) {
                $this->type = 'video';
                $this->url = asset($this->news->video_url) . '#t=0.5';
                return;
            }

            // YouTube
            $videoId = '';
            if (str_contains($this->news->video_url, 'v=')) {
                parse_str(parse_url($this->news->video_url, PHP_URL_QUERY), $vars);
                $videoId = $vars['v'] ?? '';
            } elseif (str_contains($this->news->video_url, 'youtu.be/')) {
                $videoId = basename(parse_url($this->news->video_url, PHP_URL_PATH));
            }

            if ($videoId) {
                $this->type = 'image';
                $this->url = "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
                return;
            }
        }

        // Fallback
        $this->type = 'image';
        $this->url = 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?q=80&w=400&auto=format&fit=crop';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.news-thumbnail');
    }
}
