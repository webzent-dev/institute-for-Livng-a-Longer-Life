<?php

namespace Database\Seeders;
use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Testimonial::insert([
    [
        'name' => 'Margaret Thompson',
        'age' => 68,
        'location' => 'Boston, MA',
        'rating' => 5,
        'quote' => "After just 6 months with the Institute, my energy levels have increased dramatically. Dr. Zeines' approach to wellness has truly transformed my life. I feel 20 years younger!",
        'result' => 'Lost 25 lbs, improved mobility',
        'sort_order' => 1,
    ],
    [
        'name' => 'Robert Chen',
        'age' => 54,
        'location' => 'San Francisco, CA',
        'rating' => 5,
        'quote' => "The collaborator network is incredible. I've learned so much from Dr. Rodriguez about fitness and Dr. Chen about nutrition. My blood work has improved remarkably.",
        'result' => 'Reversed pre-diabetes',
        'sort_order' => 2,
    ],
    [
        'name' => 'Linda Martinez',
        'age' => 62,
        'location' => 'Miami, FL',
        'rating' => 5,
        'quote' => "As a Premium member, I have access to such valuable content. The live Q&A sessions are my favorite - getting direct answers from experts is priceless.",
        'result' => 'Better sleep, reduced stress',
        'sort_order' => 3,
    ],
    [
        'name' => 'James Wilson',
        'age' => 71,
        'location' => 'Chicago, IL',
        'rating' => 5,
        'quote' => "I was skeptical at first, but the science-based approach won me over. Dr. Zeines and his team provide clear, actionable advice that actually works.",
        'result' => 'Improved heart health markers',
        'sort_order' => 4,
    ],
    [
        'name' => 'Patricia Davis',
        'age' => 59,
        'location' => 'Seattle, WA',
        'rating' => 5,
        'quote' => "The community support is amazing. I've made friends from all over the country who share the same wellness goals. We motivate each other daily.",
        'result' => 'Consistent exercise routine',
        'sort_order' => 5,
    ],
    [
        'name' => 'Michael Rodriguez',
        'age' => 66,
        'location' => 'Denver, CO',
        'rating' => 5,
        'quote' => "Elite membership was the best investment I've made in my health. The personalized consultations have helped me optimize my wellness plan perfectly.",
        'result' => 'Enhanced cognitive function',
        'sort_order' => 6,
    ],
    [
        'name' => 'Susan Anderson',
        'age' => 57,
        'location' => 'Austin, TX',
        'rating' => 5,
        'quote' => "The video lessons are so well-produced and easy to understand. I love learning at my own pace and revisiting the content whenever I need a refresher.",
        'result' => 'Better nutrition habits',
        'sort_order' => 7,
    ],
    [
        'name' => 'David Park',
        'age' => 63,
        'location' => 'Portland, OR',
        'rating' => 5,
        'quote' => "Dr. Zeines' holistic approach addresses the whole person, not just symptoms. This is the healthcare model of the future, and I'm grateful to be part of it.",
        'result' => 'Reduced inflammation',
        'sort_order' => 8,
    ],
    [
        'name' => 'Carol Williams',
        'age' => 69,
        'location' => 'Phoenix, AZ',
        'rating' => 5,
        'quote' => "The store products recommended by the collaborators are top-quality. I especially love the Vital Boost supplement - it's become a staple in my daily routine.",
        'result' => 'Increased vitality',
        'sort_order' => 9,
    ],
]);
}
}
