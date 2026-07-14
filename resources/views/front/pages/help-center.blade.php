@extends('front.layouts.app')
@section('content')
@php
    // CMS sections (App\Models\PageContent, page_key "help_center"), keyed by section_key. Every
    // value falls back to the original hard-coded copy, so the page still renders if a section has
    // not been seeded or an admin deactivates one.
    $sections       = $sections ?? collect();
    $hero           = $sections['hero']            ?? null;
    $gettingStarted = $sections['getting_started'] ?? null;
    $support        = $sections['support']         ?? null;
    $supportMeta    = $support->meta ?? [];

    $startSteps = $gettingStarted->items['steps'] ?? [];
    if (empty($startSteps)) {
        $startSteps = [
            ['title' => 'Choose Your Membership',  'description' => 'Select the plan that best fits your wellness goals and budget'],
            ['title' => 'Complete Registration',   'description' => 'Fill out your profile information and set up your account'],
            ['title' => 'Access Your Dashboard',   'description' => 'Log in to explore available content, upcoming sessions, and resources'],
            ['title' => 'Start Learning',          'description' => 'Watch intro videos, join live sessions, and begin your health journey'],
        ];
    }
@endphp
<div class="min-h-screen flex flex-col">
    <main class="flex-1">
        <section class="gradient-subtle py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full gradient-primary mb-6">
                    <i data-lucide="life-buoy"  class="h-8 w-8 text-primary-foreground" ></i>
                </div>
                <h1 class="text-4xl lg:text-6xl font-bold text-foreground mb-6">{{ $hero->heading ?? 'Help Center' }}</h1>
                <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                    {{ $hero->body ?? 'Everything you need to know about using the Institute for Living Longer' }}
                </p>
            </div>

            <!-- Search + Category functionality-->
            <div class="my-8 flex flex-col md:flex-row gap-4  justify-center px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
                <div class="relative ">
                    <input type="text" id="searchInput" placeholder="Search helpTopics..." class="w-full pl-12 pr-12 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary text-lg search-select"/>
                    <i data-lucide="search" class="h-5 w-5 absolute text-semibold left-4 top-3 text-xl "></i>
                    <button id="clearSearch" class="absolute right-3 top-4 text-gray-500 hover:text-gray-700 text-2xl hidden">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="relative">
                    <select id="topicSelect" class="w-full min-w-0 pl-12 pr-12 py-2 rounded-lg border border-gray-300 text-lg search-select" >
                        <option value="all" >All Titles</option>
                    </select>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
                <!-- Mobile Scroll Menu -->
                <div class="flex flex-col md:hidden gap-3 whitespace-nowrap overflow-x-auto scroll-smooth pb-3">
                    <button class="topic-tab active-tab" data-topic="all">All Topics</button>
                    @foreach($helpTopics as $topic)
                        <button class="topic-tab" data-topic="{{ $topic['title'] }}">
                            <i data-lucide="{{ strtolower($topic['icon']) }}" class="w-4 h-4 mr-2"></i>
                            {{ $topic['title'] }}
                        </button>
                    @endforeach
                </div>

                <!-- Desktop Tabs for topics -->
                <div class="hidden md:flex justify-center flex-wrap gap-3 mt-6">
                    <button class="topic-tab active-tab" data-topic="all">All Topics</button>
                    @foreach($helpTopics as $topic)
                        <button class="topic-tab" data-topic="{{ $topic['title'] }}">
                            <i data-lucide="{{ strtolower($topic['icon']) }}" class="w-4 h-4 mr-2"></i>
                            {{ $topic['title'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="py-4 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Help Topics Grid -->
                <div id="helpTopicsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Cards will be populated by JavaScript -->
                </div>

                <!-- No Results Message -->
                <div id="noResults" class="hidden no-results text-center py-12">
                    <div class="mb-4">
                        <i class="fas fa-search text-gray-300 text-5xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No results found</h3>
                    <p class="text-gray-500">Try adjusting your search or filter to find what you're looking for.</p>
                    <x-button-use
                        type="button"
                        id="resetFilters" varient="accent"
                        class="mt-4 px-4 py-2   text-white rounded-lg  ">
                        Reset Filters
                    </x-button-use>
                    <button id="resetFilters" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Reset Filters
                    </button>
                </div>
            </div>
        </section>

        @if($gettingStarted || !$sections->count())
        <section class="gradient-subtle py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="rounded-lg border bg-card text-card-foreground shadow-sm shadow-strong">
                    <div class="flex flex-col space-y-1.5 p-6 text-center">
                        <h3 class="mb-4 text-3xl font-semibold tracking-tight">{{ $gettingStarted->heading ?? 'Quick Start Guide' }}</h3>
                        <p class="text-muted-foreground">
                            {{ $gettingStarted->subheading ?? 'New to the platform? Follow these simple steps to get started' }}
                        </p>
                    </div>
                    <div class="space-y-6 p-6 pt-0">
                        @foreach($startSteps as $i => $step)
                        <div class="flex items-start space-x-4">
                            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full gradient-primary">
                                <span class="text-xl font-bold text-primary-foreground">{{ $i + 1 }}</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="mb-1 text-lg font-semibold text-foreground">{{ $step['title'] ?? '' }}</h3>
                                <p class="text-muted-foreground">
                                    {{ $step['description'] ?? '' }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif

        @if($support || !$sections->count())
        <section class="py-20 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-foreground mb-4">{{ $support->heading ?? 'Need More Help?' }}</h2>
                    <p class="text-xl text-muted-foreground">{{ $support->subheading ?? 'Our support team is ready to assist you' }}</p>
                </div>
                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    @foreach ($contactOptions as $option)
                        <x-card class="shadow-medium hover:border-gray-200">
                            <x-card-content class="p-8 text-center">
                                <div class="w-16 h-16 rounded-full gradient-primary flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="{{ $option['icon'] }}" class="h-8 w-8 text-primary-foreground"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-foreground mb-2">{{ $option->title }}</h3>
                                <p class="text-muted-foreground mb-4">{{ $option['description'] }}</p>
                                <x-ui.contact-item
                                    :type="$option['type']"
                                    :text="$option['contact']"
                                    :value="$option['contact']"
                                    class="w-full justify-center text-green-600 hover:text-white"
                                />
                                <p class="text-sm text-muted-foreground mt-3">{{ $option['note'] }}</p>
                            </x-card-content>
                        </x-card>
                    @endforeach
                </div>
                <div class="flex flex-col items-center justify-center mt-12 gap-2">
                    <x-button-use href="{{ url('/faq') }}" variant="outline" size="lg"  >
                        {{ $supportMeta['faq_label'] ?? 'View Frequently Asked Questions' }}
                    </x-button-use>
                    <x-button-use href="{{ url('/contact') }}" variant="outline" size="lg"  >
                        {{ $supportMeta['support_label'] ?? 'Support Center' }}
                    </x-button-use>
                </div>
            </div>
        </section>
        @endif
    </main>
</div>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    // Help topics data
    const helpTopics = @json($helpTopics);
    // DOM Elements
    const searchInput = document.getElementById('searchInput');
    const topicSelect = document.getElementById('topicSelect');
    const helpTopicsContainer = document.getElementById('helpTopicsContainer');
    const noResults = document.getElementById('noResults');
    const searchStats = document.getElementById('searchStats');
    const resultCount = document.getElementById('resultCount');
    const totalCount = document.getElementById('totalCount');
    const resetFilters = document.getElementById('resetFilters');

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        populateSelectOptions();
        renderHelpTopics(helpTopics);
        updateStats(helpTopics.length, helpTopics.length);
    });

    // Populate select dropdown with all topics and articles
    function populateSelectOptions() {
        // Clear existing options except the first one
        while (topicSelect.options.length > 1) {
            topicSelect.remove(1);
        }

        // Add topic options
        helpTopics.forEach(topic => {
            const topicOption = document.createElement('option');
            topicOption.value = `${topic.title}`;
            topicOption.textContent = `${topic.title}`;
            topicSelect.appendChild(topicOption);
        });

        // Add article options (grouped by topic)
        helpTopics.forEach(topic => {
            topic.articles.forEach(article => {
                const articleOption = document.createElement('option');
                articleOption.value = `${article.title}`;
                articleOption.textContent = `${article.title} `;
                // articleOption.textContent = `Article: ${article} (${topic.title})`;
                topicSelect.appendChild(articleOption);
            });
        });
    }

    // Render help topic cards
    function renderHelpTopics(topicsToRender, searchTerm = '') {
        helpTopicsContainer.innerHTML = '';
        if (topicsToRender.length === 0) {
            noResults.classList.remove('hidden');
            helpTopicsContainer.classList.add('hidden');
            return;
        }

        noResults.classList.add('hidden');
        helpTopicsContainer.classList.remove('hidden');
        topicsToRender.forEach(topic => {
            const card = document.createElement('div');
            card.className = 'card';
            // Highlight matching text in title and description
            const highlightedTitle = highlightText(topic.title, searchTerm);
            const highlightedDescription = highlightText(topic.description, searchTerm);
            const icon = topic.icon.toLowerCase();
        
            // Generate HTML for articles list with highlighting
            let articlesHTML = '';
            topic.articles.forEach(article => {
                const highlightedArticle = highlightText(article.title, searchTerm);
                articlesHTML += `<li class="flex items-start"><a href="#" class="text-primary hover:underline flex items-center">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary mr-2"></span>
                    <span>${highlightedArticle}</span>
                </li>`;
            });

            card.innerHTML = `
                <div class="px-6 pt-6 items-start ">
                    <div class="w-14 h-14 iconbg mb-4 mr-2">
                    <i data-lucide="${icon}" class="h-7 w-7 text-white"></i>
                </div>
                <div>
                    <h3 class="heading-4 font-semibold  mb-1">${highlightedTitle}</h3>
                    <p class="text-sm text-muted-foreground">${highlightedDescription}</p>
                </div>
            </div>
            <div class=" px-6 pb-4">
                <ul class="space-y-2">
                    ${articlesHTML}
                </ul>
            </div>`;
            helpTopicsContainer.appendChild(card);
        });
        lucide.createIcons();
    }

    // Highlight matching text in content
    function highlightText(text, searchTerm) {
        if (!searchTerm || searchTerm.trim() === '') return text;
        const regex = new RegExp(`(${escapeRegExp(searchTerm)})`, 'gi');
        return text.replace(regex, '<span class="highlight">$1</span>');
    }

    // Escape special regex characters
    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    // Filter help topics based on search and select
    function filterHelpTopics() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedValue = topicSelect.value;
        let filteredTopics = helpTopics;

        // Apply search filter if search term exists
        if (searchTerm) {
            filteredTopics = helpTopics.filter(topic => {
                // Check if topic title or description contains search term
                const titleMatch = topic.title.toLowerCase().includes(searchTerm);
                const descMatch = topic.description.toLowerCase().includes(searchTerm);

                // Check if any article contains search term
                const articleMatch = topic.articles.some(article =>
                    article.toLowerCase().includes(searchTerm)
                );

                return titleMatch || descMatch || articleMatch;
            });
        }

        // Apply select filter if something is selected
        if (selectedValue) {
            if (selectedValue.startsWith('topic:')) {
                const selectedTopic = selectedValue.replace('topic:', '');
                filteredTopics = filteredTopics.filter(topic =>
                    topic.title === selectedTopic
                );
            } else if (selectedValue.startsWith('article:')) {
                const selectedArticle = selectedValue.replace('article:', '');
                filteredTopics = filteredTopics.filter(topic =>
                    topic.articles.some(article => article === selectedArticle)
                );
            }
        }

        // Render filtered topics
        renderHelpTopics(filteredTopics, searchTerm);
        updateStats(filteredTopics.length, helpTopics.length);
    }

    // Update search statistics
    function updateStats(filteredCount, total) {
        totalCount.textContent = total;
        resultCount.textContent = filteredCount;
        if (filteredCount !== total || searchInput.value || topicSelect.value) {
            searchStats.classList.remove('hidden');
        } else {
            searchStats.classList.add('hidden');
        }
    }

    // Event Listeners
    searchInput.addEventListener('input', filterHelpTopics);
    topicSelect.addEventListener('change', filterHelpTopics);
    resetFilters.addEventListener('click', function() {
        searchInput.value = '';
        topicSelect.value = '';
        renderHelpTopics(helpTopics);
        updateStats(helpTopics.length, helpTopics.length);
    });

    // Add a clear button to search input
    const searchContainer = searchInput.parentElement;
    const clearButton = document.createElement('button');
    clearButton.className = 'absolute inset-y-0 right-0 pr-3 flex items-center hidden';
    clearButton.innerHTML = '<i class="fas fa-times text-gray-400 hover:text-gray-600"></i>';
    clearButton.type = 'button';
    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.focus();
        filterHelpTopics();
        updateClearButton();
    });

    searchContainer.appendChild(clearButton);
    searchContainer.classList.add('relative');
    searchInput.addEventListener('input', updateClearButton);
    function updateClearButton() {
        if (searchInput.value) {
            clearButton.classList.remove('hidden');
        } else {
            clearButton.classList.add('hidden');
        }
    }
</script>
<script>
    const topicTabs = document.querySelectorAll('.topic-tab');
    topicTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Active state
            topicTabs.forEach(t => t.classList.remove('active-tab'));
            tab.classList.add('active-tab');

            // Reset search + select
            searchInput.value = '';
            topicSelect.value = '';

            const selectedTopic = tab.dataset.topic;
            if (selectedTopic === 'all') {
                renderHelpTopics(helpTopics);
                updateStats(helpTopics.length, helpTopics.length);
                return;
            }

            const filtered = helpTopics.filter(
                topic => topic.title === selectedTopic
            );

            renderHelpTopics(filtered);
            updateStats(filtered.length, helpTopics.length);
        });
    });
    lucide.createIcons();
</script>
@endsection