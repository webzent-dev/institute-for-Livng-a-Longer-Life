<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ContentManagement::updateOrCreate(
            ['page_name' => 'home_page'],
            [
                'page_content' => '<span class="px-3 py-1 rounded-full text-sm font-semibold bg-amber-500">WELCOME TO</span>

<h1 class=" text-3xl md:text-4xl lg:text-5xl font-semibold tracking-wide">
    <br class="hidden sm:block">
    <span class="font-bold">THE INSTITUTE FOR LIVING A LONGER LIFE</span>
</h1>
<p class="mt-4 text-gray-600 max-w-2xl mx-auto">Congratulations! This is your first step to living a longer healthier life.</p>'
            ]
        );

        \App\Models\ContentManagement::updateOrCreate(
            ['page_name' => 'collaborator_page'],
            [
                'page_content' => '<div class="lg:px-8 max-w-7xl mx-auto px-4 sm:px-6 text-center">
    <h1 class="font-bold lg:text-6xl mb-6 text-4xl text-foreground">Our Expert Collaborators</h1>
    <p class="max-w-3xl mx-auto text-muted-foreground text-xl">Learn from a network of world-class physicians and health practitioners, each bringing specialized expertise to your wellness journey. Access their exclusive courses and recommended products.</p>
</div>'
            ]
        );
    }
}
