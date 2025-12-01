@props(['items' => []])

<div 
    x-data="carousel({{ json_encode($items) }})"
    x-init="init()"
    class="relative overflow-hidden rounded-xl group"
    tabindex="0"
    @keydown.left.prevent="prev()"
    @keydown.right.prevent="next()"
>
    <!-- SLIDES -->
    <template x-for="(slide, i) in slides" :key="i">
        <div 
            x-show="index === i" 
            x-transition.opacity.scale.50
            class="w-full h-72 md:h-96 bg-gray-100 flex flex-col items-center justify-center relative"
        >
            <!-- MEDIA TYPE HANDLER -->
            <template x-if="slide.type === 'image'">
                <img 
                    :src="slide.src"
                    :alt="slide.title ?? ''"
                    loading="lazy"
                    class="w-full h-full object-cover cursor-pointer"
                    @click="openPreview(slide)"
                >
            </template>

            <template x-if="slide.type === 'video'">
                <video 
                    :src="slide.src" 
                    controls
                    preload="metadata"
                    class="w-full h-full object-cover cursor-pointer"
                    @click="openPreview(slide)"
                ></video>
            </template>

            <template x-if="slide.type === 'audio'">
                <div class="p-6 flex flex-col items-center">
                    <audio :src="slide.src" controls preload="none"></audio>
                </div>
            </template>

            <template x-if="slide.type === 'html'">
                <div class="p-6" x-html="slide.html"></div>
            </template>

            <!-- TEXT OVERLAY -->
            <div 
                x-show="slide.title || slide.description"
                class="absolute bottom-0 w-full bg-gradient-to-t from-black/60 to-transparent p-4 text-white"
            >
                <h3 class="text-lg font-bold" x-text="slide.title"></h3>
                <p class="text-sm opacity-80" x-text="slide.description"></p>
            </div>
        </div>
    </template>

    <!-- PREV -->
    <button 
        @click="prev()"
        class="absolute left-2 top-1/2 -translate-y-1/2 px-3 py-2 bg-white/80 backdrop-blur-md rounded-full shadow opacity-0 group-hover:opacity-100 transition"
    >
        ‹
    </button>

    <!-- NEXT -->
    <button 
        @click="next()"
        class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-2 bg-white/80 backdrop-blur-md rounded-full shadow opacity-0 group-hover:opacity-100 transition"
    >
        ›
    </button>

    <!-- DOTS -->
    <div class="absolute bottom-3 w-full flex justify-center gap-2">
        <template x-for="(dot, i) in slides">
            <div 
                class="w-3 h-3 rounded-full cursor-pointer"
                :class="index === i ? 'bg-white' : 'bg-white/40'"
                @click="index = i"
            ></div>
        </template>
    </div>

    <!-- FULL PREVIEW MODAL -->
    <div 
        x-show="previewOpen"
        x-transition.opacity
        class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4"
    >
        <div class="relative max-w-5xl w-full">

            <!-- Close -->
            <button 
                @click="previewOpen=false"
                class="absolute -top-8 right-0 text-white text-3xl"
            >×</button>

            <!-- Image Preview -->
            <template x-if="preview.type === 'image'">
                <img :src="preview.src" class="w-full rounded-lg shadow-xl">
            </template>

            <!-- Video Preview -->
            <template x-if="preview.type === 'video'">
                <video :src="preview.src" controls class="w-full rounded-lg shadow-xl"></video>
            </template>

            <!-- HTML Preview -->
            <template x-if="preview.type === 'html'">
                <div class="bg-white p-6 rounded-lg shadow-xl" x-html="preview.html"></div>
            </template>
        </div>
    </div>

</div>







{{-- @props(['items' => []])

<div 
    x-data="{ index: 0, total: {{ count($items) }} }"
    class="relative overflow-hidden rounded-xl"
>
    <template x-for="(item, i) in {{ json_encode($items) }}">
        <div 
            x-show="index === i" 
            x-transition 
            class="w-full h-64 flex items-center justify-center bg-gray-100"
            x-html="item"
        ></div>
    </template>

    <button 
        class="absolute left-2 top-1/2 -translate-y-1/2 px-2 py-1 bg-white rounded shadow"
        @click="index = (index - 1 + total) % total"
    >‹</button>

    <button 
        class="absolute right-2 top-1/2 -translate-y-1/2 px-2 py-1 bg-white rounded shadow"
        @click="index = (index + 1) % total"
    >›</button>
</div> --}}

{{-- how to use --}}

{{-- <x-ui.carousel :items="[
    '<img src=\"/img/1.jpg\" class=\"h-64 w-full object-cover\">',
    '<img src=\"/img/2.jpg\" class=\"h-64 w-full object-cover\">',
    '<img src=\"/img/3.jpg\" class=\"h-64 w-full object-cover\">',
]" /> --}}



