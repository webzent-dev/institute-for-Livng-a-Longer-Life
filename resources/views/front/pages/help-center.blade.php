@extends('front.layouts.app')

@section('content')

<div class="min-h-screen flex flex-col">

    <main class="flex-1">

        {{-- HERO SECTION --}}
        <section class="gradient-subtle py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full gradient-primary mb-6">
                    <i data-lucide="life-buoy"  class="h-8 w-8 text-primary-foreground" ></i>
                </div>

                <h1 class="text-4xl lg:text-6xl font-bold text-foreground mb-6">
                    Help Center
                </h1>

                <p class="text-xl text-muted-foreground max-w-3xl mx-auto">
                    Everything you need to know about using the Institute for Living Longer
                </p>

            </div>

              <!-- Search + Category functionality-->
                <div class="my-8 flex flex-col md:flex-row gap-4  justify-center ">
                        <div class="relative ">
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Search helpTopics..."
                            class="w-full pl-12 pr-12 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary text-lg search-select"
                        />
                        <i class="fas fa-search absolute left-4 top-3 text-gray-500 text-xl"></i>

                        <button id="clearSearch" class="absolute right-3 top-4 text-gray-500 hover:text-gray-700 text-2xl hidden">
                            <i class="fas fa-times-circle"></i>
                        </button>
                        </div>
                        <div class=" w-full md:w-80 ">
                                <select  id="topicSelect" class="pl-12 pr-12 py-3 max-w-sm rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary text-lg search-select" >
                        <option value="all" >All Titles</option>

                        <!-- Options will be populated by JavaScript -->
                        </select>
                        </div>
                        
                </div>

                {{-- Menu and tabbed navigation for topics. --}}
                {{-- MENU + TABBED NAVIGATION --}}
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">

                    <!-- Mobile Scroll Menu -->
                    <div class="flex md:hidden gap-3 overflow-x-auto pb-3">
                        <button
                            class="topic-tab active-tab"
                            data-topic="all">
                            All Topics
                        </button>

                        @foreach($helpTopics as $topic)
                            <button
                                class="topic-tab"
                                data-topic="{{ $topic['title'] }}">
                                <i data-lucide="{{ strtolower($topic['icon']) }}" class="w-4 h-4 mr-2"></i>
                                {{ $topic['title'] }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Desktop Tabs for topics -->
                    <div class="hidden md:flex justify-center flex-wrap gap-3 mt-6">
                        <button
                            class="topic-tab active-tab"
                            data-topic="all">
                            All Topics
                        </button>

                        @foreach($helpTopics as $topic)
                            <button
                                class="topic-tab"
                                data-topic="{{ $topic['title'] }}">
                                <i data-lucide="{{ strtolower($topic['icon']) }}" class="w-4 h-4 mr-2"></i>
                                {{ $topic['title'] }}
                            </button>
                        @endforeach
                    </div>

                </div>

        </section> 
            
        {{-- HELP TOPICS GRID --}}
        <section class="py-4 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
              
                  <!-- Search Stats -->
                        {{-- <div id="searchStats" class="mt-3 text-sm text-gray-500 hidden">
                            Showing <span id="resultCount" class="font-semibold"></span> of <span id="totalCount" class="font-semibold"></span> topics
                        </div> --}}
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

        {{-- QUICK START GUIDE --}}
        <section class="py-20 gradient-subtle">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

                <x-card class="shadow-strong">

                    <x-card-header class="text-center">
                        <x-card-title class="text-3xl  mb-4">Quick Start Guide</x-card-title>
                        <p class="text-muted-foreground">
                            New to the platform? Follow these simple steps to get started
                        </p>
                    </x-card-header>

                    <x-card-content class="space-y-6">
                        @foreach ([
                            ['1', 'Choose Your Membership', 'Select the plan that best fits your wellness goals and budget'],
                            ['2', 'Complete Registration', 'Fill out your profile information and set up your account'],
                            ['3', 'Access Your Dashboard', 'Log in to explore content and resources'],
                            ['4', 'Start Learning', 'Watch videos, join live sessions, begin your journey']
                        ] as $step)

                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 rounded-full gradient-primary flex items-center justify-center flex-shrink-0">
                                    <span class="text-xl font-bold text-primary-foreground">{{ $step[0] }}</span>
                                </div>

                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-foreground mb-1">{{ $step[1] }}</h3>
                                    <p class="text-muted-foreground">{{ $step[2] }}</p>
                                </div>
                            </div>

                        @endforeach
                    </x-card-content>

                </x-card>

            </div>
        </section>

        {{-- CONTACT SECTION --}}
        <section class="py-20 bg-background">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-foreground mb-4">Need More Help<span class="text-primary">?</sapan></h2>
                    <p class="text-xl text-muted-foreground">Our support team is ready to assist you</p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">

                       @foreach ($contactOptions as $option)
                        <x-card class="shadow-medium">
                            <x-card-content class="p-8 text-center">

                                <div class="w-16 h-16 rounded-full gradient-primary flex items-center justify-center mx-auto mb-4">
                                    <i data-lucide="{{ $option['icon'] }}"
                                    class="h-8 w-8 text-primary-foreground"></i>
                                </div>

                                <h3 class="text-xl font-semibold text-foreground mb-2">
                                    {{ $option->title }}
                                </h3>

                                <p class="text-muted-foreground mb-4">
                                    {{ $option['description'] }}
                                </p>

                                <x-ui.contact-item
                                    :type="$option['type']"
                                    :text="$option['contact']"
                                    :value="$option['contact']"
                                    class="w-full justify-center text-green-600 hover:text-white"
                                />

                                <p class="text-sm text-muted-foreground mt-3">
                                    {{ $option['note'] }}
                                </p>

                            </x-card-content>
                        </x-card>
                    @endforeach
                </div>
                 
                <div class="flex justify-center mt-12 gap-2">
                    <x-button-use href="/faq" variant="outline" size="lg" icon="badge-question-mark">
                        View Frequently Asked Questions
                    </x-button-use>
                    {{--Direct users to support ticket or contact. --}}
                    <x-button-use href="/contact" variant="outline" size="lg" icon="user-pen">
                        Support Center      
                    </x-button-use>
                </div>

                

            </div>
        </section>

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
                topicOption.value = `topic:${topic.title}`;
                topicOption.textContent = `Topic: ${topic.title}`;
                topicSelect.appendChild(topicOption);
            });

            // Add article options (grouped by topic)
            helpTopics.forEach(topic => {
                topic.articles.forEach(article => {
                    const articleOption = document.createElement('option');
                    articleOption.value = `article:${article}`;
                    articleOption.textContent = `Article: ${article} (${topic.title})`;
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
                console.log("icon.....",icon);

                
                // Generate HTML for articles list with highlighting
                let articlesHTML = '';
                topic.articles.forEach(article => {
                    const highlightedArticle = highlightText(article, searchTerm);
                    articlesHTML += `<li class="flex items-start py-2"><a href="#" class="text-primary hover:underline flex items-center">
                        <i class="fas fa-file-alt  mt-1 mr-3 text-sm"></i>
                        <span>${highlightedArticle}</span>
                    </li>`;
                });
                
                card.innerHTML = `
                    <div class="flex items-start mb-4">
                       
                                 <div class="w-14 h-14 iconbg mb-4 mr-2">
                                    <i data-lucide="${icon}" class="h-7 w-7 text-white"></i>  
                                </div>
                        <div>
                            <h3 class="heading-4 font-semibold  mb-1">${highlightedTitle}</h3>
                            <p class="text-sm text-muted-foreground">${highlightedDescription}</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 pt-4">
                        
                        <ul class="space-y-2">
                            ${articlesHTML}
                        </ul>
                    </div>
                `;
                
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
