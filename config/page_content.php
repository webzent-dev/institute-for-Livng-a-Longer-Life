<?php

/**
 * Editable shape of each public page for the section-based CMS
 * (App\Models\PageContent + Admin\PageContentController + admin.content_management.page).
 *
 * The Vital Boost page has its own table/screen and is deliberately not listed here.
 *
 * Per section:
 *   fields  – the column-backed inputs (heading, subheading, body)
 *   meta    – free-form single values stored in the `meta` JSON column
 *   items   – repeatable rows stored in the `items` JSON column. A list with `fields`
 *             holds a row of named inputs; a list without `fields` holds plain strings.
 *
 * Adding a field here makes it appear in the admin form and be saved — no controller
 * change needed. The front view still has to read it.
 */
return [

    'pages' => [

        /* ── Home ─────────────────────────────────────────────────────── */
        'home' => [
            'label'       => 'Home',
            'description' => 'Edit the welcome banner, intro banner, membership heading, intro video, community, Vital Boost teaser, testimonials heading, newsletter and closing call to action.',
            'url'         => '/',
            'sections'    => [
                'hero' => [
                    'label'  => 'Welcome Banner',
                    'fields' => [
                        'heading'    => ['label' => 'Headline', 'type' => 'text'],
                        'subheading' => ['label' => 'Subheadline', 'type' => 'text'],
                        'body'       => ['label' => 'Description', 'type' => 'textarea', 'rows' => 3],
                    ],
                    'meta' => [
                        'eyebrow'         => ['label' => 'Eyebrow Text', 'type' => 'text'],
                        'primary_label'   => ['label' => 'Primary Button Label', 'type' => 'text'],
                        'secondary_label' => ['label' => 'Secondary Button Label', 'type' => 'text'],
                    ],
                    'note' => 'The illustration and leaf artwork are not editable here.',
                ],
                'intro' => [
                    'label'  => 'Intro Banner',
                    'fields' => [
                        'heading' => ['label' => 'Title', 'type' => 'text'],
                        'body'    => ['label' => 'Description', 'type' => 'textarea', 'rows' => 3],
                    ],
                    'meta' => [
                        'eyebrow'         => ['label' => 'Eyebrow Text', 'type' => 'text'],
                        'primary_label'   => ['label' => 'Primary Button Label', 'type' => 'text'],
                        'secondary_label' => ['label' => 'Secondary Button Label', 'type' => 'text'],
                    ],
                ],
                'membership' => [
                    'label'  => 'Membership Heading',
                    'fields' => [
                        'heading'    => ['label' => 'Heading', 'type' => 'text'],
                        'subheading' => ['label' => 'Subtitle', 'type' => 'text'],
                    ],
                    'note' => 'The plan cards come from the Memberships module, not from this form.',
                ],
                'intro_video' => [
                    'label'  => 'Intro Video',
                    'fields' => [
                        'heading' => ['label' => 'Heading', 'type' => 'text'],
                    ],
                    'items' => [
                        'cards' => [
                            'label'     => 'Feature Cards',
                            'add_label' => '+ Add Card',
                            'help'      => 'Icon names come from Lucide (e.g. message-circle, sparkles, users).',
                            'fields'    => [
                                'icon'        => ['label' => 'Icon', 'type' => 'text', 'width' => '10rem'],
                                'title'       => ['label' => 'Title', 'type' => 'text'],
                                'description' => ['label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'width' => '2fr'],
                            ],
                        ],
                    ],
                    'meta' => [
                        'video_url'       => ['label' => 'Video Link', 'type' => 'text'],
                        'video_label'     => ['label' => 'Video Caption (small)', 'type' => 'text'],
                        'video_title'     => ['label' => 'Video Caption (large)', 'type' => 'text'],
                        'signature_intro' => ['label' => 'Signature Intro', 'type' => 'text'],
                        'signature'       => ['label' => 'Signature', 'type' => 'text'],
                    ],
                ],
                'community' => [
                    'label'  => 'Join Our Community',
                    'fields' => [
                        'heading' => ['label' => 'Heading', 'type' => 'text'],
                        'body'    => ['label' => 'Closing Paragraph', 'type' => 'textarea', 'rows' => 3],
                    ],
                    'items' => [
                        'blocks' => [
                            'label'     => 'Highlight Blocks',
                            'add_label' => '+ Add Block',
                            'fields'    => [
                                'title'       => ['label' => 'Title', 'type' => 'text'],
                                'description' => ['label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'width' => '2fr'],
                            ],
                        ],
                        'topics' => [
                            'label'     => 'Lecture Topics',
                            'add_label' => '+ Add Topic',
                        ],
                    ],
                    'meta' => [
                        'primary_label'   => ['label' => 'Primary Button Label', 'type' => 'text'],
                        'secondary_label' => ['label' => 'Secondary Button Label', 'type' => 'text'],
                    ],
                ],
                'vital_boost' => [
                    'label'  => 'Vital Boost Teaser',
                    'items'  => [
                        'cards' => [
                            'label'     => 'Benefit Cards',
                            'add_label' => '+ Add Benefit',
                            'help'      => 'Icon names come from Lucide (e.g. leaf, sparkles, pill, award).',
                            'fields'    => [
                                'icon'        => ['label' => 'Icon', 'type' => 'text', 'width' => '10rem'],
                                'title'       => ['label' => 'Title', 'type' => 'text'],
                                'description' => ['label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'width' => '2fr'],
                            ],
                        ],
                    ],
                    'meta' => [
                        'badge'     => ['label' => 'Badge Text', 'type' => 'text'],
                        'cta_label' => ['label' => 'Button Label', 'type' => 'text'],
                    ],
                    'note' => 'The product name, description and image come from the Vital Boost product, not from this form.',
                ],
                'testimonials' => [
                    'label'  => 'Testimonials Heading',
                    'fields' => [
                        'heading' => ['label' => 'Heading', 'type' => 'text'],
                    ],
                    'note' => 'The video testimonials come from the Video Testimonials module, not from this form.',
                ],
                'newsletter' => [
                    'label'  => 'Newsletter Panel',
                    'fields' => [
                        'heading' => ['label' => 'Heading', 'type' => 'text'],
                    ],
                    'items' => [
                        'cards' => [
                            'label'     => 'Benefit Cards',
                            'add_label' => '+ Add Card',
                            'help'      => 'Icon names come from Lucide (e.g. star, heart, users).',
                            'fields'    => [
                                'icon'        => ['label' => 'Icon', 'type' => 'text', 'width' => '10rem'],
                                'title'       => ['label' => 'Title', 'type' => 'text'],
                                'description' => ['label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'width' => '2fr'],
                            ],
                        ],
                    ],
                    'note' => 'The subscribe form fields themselves are not editable here.',
                ],
                'cta' => [
                    'label'  => 'Closing Call To Action',
                    'fields' => [
                        'heading'    => ['label' => 'Heading', 'type' => 'text'],
                        'subheading' => ['label' => 'Sign-off Line', 'type' => 'text'],
                    ],
                    'meta' => [
                        'signature' => ['label' => 'Signature Name', 'type' => 'text'],
                        'cta_label' => ['label' => 'Button Label', 'type' => 'text'],
                    ],
                ],
            ],
        ],

        /* ── About Us ─────────────────────────────────────────────────── */
        'about' => [
            'label'       => 'About Us',
            'description' => 'Edit the hero, highlight cards, biography and philosophy of the About page.',
            'url'         => '/about-dr-zeines',
            'sections'    => [
                'hero' => [
                    'label'  => 'Hero Section',
                    'fields' => [
                        'heading'    => ['label' => 'Title', 'type' => 'text'],
                        'subheading' => ['label' => 'Subtitle', 'type' => 'text'],
                    ],
                    'note' => 'The portrait image is not editable here.',
                ],
                'highlights' => [
                    'label' => 'Highlight Cards',
                    'items' => [
                        'cards' => [
                            'label'     => 'Cards',
                            'add_label' => '+ Add Card',
                            'help'      => 'Icon names come from Lucide (e.g. graduation-cap, award, book-open, heart).',
                            'fields'    => [
                                'icon'        => ['label' => 'Icon', 'type' => 'text', 'width' => '10rem'],
                                'title'       => ['label' => 'Title', 'type' => 'text'],
                                'description' => ['label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'width' => '2fr'],
                            ],
                        ],
                    ],
                ],
                'biography' => [
                    'label'  => 'Biography',
                    'fields' => [
                        'heading' => ['label' => 'Heading', 'type' => 'text'],
                        'body'    => ['label' => 'Body Paragraphs', 'type' => 'textarea', 'rows' => 10,
                                      'help' => 'Separate paragraphs with a blank line. Each becomes its own paragraph on the page.'],
                    ],
                    'meta' => [
                        'quote'        => ['label' => 'Pull Quote', 'type' => 'textarea', 'rows' => 3],
                        'quote_author' => ['label' => 'Quote Author', 'type' => 'text'],
                    ],
                ],
                'philosophy' => [
                    'label'  => 'Wellness Philosophy',
                    'fields' => [
                        'heading'    => ['label' => 'Heading', 'type' => 'text'],
                        'subheading' => ['label' => 'Subtitle', 'type' => 'text'],
                    ],
                    'items' => [
                        'principles' => [
                            'label'     => 'Principles',
                            'add_label' => '+ Add Principle',
                            'help'      => 'The number is shown as the large accent digits on the card.',
                            'fields'    => [
                                'number'      => ['label' => 'Number', 'type' => 'text', 'width' => '6rem'],
                                'title'       => ['label' => 'Title', 'type' => 'text'],
                                'description' => ['label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'width' => '2fr'],
                            ],
                        ],
                    ],
                ],
            ],
        ],

        /* ── Our Collaborators ────────────────────────────────────────── */
        'collaborators' => [
            'label'       => 'Our Collaborators',
            'description' => 'Edit the intro above the collaborator list and the "join our network" call to action.',
            'url'         => '/collaborators',
            'sections'    => [
                'hero' => [
                    'label'  => 'Intro',
                    'fields' => [
                        'heading'    => ['label' => 'Title', 'type' => 'text'],
                        'subheading' => ['label' => 'Subtitle', 'type' => 'text'],
                    ],
                    'note' => 'The collaborator cards below come from the Collaborators module, not from this form.',
                ],
                'cta' => [
                    'label'  => 'Call To Action',
                    'fields' => [
                        'heading' => ['label' => 'Heading', 'type' => 'text'],
                        'body'    => ['label' => 'Description', 'type' => 'textarea', 'rows' => 3],
                    ],
                    'meta' => [
                        'cta_label' => ['label' => 'Button Label', 'type' => 'text'],
                    ],
                ],
            ],
        ],

        /* ── Intro Videos ─────────────────────────────────────────────── */
        'intro_videos' => [
            'label'       => 'Intro Videos',
            'description' => 'Edit the heading above the sample videos and the membership call to action.',
            'url'         => '/intro-videos',
            'sections'    => [
                'hero' => [
                    'label'  => 'Intro',
                    'fields' => [
                        'heading'    => ['label' => 'Title', 'type' => 'text'],
                        'subheading' => ['label' => 'Subtitle', 'type' => 'text'],
                    ],
                    'note' => 'The video cards come from the Intro Videos module, not from this form.',
                ],
                'cta' => [
                    'label'  => 'Call To Action',
                    'fields' => [
                        'heading' => ['label' => 'Heading', 'type' => 'text'],
                        'body'    => ['label' => 'Description', 'type' => 'textarea', 'rows' => 3],
                    ],
                    'meta' => [
                        'cta_label' => ['label' => 'Button Label', 'type' => 'text'],
                    ],
                ],
            ],
        ],

        /* ── Store ────────────────────────────────────────────────────── */
        'shop' => [
            'label'       => 'Store',
            'description' => 'Edit the store heading and the member discount tiers shown below the products.',
            'url'         => '/shop',
            'sections'    => [
                'hero' => [
                    'label'  => 'Intro',
                    'fields' => [
                        'heading' => ['label' => 'Title', 'type' => 'text'],
                        'body'    => ['label' => 'Description', 'type' => 'textarea', 'rows' => 3],
                    ],
                    'note' => 'The product grid comes from the Products module, not from this form.',
                ],
                'member_benefits' => [
                    'label'  => 'Member Discounts',
                    'fields' => [
                        'heading' => ['label' => 'Heading', 'type' => 'text'],
                        'body'    => ['label' => 'Description', 'type' => 'textarea', 'rows' => 2],
                    ],
                    'items' => [
                        'tiers' => [
                            'label'     => 'Discount Tiers',
                            'add_label' => '+ Add Tier',
                            'fields'    => [
                                'value' => ['label' => 'Discount', 'type' => 'text', 'width' => '8rem'],
                                'label' => ['label' => 'Tier Name', 'type' => 'text'],
                            ],
                        ],
                    ],
                    'meta' => [
                        'cta_label' => ['label' => 'Button Label', 'type' => 'text'],
                    ],
                ],
            ],
        ],

        /* ── Contact Us ───────────────────────────────────────────────── */
        'contact' => [
            'label'       => 'Contact Us',
            'description' => 'Edit the contact hero, the form card copy, the collaboration note and the quick answers panel.',
            'url'         => '/contact',
            'sections'    => [
                'hero' => [
                    'label'  => 'Hero Section',
                    'fields' => [
                        'heading' => ['label' => 'Title', 'type' => 'text'],
                        'body'    => ['label' => 'Description', 'type' => 'textarea', 'rows' => 3],
                    ],
                ],
                'form' => [
                    'label'  => 'Contact Form Card',
                    'fields' => [
                        'heading'    => ['label' => 'Card Title', 'type' => 'text'],
                        'subheading' => ['label' => 'Card Subtitle', 'type' => 'text'],
                    ],
                    'note' => 'Email address and locations come from Site Settings, not from this form.',
                ],
                'collaboration' => [
                    'label'  => 'Collaboration Note',
                    'fields' => [
                        'heading' => ['label' => 'Heading', 'type' => 'text'],
                        'body'    => ['label' => 'Description', 'type' => 'textarea', 'rows' => 3],
                    ],
                ],
                'quick_answers' => [
                    'label'  => 'Quick Answers',
                    'fields' => [
                        'heading' => ['label' => 'Heading', 'type' => 'text'],
                        'body'    => ['label' => 'Description', 'type' => 'textarea', 'rows' => 2],
                    ],
                    'meta' => [
                        'faq_label'  => ['label' => 'FAQ Button Label', 'type' => 'text'],
                        'help_label' => ['label' => 'Help Center Button Label', 'type' => 'text'],
                    ],
                ],
            ],
        ],

        /* ── FAQ ──────────────────────────────────────────────────────── */
        'faq' => [
            'label'       => 'FAQ',
            'description' => 'Edit the FAQ heading and the support call to action. The questions live in the FAQs module.',
            'url'         => '/faq',
            'sections'    => [
                'hero' => [
                    'label'  => 'Hero Section',
                    'fields' => [
                        'heading' => ['label' => 'Title', 'type' => 'text'],
                        'body'    => ['label' => 'Description', 'type' => 'textarea', 'rows' => 2],
                    ],
                    'note' => 'Questions and categories come from the FAQs module, not from this form.',
                ],
                'cta' => [
                    'label'  => 'Call To Action',
                    'fields' => [
                        'heading'    => ['label' => 'Heading', 'type' => 'text'],
                        'subheading' => ['label' => 'Subtitle', 'type' => 'text'],
                    ],
                    'meta' => [
                        'contact_label' => ['label' => 'Contact Button Label', 'type' => 'text'],
                        'help_label'    => ['label' => 'Help Center Button Label', 'type' => 'text'],
                    ],
                ],
            ],
        ],

        /* ── Help Centre ──────────────────────────────────────────────── */
        'help_center' => [
            'label'       => 'Help Centre',
            'description' => 'Edit the help centre hero, the getting started steps and the support section.',
            'url'         => '/help-center',
            'sections'    => [
                'hero' => [
                    'label'  => 'Hero Section',
                    'fields' => [
                        'heading' => ['label' => 'Title', 'type' => 'text'],
                        'body'    => ['label' => 'Description', 'type' => 'textarea', 'rows' => 2],
                    ],
                    'note' => 'The searchable help topics come from the Help Topics module, not from this form.',
                ],
                'getting_started' => [
                    'label'  => 'Getting Started Guide',
                    'fields' => [
                        'heading'    => ['label' => 'Heading', 'type' => 'text'],
                        'subheading' => ['label' => 'Subtitle', 'type' => 'text'],
                    ],
                    'items' => [
                        'steps' => [
                            'label'     => 'Steps',
                            'add_label' => '+ Add Step',
                            'help'      => 'Steps are numbered automatically in the order listed here.',
                            'fields'    => [
                                'title'       => ['label' => 'Title', 'type' => 'text'],
                                'description' => ['label' => 'Description', 'type' => 'textarea', 'rows' => 2, 'width' => '2fr'],
                            ],
                        ],
                    ],
                ],
                'support' => [
                    'label'  => 'Need More Help',
                    'fields' => [
                        'heading'    => ['label' => 'Heading', 'type' => 'text'],
                        'subheading' => ['label' => 'Subtitle', 'type' => 'text'],
                    ],
                    'meta' => [
                        'faq_label'     => ['label' => 'FAQ Button Label', 'type' => 'text'],
                        'support_label' => ['label' => 'Support Button Label', 'type' => 'text'],
                    ],
                    'note' => 'The support option cards come from the Contact Options module, not from this form.',
                ],
            ],
        ],

        /* ── Testimonials ─────────────────────────────────────────────── */
        'testimonials' => [
            'label'       => 'Testimonials',
            'description' => 'Edit the testimonials intro, the video section heading and the closing call to action.',
            'url'         => '/testimonials',
            'sections'    => [
                'hero' => [
                    'label'  => 'Intro',
                    'fields' => [
                        'heading' => ['label' => 'Title', 'type' => 'text'],
                        'body'    => ['label' => 'Description', 'type' => 'textarea', 'rows' => 3],
                    ],
                    'note' => 'The testimonial cards come from the Testimonials module, not from this form.',
                ],
                'videos' => [
                    'label'  => 'Video Testimonials',
                    'fields' => [
                        'heading'    => ['label' => 'Heading', 'type' => 'text'],
                        'subheading' => ['label' => 'Subtitle', 'type' => 'text'],
                    ],
                ],
                'cta' => [
                    'label'  => 'Call To Action',
                    'fields' => [
                        'heading'    => ['label' => 'Heading', 'type' => 'text'],
                        'subheading' => ['label' => 'Subtitle', 'type' => 'text'],
                    ],
                    'meta' => [
                        'primary_label' => ['label' => 'Primary Button Label', 'type' => 'text'],
                        'outline_label' => ['label' => 'Secondary Button Label', 'type' => 'text'],
                    ],
                ],
            ],
        ],
    ],
];
