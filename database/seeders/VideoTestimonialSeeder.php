<?php

namespace Database\Seeders;
use App\Models\VideoTestimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoTestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VideoTestimonial::insert([
            [
                'video_url' => 'https://vimeo.com/1089873165',
                'thumbnail' => 'https://instituteforlivinglonger.com/wp-content/uploads/2025/09/12.png',
                'quote' => 'The videos really helped me a lot..',
                'name' => 'Sarah M.',
                'sort_order' => 1,
            ],
            [
                'video_url' => 'https://vimeo.com/1089872998',
                'thumbnail' => 'https://instituteforlivinglonger.com/wp-content/uploads/2025/09/13.png',
                'quote' => 'Loved the videos..',
                'name' => 'Michael R.',
                'sort_order' => 2,
            ],
            [
                'video_url' => 'https://vimeo.com/1089872688',
                'thumbnail' => 'https://instituteforlivinglonger.com/wp-content/uploads/2025/09/14.png',
                'quote' => 'IT CHANGED MY LIFE..',
                'name' => 'Jennifer P.',
                'sort_order' => 3,
            ],
        ]);
    }
}
