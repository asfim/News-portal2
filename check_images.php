<?php
$n = \App\Models\News::with('featuredImage','thumbnailImage')->first();
echo 'featured_image ID: ' . $n->featured_image . PHP_EOL;
echo 'thumbnail ID: ' . $n->thumbnail . PHP_EOL;
if($n->featuredImage) {
    echo 'featuredImage path: ' . $n->featuredImage->path . PHP_EOL;
} else {
    echo 'featuredImage: NULL' . PHP_EOL;
}
if($n->thumbnailImage) {
    echo 'thumbnailImage path: ' . $n->thumbnailImage->path . PHP_EOL;
} else {
    echo 'thumbnailImage: NULL' . PHP_EOL;
}

// Check total news and how many have images
$total = \App\Models\News::count();
$withImg = \App\Models\News::whereNotNull('featured_image')->count();
echo "Total news: $total, With featured_image: $withImg" . PHP_EOL;

// Check total media
$mediaCount = \App\Models\Media::count();
echo "Total media records: $mediaCount" . PHP_EOL;

// Check a media record
$m = \App\Models\Media::first();
if ($m) {
    echo "First media - name: {$m->name}, path: {$m->path}" . PHP_EOL;
}
