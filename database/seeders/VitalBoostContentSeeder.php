<?php

namespace Database\Seeders;

use App\Models\VitalBoostContent;
use Illuminate\Database\Seeder;

/**
 * Default copy for the Vital Boost page, taken from
 * "Institute For Living Longer Homepage.docx" (Vital Boost Page section).
 *
 * Re-running this is safe: it updates the section rows in place and leaves
 * any sections an admin has added alone.
 */
class VitalBoostContentSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->sections() as $section) {
            VitalBoostContent::updateOrCreate(
                ['section_key' => $section['section_key']],
                $section
            );
        }
    }

    private function sections(): array
    {
        return [
            [
                'section_key' => 'hero',
                'sort_order'  => 1,
                'status'      => 'active',
                'heading'     => 'Vital Boost',
                'subheading'  => 'The finest supplement for the way we live today',
                'body'        => 'Premium wellness formula designed to support your daily health and longevity needs.',
                'items'       => [],
                'meta'        => [
                    'badge_text'  => 'Premium Wellness Formula',
                    'note'        => 'Originally formulated to protect patients from harmful effects of dental radiation, now protects you from everyday electromagnetic radiation from computers, cell phones, and other hi-tech devices.',
                    'cta_label'   => 'Order Now',
                ],
            ],
            [
                'section_key' => 'benefits',
                'sort_order'  => 2,
                'status'      => 'active',
                'heading'     => 'What Makes Vital Boost Different',
                'subheading'  => null,
                'body'        => 'Both stress and emotions may prevent you from living happily, too. There is one more thing that we usually ignore: malnutrition. The reality is that we don\'t provide ourselves with enough nutrition that can help us cope with all our everyday tasks. You can\'t lead a happy life if you don\'t feel good. And you can\'t feel good without proper nutrition. That\'s exactly where Vital Boost comes in and helps you.',
                'items'       => [
                    [
                        'icon'        => 'heart',
                        'title'       => 'Rich in Vitamins and Minerals',
                        'description' => 'Boosts healthy functioning of the heart and helps in maintaining optimum blood flow in your body.',
                    ],
                    [
                        'icon'        => 'brain',
                        'title'       => 'Health All Around',
                        'description' => 'Experience an increase in your energy levels daily. Metabolism, digestion, and immunity will work well for you.',
                    ],
                    [
                        'icon'        => 'shield',
                        'title'       => 'Science Behind It',
                        'description' => 'Developed by experts to cater to the hectic lifestyles of today\'s generation and provide complete nutrition to your body.',
                    ],
                    [
                        'icon'        => 'trending-up',
                        'title'       => 'Economical and Efficient Wellness',
                        'description' => 'Get one solution that saves you money as well as provides you with all the essential nutrients in one single capsule.',
                    ],
                    [
                        'icon'        => 'zap',
                        'title'       => 'Tailored to Your Lifestyles',
                        'description' => 'Developed specifically to help your body combat all the stressors of today\'s technological world.',
                    ],
                    [
                        'icon'        => 'users',
                        'title'       => 'Experience Life to the Fullest',
                        'description' => 'Experience a boost in your energy levels, as well as experience wellness throughout your life.',
                    ],
                ],
                'meta'        => [],
            ],
            [
                'section_key' => 'booster',
                'sort_order'  => 3,
                'status'      => 'active',
                'heading'     => 'Vital Boost — Immune System Booster',
                'subheading'  => 'Life is full of options in the modern world. Some are beneficial to our well-being, while some others are actually working against it. Everybody wants to live an energetic and happy life, but we may not be doing everything right.',
                'body'        => "Several external factors prevent us from being healthy. Such as stress, pollution, nutrition, and constant exposure to technologies. Cell phones, computer systems, microwaves, and any other appliances also belong to this category. They have an effect on our bodies slowly and unnoticeably to us.\n\nVital Boost was created by Dr. Zeines, DDS. He designed it to protect his patients from the effects of dental X-rays. Over time, he expanded the formula. Today, it is designed to help support your body against everyday electromagnetic exposure, from wireless devices to daily tech use.\n\nSome research proves now that even minimal magnetic fields might affect our DNA and cell work.",
                'items'       => [
                    'facts' => [
                        'The number of sperm cells is going down, and cancer cases are going up.',
                        'Our lifespan is getting longer, and the quality of our lives has greatly diminished.',
                        'There are more individuals suffering from chronic pain, exhaustion, and compromised immune systems than ever before.',
                    ],
                    'ingredients' => [
                        'Vitamin C 1000 mg',
                        'Vit B1 (Thymine) 3.15mg',
                        'Vit B2 (riboflavin) 3.06mg',
                        'Vit B3 (niacinamide) 20mg',
                        'Vit B5 (Calcium pantothenate) 10mg',
                        'Vit B6 (pyridoxine 10mg)',
                        'Vit B12 (hydroxyl cobalamin 5 mcg)',
                        'Biotin 315mcg',
                        'Folic acid 800mcg',
                        'Vit A (entire carotene complex) 3,334 IU',
                        'Vit E (d-alpha tocopherol succinate) 100iu',
                        'Lipoic Acid 2mg',
                        'Coenzyme Q10 50mg',
                        'Selenium (Se-Methyselenocysteine) 9.8mcg',
                        'Zinc (methionate and succinate) 36 mg',
                        'Iodine (potassium iodide) 100mcg',
                        'Copper 1mg',
                        'Chromium (picolinate) 96mcg',
                        'Potassium (bicarbonate) 250mg',
                        'Molybdenum 80mcg',
                        'Manganese (gluconate) 4mg',
                        'Magnesium (citrate, Aspartate, glycinate, ascorbate) 192mg',
                        'L-Lysine 250mg',
                        'L-cysteine 250mg',
                        'L-methionine 250mg',
                        'Taurine 250mg',
                        'Choline complex',
                    ],
                ],
                'meta'        => [
                    'ingredients_heading' => 'Premium Ingredients',
                ],
            ],
            [
                'section_key' => 'usage',
                'sort_order'  => 4,
                'status'      => 'active',
                'heading'     => 'Your Daily Vital Boost Routine',
                'subheading'  => null,
                'body'        => null,
                'items'       => [
                    'stats' => [
                        ['value' => '1',    'label' => 'Packet',     'sub' => 'daily'],
                        ['value' => 'Mix',  'label' => 'Into a Drink', 'sub' => 'smoothie or juice'],
                        ['value' => '30',   'label' => 'Day Supply', 'sub' => 'per box'],
                    ],
                    'steps' => [
                        'Add one package to your morning smoothie or juice and stir.',
                        'In the powdered form, absorption is much easier compared to tablets or capsules.',
                        'It is made from pure and concentrated nutrients without any fillers or binders.',
                        'Consistent daily intake gives maximum benefits.',
                    ],
                    'powder_points' => [
                        'Better absorbed by your body than pills.',
                        'Higher concentration of nutrients per serving.',
                        'More cost-effective than juggling multiple pill supplements.',
                        'Supports faster recovery from stress and daily demands.',
                    ],
                ],
                'meta'        => [
                    'steps_heading'  => 'Simple Steps to Follow:',
                    'powder_heading' => 'Why Powder Beats Pills?',
                    'powder_intro'   => 'Vital Boost skips the pill and the capsule entirely. It\'s a daily powdered drink mix, built fresh for your body\'s needs.',
                ],
            ],
            [
                'section_key' => 'cta',
                'sort_order'  => 5,
                'status'      => 'active',
                'heading'     => 'Begin Your Path to Vitality',
                'subheading'  => 'Join the many members who\'ve made Vital Boost part of their daily routine.',
                'body'        => null,
                'items'       => [],
                'meta'        => [
                    'price_one_time'       => '$79.99',
                    'price_one_time_label' => 'One-time purchase',
                    'price_subscription'   => '$67.99',
                    'price_subscription_label' => 'Subscribe & Save 15%',
                    'cta_label'            => 'Explore Membership',
                    'footer_note'          => 'Members enjoy additional discounts. Free shipping on orders over $50.',
                ],
            ],
        ];
    }
}
