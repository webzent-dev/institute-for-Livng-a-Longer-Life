<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;    

class VitalBoostController extends Controller
{
    public function index()
    {
        return view('front.pages.vital-boost');
    }
    public function benifits()
    {
        $benefits = [
            [
                'icon' => 'chart', // use icon name or svg key
                'title' => 'NUTRIENT-RICH',
                'description' => 'With everything from antioxidants and digestive enzymes to probiotics and herbal extracts, it\'s a complete nutritional toolkit.',
            ],
            [
                'icon' => 'stethoscope',
                'title' => 'HEALTH BENEFITS GALORE',
                'description' => 'Experience increased energy, improved metabolism, better digestion, and a stronger immune system.',
            ],
            [
                'icon' => 'heart-hand',
                'title' => 'SCIENCE-BACKED',
                'description' => 'Formulated by experts, it\'s designed to meet the demands of a hectic lifestyle while providing comprehensive nutritional support. Your Daily Dose of Wellness.',
            ],
            [
                'icon' => 'wallet',
                'title' => 'ECONOMICAL CHOICE',
                'description' => 'Save on supplements with this all-in-one solution that\'s easy on your wallet.',
            ],
            [
                'icon' => 'shield',
                'title' => 'COMBAT MODERN DAY CHALLENGES',
                'description' => 'From stress and pollution to the effects of electromagnetic radiation, Vital Boost is your shield against everyday health hazards.',
            ],
            [
                'icon' => 'health-plus',
                'title' => 'A QUALITY LIFE AWAITS',
                'description' => 'Notice the difference in your energy levels, vitality, and overall well-being as you make Vital Boost a part of your daily routine.',
            ],
        ];

        return view('front.pages.vital-boost', compact('benefits'));
    }
}