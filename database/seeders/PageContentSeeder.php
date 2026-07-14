<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

/**
 * Default copy for the section-based CMS pages, taken from
 * "Institute For Living Longer Homepage.docx".
 *
 * Re-running this is safe: it updates the section rows in place and leaves any
 * sections an admin has edited beyond these keys alone. The Home page and the
 * Vital Boost page are seeded elsewhere.
 */
class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->pages() as $pageKey => $sections) {
            $sortOrder = 0;

            foreach ($sections as $sectionKey => $section) {
                $sortOrder++;

                PageContent::updateOrCreate(
                    ['page_key' => $pageKey, 'section_key' => $sectionKey],
                    array_merge([
                        'heading'    => null,
                        'subheading' => null,
                        'body'       => null,
                        'items'      => [],
                        'meta'       => [],
                        'status'     => 'active',
                        'sort_order' => $sortOrder,
                    ], $section)
                );
            }
        }
    }

    private function pages(): array
    {
        return [
            // Home copy follows the docx Homepage section. The layout keeps its existing
            // design; only the wording is the doc's.
            'home' => [
                'hero' => [
                    'heading'    => 'The Science of Living Well, Made Simple',
                    'subheading' => 'Clear health education for real life and better living.',
                    'body'       => 'In matters concerning your health, speculation takes time, effort, and progress. We provide you with all that you need through our classes and monthly expert sessions to help you build a healthy life.',
                    'meta'       => [
                        'eyebrow'         => 'Welcome To',
                        'primary_label'   => 'Join The Community',
                        'secondary_label' => 'View Intro Videos',
                    ],
                ],
                'intro' => [
                    'heading' => 'Begin Your Journey to Lifelong Wellness',
                    'body'    => 'Real change starts with the right knowledge and the right people around you. Our community brings together evidence-based guidance and expert support to help you build habits that truly last, for life.',
                    'meta'    => [
                        'eyebrow'         => 'STEP INTO THE INSTITUTE FOR LIVING LONGER',
                        'primary_label'   => 'Start Your Journey',
                        'secondary_label' => 'Meet Your Guide',
                    ],
                ],
                'membership' => [
                    'heading'    => 'Choose Your Membership',
                    'subheading' => 'Select the plan that best fits your wellness goals',
                ],
                'intro_video' => [
                    'heading' => 'Get a quick look inside',
                    'items'   => [
                        'cards' => [
                            ['icon' => 'message-circle', 'title' => 'Ask Us Anything',           'description' => 'Take part in our exclusive monthly Q&A sessions, where you can ask your questions directly and receive clear, personal answers about the course.'],
                            ['icon' => 'sparkles',       'title' => 'Fresh Expert Perspectives', 'description' => 'Each session welcomes a guest speaker who adds fresh, expert insight, making every class richer and more valuable.'],
                            ['icon' => 'users',          'title' => 'Connect & Grow Together',   'description' => 'These sessions go beyond learning. They are a chance to connect with fellow members and enjoy the journey toward better health together.'],
                        ],
                    ],
                    'meta' => [
                        'video_url'       => 'https://player.vimeo.com/video/817940268?h=5e53563',
                        'video_label'     => 'DR. VICTOR ZEINES',
                        'video_title'     => 'HEALTHY LIFE VIDEO',
                        'signature_intro' => 'We hope to see you soon',
                        'signature'       => 'Wishing you health and happiness, Victor Zeines',
                    ],
                ],
                'community' => [
                    'heading' => 'Join a Community Built for a Longer, Healthier Life',
                    'body'    => 'Curious to learn more? Join our community and get full access to our complete collection of videos and resources, all built to support your path to better health.',
                    'items'   => [
                        'blocks' => [
                            ['title' => 'Comprehensive Health Information', 'description' => 'Get exclusive information about many different body functions and various health aspects.'],
                            ['title' => 'Flexible Learning',                'description' => 'The lectures are divided into small, manageable parts that make learning easy.'],
                            ['title' => 'Regular Updates',                  'description' => 'Our regularly updated lectures by guest speakers will keep you up-to-date about new health trends. Some of our lecture topics include:'],
                        ],
                        'topics' => [
                            'Periodontal Disease Explained',
                            'Herbology Basics',
                            'Root Canal Safety Facts',
                            'Preventing and Understanding Cancer',
                            'Why Acupuncture Works',
                            'Understanding Immunology',
                            'Kinesiology Explained',
                            'Managing Mercury Toxicity',
                            'Magnet Therapy and Essential Oils',
                            'Fluoride Exposure Awareness',
                            'Lifelong Nutrition',
                            'Understanding TMJ Disorders',
                            'Color Therapy Explained',
                            'Stem Cell Science and Possibilities',
                        ],
                    ],
                    'meta' => [
                        'primary_label'   => 'Join Us Today',
                        'secondary_label' => 'Preview Our Videos',
                    ],
                ],
                'vital_boost' => [
                    'items' => [
                        'cards' => [
                            ['icon' => 'leaf',     'title' => 'A Superfood Symphony',    'description' => 'Packed with organic spirulina, barley grass, wheat grass, spinach, and more, Vital Boost is a symphony of superfoods.'],
                            ['icon' => 'sparkles', 'title' => 'Easy to Use',             'description' => 'Just mix it into your smoothie or juice for a tasty, nutritious start to your day.'],
                            ['icon' => 'pill',     'title' => 'More Than a Multivitamin','description' => 'Say goodbye to your old multivitamins. Vital Boost offers a more complete and potent nutritional profile.'],
                            ['icon' => 'award',    'title' => 'Doctor-Approved',         'description' => 'Developed with insights from years of medical experience and research.'],
                        ],
                    ],
                    'meta' => [
                        'badge'     => '** Unlock the Power of Vital Boost **',
                        'cta_label' => 'Learn More',
                    ],
                ],
                'testimonials' => [
                    'heading' => 'What Our Members Say',
                ],
                'newsletter' => [
                    'heading' => 'Stay Connected With Us',
                    'items'   => [
                        'cards' => [
                            ['icon' => 'star',  'title' => 'Insider Access',         'description' => "Gain access to insightful articles, the latest breakthroughs, and expert advice you won't find anywhere else."],
                            ['icon' => 'heart', 'title' => 'Tips Made for You',      'description' => 'Get wellness tips tailored specifically to your own health journey.'],
                            ['icon' => 'users', 'title' => 'A Community That Cares', 'description' => 'Join a community that encourages and motivates one another toward a healthier, happier life.'],
                        ],
                    ],
                ],
                'cta' => [
                    'heading'    => 'Excited To Have You With Us',
                    'subheading' => 'With health and happiness,',
                    'meta'       => [
                        'signature' => 'Victor Zeines',
                        'cta_label' => 'Become a Member',
                    ],
                ],
            ],

            'about' => [
                'hero' => [
                    'heading'    => 'The Man Behind the Mission - Dr. Victor Zeines',
                    'subheading' => 'Founder, Institute for Living Longer',
                ],
                'highlights' => [
                    'items' => [
                        'cards' => [
                            ['icon' => 'graduation-cap', 'title' => 'Academic Background', 'description' => 'A Doctorate in Dental Medicine, paired with advanced training in holistic and longevity medicine.'],
                            ['icon' => 'award',          'title' => 'Decades of Dedication', 'description' => 'Decades spent advancing holistic health, wellness, and the science of biological age reversal.'],
                            ['icon' => 'book-open',      'title' => 'Author & Educator', 'description' => 'His writing on integrative, evidence-based wellness spans multiple published works.'],
                            ['icon' => 'heart',          'title' => 'Guiding Belief', 'description' => 'A belief that real change comes from education, community, and personal ownership of your health.'],
                        ],
                    ],
                ],
                'biography' => [
                    'heading' => "A Life's Work in Health & Wellness",
                    'body'    => "For close to four decades, Dr. Zeines has been researching what makes an individual a healthy person. Dr. Zeines is an accomplished figure in the realm of integrative medicine. He has assisted many in their journey to improved health.\n\nThis unique combination involves combining existing scientific knowledge and modern research in nutrition, exercise, stress, and aging. In Dr. Zeines' mind, health was not something that just involved the absence of diseases but involved mental, physical, and social well-being.\n\nThis conviction inspired the establishment of the Institute for Living Longer. He developed this resource as a tool to empower the community with knowledge on wellness issues. His teachings always resemble those of a great mentor. His teachings are clear and are based on solid evidence.\n\nDr. Zeines' contributions have been felt outside of his patient population as well. Dr. Zeines has created a group of like-minded physicians and practitioners. He aimed to help people become healthier.",
                    'meta'    => [
                        'quote'        => 'My mission is simple: to give you the knowledge and tools to live a longer, healthier, more vibrant life.',
                        'quote_author' => '— Dr. Victor Zeines',
                    ],
                ],
                'philosophy' => [
                    'heading'    => 'How Dr. Zeines Approaches Wellness',
                    'subheading' => 'The core beliefs shaping everything we teach',
                    'items'      => [
                        'principles' => [
                            ['number' => '01', 'title' => 'Prevent First',        'description' => 'We focus on preventing illness long before symptoms ever appear.'],
                            ['number' => '02', 'title' => 'Whole-Person Health',  'description' => 'Physical, mental, emotional, and spiritual health all matter equally here.'],
                            ['number' => '03', 'title' => 'Trust the Science',    'description' => "We combine traditional wisdom with research that's been properly tested."],
                            ['number' => '04', 'title' => 'Your Own Path',        'description' => 'No single plan works for everyone, so guidance stays personal.'],
                            ['number' => '05', 'title' => 'Habits Over Shortcuts','description' => 'Lasting results come from steady change, never shortcuts or gimmicks.'],
                            ['number' => '06', 'title' => 'Grow Together',        'description' => 'Real transformation happens faster when people support each other consistently.'],
                        ],
                    ],
                ],
            ],

            'collaborators' => [
                'hero' => [
                    'heading'    => 'Our Collaborators',
                    'subheading' => 'Find experts by name, specialty, or status',
                ],
                'cta' => [
                    'heading' => 'Join Our Network of Experts',
                    'body'    => "Become part of our network of expert practitioners and spread your knowledge among our growing group. Manage your own store, create courses, and have a positive impact on others' lives.",
                    'meta'    => ['cta_label' => 'Join as a Collaborator'],
                ],
            ],

            'intro_videos' => [
                'hero' => [
                    'heading' => 'Discover Healthier Living Through Our Sample Videos',
                ],
                'cta' => [
                    'heading' => 'Want Full Access?',
                    'body'    => 'Join us as members and access all our videos. Enjoy hundreds of hours of expert video content about health, nutrition, exercise, and longevity.',
                    'meta'    => ['cta_label' => 'Unlock Even More'],
                ],
            ],

            'shop' => [
                'hero' => [
                    'heading' => 'Our Wellness Collection',
                    'body'    => 'Premium products, handpicked by our expert collaborators. Members enjoy exclusive discounts on every item.',
                ],
                'member_benefits' => [
                    'heading' => 'Unlock Bigger Savings',
                    'body'    => 'Join our membership program and enjoy exclusive discounts on all products.',
                    'items'   => [
                        'tiers' => [
                            ['value' => '10%', 'label' => 'Essential Members'],
                            ['value' => '20%', 'label' => 'Premium Members'],
                            ['value' => '30%', 'label' => 'Elite Members'],
                        ],
                    ],
                    'meta' => ['cta_label' => 'Explore Membership'],
                ],
            ],

            'contact' => [
                'hero' => [
                    'heading' => "Let's Connect",
                    'body'    => 'Do you have any inquiries related to our program, membership, or collaboration services? Let us be of assistance during your journey towards wellness.',
                ],
                'form' => [
                    'heading'    => 'Ask Anything You Want To Know',
                    'subheading' => "Fill out the form below and we'll get back to you within 24 hours",
                ],
                'collaboration' => [
                    'heading' => 'Looking for Collaboration?',
                    'body'    => 'Are you a health professional seeking to join our group of collaborators? Do let us know in your email.',
                ],
                'quick_answers' => [
                    'heading' => 'For Instant Answers?',
                    'body'    => 'Try browsing through our frequently asked questions or resources.',
                    'meta'    => [
                        'faq_label'  => 'FAQ',
                        'help_label' => 'Help Center',
                    ],
                ],
            ],

            'faq' => [
                'hero' => [
                    'heading' => 'Frequently Asked Questions',
                    'body'    => 'Get answers to commonly asked questions about our membership, products, and services.',
                ],
                'cta' => [
                    'heading'    => 'Still Have Questions?',
                    'subheading' => "Can't find the answer you're looking for? Our support team is here to help.",
                    'meta'       => [
                        'contact_label' => 'Contact Support',
                        'help_label'    => 'Visit Help Center',
                    ],
                ],
            ],

            'help_center' => [
                'hero' => [
                    'heading' => 'Help Centre',
                    'body'    => 'Everything you need to know about using the Institute for Living Longer.',
                ],
                'getting_started' => [
                    'heading'    => 'Getting Started Guide',
                    'subheading' => 'New on the platform? Learn how you can get started',
                    'items'      => [
                        'steps' => [
                            ['title' => 'Pick a Membership Package', 'description' => 'Select the package that suits your health objectives and budget.'],
                            ['title' => 'Register Yourself',         'description' => 'Complete your registration by filling out your required information.'],
                            ['title' => 'Go to Your Dashboard',      'description' => 'Log in to access all of the content and sessions offered.'],
                            ['title' => 'Start Your Learning Process','description' => 'Watch introductory videos and attend live sessions.'],
                        ],
                    ],
                ],
                'support' => [
                    'heading'    => 'Need More Help?',
                    'subheading' => 'Our support team is ready to assist you',
                    'meta'       => [
                        'faq_label'     => 'View Frequently Asked Questions',
                        'support_label' => 'Support Center',
                    ],
                ],
            ],

            'testimonials' => [
                'hero' => [
                    'heading' => 'Stories That Inspire',
                    'body'    => 'We feature success stories from our members on how they have transformed their health and are living longer, healthier lives.',
                ],
                'videos' => [
                    'heading'    => 'Video Testimonials',
                    'subheading' => 'Real Stories, Real Experiences',
                ],
                'cta' => [
                    'heading'    => 'Your Success Story Starts Here',
                    'subheading' => 'Join others who are already transforming their lives. Start your journey to better health today.',
                    'meta'       => [
                        'primary_label' => 'Get Started Today',
                        'outline_label' => 'Watch Intro Videos',
                    ],
                ],
            ],
        ];
    }
}
