@props([
    'items' => [],            // array of slides: each item must include at least 'id' (optional), and depending on type: 'thumbnail','videoUrl','image','audioUrl','title','content'
    'type' => 'video',        // 'video'|'image'|'audio'|'content'
    'autoplay' => true,
    'speed' => 3000,         // autoplay interval in ms
    'centerScale' => 1.12,   // scale for center card
    'sideScale' => 0.92,     // scale for side cards
])

<section class="py-10 bg-background">
    <div class="max-w-7xl mx-auto ">
        

        <div class="relative">
            {{-- Viewport --}}
            <div id="carouselViewport" class="overflow-hidden mx-12 py-4">
                {{-- Track will be populated by JS --}}
                <div id="carouselTrack" class="flex items-center will-change-transform transition-transform duration-300 ease-out py-2"></div>
            </div>

            {{-- Prev/Next --}}
            <button id="carouselPrev" aria-label="Previous" class="z-40 absolute left-[-10px] top-1/2 -translate-y-1/2 bg-white/90 border p-2 rounded-full shadow hover:scale-105">
                ◀
            </button>
            <button id="carouselNext" aria-label="Next" class="z-40 absolute right-[-20px] top-1/2 -translate-y-1/2 bg-white/90 border p-2 rounded-full shadow hover:scale-105">
                ▶
            </button>
        </div>
    </div>
</section>

{{-- Modal for video/audio/content preview --}}
<div id="carouselModal" class="fixed inset-0 bg-opacity-60  hidden items-center justify-center bg-black/60 z-[999] p-4">
    <div class="bg-white rounded-lg w-full max-w-3xl relative">
        <button id="carouselModalClose" class="absolute right-1 top-[-10px] text-2xl font-bold text-red-600 ">×</button>
        <div id="carouselModalBody" class="p-4 mt-14 rounded-lg ">
            {{-- populated by JS --}}
        </div>
    </div>
</div>

<script>
/*
    Center-focused, zoom-in infinite carousel.
    - clones all slides at front and back for smooth infinite loop
    - centers current index in viewport exactly
    - supports responsive: 1 / 2 / 3 visible but ALWAYS single-card scroll
    - supports types: 'video', 'image', 'audio', 'content'
*/

(function () {
    const rawItems = @json($items);
    const type = "{{ $type }}";
    const autoplay = {{ $autoplay ? 'true' : 'false' }};
    const speed = {{ (int)$speed }};
    const centerScale = parseFloat({{ $centerScale }});
    const sideScale = parseFloat({{ $sideScale }});

    // DOM refs
    const viewport = document.getElementById('carouselViewport');
    const track = document.getElementById('carouselTrack');
    const prevBtn = document.getElementById('carouselPrev');
    const nextBtn = document.getElementById('carouselNext');
    const modal = document.getElementById('carouselModal');
    const modalBody = document.getElementById('carouselModalBody');
    const modalClose = document.getElementById('carouselModalClose');

    if (!rawItems || rawItems.length === 0) {
        track.innerHTML = '<div class=" text-center w-full ">No slides found.</div>';
        return;
    }

    // Build slide markup
    function createSlideHTML(item, idx, isClone = false) {
        const id = item.id ?? idx;
        const common = `data-index="${idx}" data-id="${id}" data-clone="${isClone ? 1 : 0}" class="carousel-slide flex-shrink-0 mx-3 transition-transform duration-400 "`;
        // slide inner container, with clickable area for preview
        if (type === 'video') {
            const thumb = item.thumbnail ?? item.image ?? '';
            const vurl = item.videoUrl ?? item.url ?? '';
            return `<div ${common} role="group" aria-label="slide ${idx}">
                        <div class="rounded-xl overflow-hidden bg-white border shadow-md cursor-pointer preview-btn border-2 hover:border-green-500" data-type="video" data-src="${escapeHtml(vurl)}">
                            <div class="aspect-video relative">
                                <img src="${escapeHtml(thumb)}" alt="${escapeHtml(item.title ?? item.name ?? '')}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-50 hover:opacity-100 transition-opacity ">
                                    <div class="w-14 h-14 bg-primary rounded-full flex items-center justify-center">
                                        <div class="w-0 h-0 border-l-[20px] border-l-white border-t-[12px] border-t-transparent border-b-[12px] border-b-transparent ml-1"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="text-lg font-semibold mb-2">${escapeHtml(item.quote ?? '')}</div>
                                <div class="text-muted-foreground text-sm">— ${escapeHtml(item.name ?? item.title ?? '')}</div>
                            </div>
                        </div>
                    </div>`;
        } else if (type === 'image') {
            const img = item.image ?? item.url ?? item.thumbnail ?? '';
            return `<div ${common} role="group" aria-label="slide ${idx}">
                        <div class="rounded-xl overflow-hidden bg-white border shadow-sm cursor-pointer preview-btn" data-type="image" data-src="${escapeHtml(img)}">
                            <div class="aspect-video">
                                <img src="${escapeHtml(img)}" alt="${escapeHtml(item.title ?? '')}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-3">
                                <div class="text-muted-foreground text-sm">${escapeHtml(item.title ?? '')}</div>
                            </div>
                        </div>
                    </div>`;
        } else if (type === 'audio') {
            const art = item.thumbnail ?? item.cover ?? '';
            const aurl = item.audioUrl ?? item.url ?? '';
            return `<div ${common} role="group" aria-label="slide ${idx}">
                        <div class="rounded-xl overflow-hidden bg-white border shadow-sm p-4">
                            <div class="flex items-center gap-4">
                                <div class="w-24 h-24 rounded-md overflow-hidden bg-gray-100">
                                    <img src="${escapeHtml(art)}" class="w-full h-full object-cover" alt="">
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold">${escapeHtml(item.title ?? item.name ?? '')}</div>
                                    <div class="text-sm text-muted-foreground mb-3">${escapeHtml(item.subtitle ?? '')}</div>
                                    <audio controls class="w-full" src="${escapeHtml(aurl)}"></audio>
                                </div>
                            </div>
                        </div>
                    </div>`;
        } else { // content
            const html = escapeHtml(item.content ?? item.description ?? item.title ?? '');
            return `<div ${common} role="group" aria-label="slide ${idx}">
                        <div class="rounded-xl overflow-hidden bg-white border shadow-sm p-4">
                            <div class="text-lg font-semibold mb-2">${escapeHtml(item.title ?? '')}</div>
                            <div class="text-sm text-muted-foreground">${html}</div>
                        </div>
                    </div>`;
        }
    }

    // Escape helper (simple)
    function escapeHtml(s = '') {
        return String(s)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    // Build track: simple approach without clones
    const original = rawItems.slice();
    const slidesHTML = [];

    // original order only
    for (let i = 0; i < original.length; i++) {
        slidesHTML.push(createSlideHTML(original[i], i, false));
    }

    track.innerHTML = slidesHTML.join('');

    // query slides array
    let allSlides = Array.from(track.children);
    const totalSlides = allSlides.length;
    const originalCount = original.length;

    // Index logic:
    let logicalIndex = 0;
    let domIndex = logicalIndex;

    // sizing and responsive visible count
    function getVisibleCount() {
        const w = window.innerWidth;
        if (w < 640) return 1;      // mobile
        if (w < 1024) return 2;     // tablet
        return 3;                   // desktop
    }

    let visibleCount = getVisibleCount();

    // compute sizes: slideWidth = computed from first slide bounding rect
    let slideWidth = 0;
    let viewportWidth = 0;

    function recalcSizes() {
        visibleCount = getVisibleCount();
        viewportWidth = viewport.clientWidth;
        // Ensure slides have widths: we set slide width with flex-basis via JS for exact pixel math
        const gapPx = 24; // we used mx-3 on slides -> 12px both sides = 24px gap
        // Calculate slide width based on visible count and gaps
        // Formula: (viewportWidth - (visibleCount * gapPx)) / visibleCount
        if (visibleCount === 1) {
            slideWidth = Math.round(viewportWidth * 0.8);
        } else if (visibleCount === 2) {
            slideWidth = Math.round((viewportWidth - (2 * gapPx)) / 2);
        } else {
            slideWidth = Math.round((viewportWidth - (3 * gapPx)) / 3);
        }
        // apply width to all slides
        allSlides.forEach(s => {
            s.style.width = slideWidth + 'px';
            s.style.flexShrink = '0';
        });
        // reposition to center current domIndex
        moveToDomIndex(domIndex, false);
    }

    // positioning calculation for multiple slides
    function calcTranslateFor(domIx) {
        const gapPx = 24;
        const slideFull = slideWidth + gapPx;
        
        if (visibleCount === 1) {
            // Center the single slide
            const slideCenterX = domIx * slideFull + (slideWidth / 2);
            const vpCenter = viewportWidth / 2;
            return -(slideCenterX - vpCenter);
        } else {
            // For multiple slides, align to show the correct group
            // Position so that current slide is at the correct position in the visible group
            const targetPosition = Math.floor(visibleCount / 2);
            const targetIndex = Math.max(0, Math.min(domIx - targetPosition, originalCount - visibleCount));
            return -(targetIndex * slideFull);
        }
    }

    // apply transform with scaling classes
    function applyTransform(translateX, animate = true) {
        if (!animate) {
            track.style.transition = 'none';
        } else {
            track.style.transition = 'transform .45s cubic-bezier(.2,.9,.3,1)';
        }
        track.style.transform = `translateX(${translateX}px)`;
        // scale classes: center scale and side scale
        allSlides.forEach((s, i) => {
            const slideDomIndex = i;
            
            if (visibleCount === 1) {
                // Single slide mode - scale current slide
                if (slideDomIndex === domIndex) {
                    s.style.transform = `scale(${centerScale})`;
                    s.style.zIndex = 30;
                } else {
                    s.style.transform = `scale(${sideScale})`;
                    s.style.zIndex = 10;
                }
            } else {
                // Multiple slides mode - scale based on actual visible position
                // Get the current translate to determine which slides are visible
                const currentTranslate = parseInt(track.style.transform.replace(/[^-\d.]/g, '')) || 0;
                const visibleStartIndex = Math.max(0, Math.min(Math.floor(-currentTranslate / (slideWidth + 24)), originalCount - visibleCount));
                
                // Determine which slide is in the middle position
                const middlePosition = visibleStartIndex + Math.floor(visibleCount / 2);
                const distance = Math.abs(slideDomIndex - middlePosition);
                
                if (distance === 0) {
                    // This is the middle slide - make it largest
                    s.style.transform = `scale(${centerScale})`;
                    s.style.zIndex = 30;
                } else if (distance === 1 && visibleCount >= 2) {
                    // Adjacent slides - medium size
                    s.style.transform = `scale(${sideScale})`;
                    s.style.zIndex = 20;
                } else {
                    // Far slides - smallest
                    s.style.transform = `scale(${sideScale * 0.9})`;
                    s.style.zIndex = 10;
                }
            }
        });
    }

    function moveToDomIndex(newDomIndex, animate = true) {
        domIndex = newDomIndex;
        const tx = calcTranslateFor(domIndex);
        applyTransform(tx, animate);
    }

    // next / prev with simple circular handling
    function goNext() {
        logicalIndex = (logicalIndex + 1) % originalCount;
        domIndex = logicalIndex;
        moveToDomIndex(domIndex, true);
    }

    function goPrev() {
        logicalIndex = (logicalIndex - 1 + originalCount) % originalCount;
        domIndex = logicalIndex;
        moveToDomIndex(domIndex, true);
    }

    // autoplay
    let autoplayTimer = null;
    function startAutoplay() {
        if (!autoplay) return;
        stopAutoplay();
        autoplayTimer = setInterval(goNext, speed);
    }
    function stopAutoplay() {
        if (autoplayTimer) { clearInterval(autoplayTimer); autoplayTimer = null; }
    }

    // Touch swipe support
    let startX = 0, deltaX = 0;
    track.addEventListener('touchstart', (e) => {
        stopAutoplay();
        startX = e.touches[0].clientX;
    }, {passive: true});
    track.addEventListener('touchmove', (e) => {
        deltaX = e.touches[0].clientX - startX;
    }, {passive: true});
    track.addEventListener('touchend', (e) => {
        if (Math.abs(deltaX) > 40) {
            if (deltaX < 0) goNext(); else goPrev();
        }
        deltaX = 0;
        startAutoplay();
    });

    // pointer drag (desktop)
    let isDragging = false, dragStartX = 0, dragDelta = 0;
    track.addEventListener('pointerdown', (e) => {
        isDragging = true;
        dragStartX = e.clientX;
        track.style.cursor = 'grabbing';
        stopAutoplay();
    });
    window.addEventListener('pointermove', (e) => {
        if (!isDragging) return;
        dragDelta = e.clientX - dragStartX;
    });
    window.addEventListener('pointerup', (e) => {
        if (!isDragging) return;
        isDragging = false;
        track.style.cursor = '';
        if (Math.abs(dragDelta) > 50) {
            if (dragDelta < 0) goNext(); else goPrev();
        }
        dragDelta = 0;
        startAutoplay();
    });

    // click handlers for preview buttons (delegation)
    track.addEventListener('click', (e) => {
        const btn = e.target.closest('.preview-btn');
        if (!btn) return;
        const dtype = btn.dataset.type;
        const src = btn.dataset.src;
        openPreview(dtype, src);
    });

    // openPreview: populate modal with appropriate element and autoplay if video/audio
    function openPreview(dtype, src) {
        modalBody.innerHTML = '';
        if (!src) return;
        if (dtype === 'video') {
            // convert vimeo page URL to embed if needed
            let embed = src;
            if (embed.includes('vimeo.com') && !embed.includes('player.vimeo.com')) {
                const match = embed.match(/vimeo.com\/(\d+)/);
                if (match && match[1]) embed = `https://player.vimeo.com/video/${match[1]}?autoplay=1&muted=0`;
            } else if (embed.includes('youtube.com') || embed.includes('youtu.be')) {
                // youtube handling
                const idMatch = embed.includes('youtube.com') ? embed.split('v=')[1] : embed.split('/').pop();
                const id = (idMatch || '').split('&')[0];
                if (id) embed = `https://www.youtube.com/embed/${id}?autoplay=1`;
            } else {
                // assume direct video URL, use <video>
                modalBody.innerHTML = `<video controls autoplay class="w-full rounded">${createSourceTag(src)}</video>`;
                modal.classList.remove('hidden'); return;
            }
            modalBody.innerHTML = `<div class="aspect-video"><iframe src="${embed}" frameborder="0" allow="autoplay; fullscreen" allowfullscreen class="w-full h-full rounded-lg"></iframe></div>`;
        } else if (dtype === 'image') {
            modalBody.innerHTML = `<img src="${escapeHtml(src)}" class="w-full h-auto rounded">`;
        } else if (dtype === 'audio') {
            modalBody.innerHTML = `<audio controls autoplay class="w-full"><source src="${escapeHtml(src)}"></audio>`;
        } else {
            modalBody.innerHTML = `<div>${escapeHtml(src)}</div>`;
        }
        modal.classList.remove('hidden');
        stopAutoplay();
    }

    function createSourceTag(src) {
        return `<source src="${escapeHtml(src)}">`;
    }

    // modal close behaviors
    modalClose.addEventListener('click', () => {
        modal.classList.add('hidden');
        modalBody.innerHTML = '';
        startAutoplay();
    });
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modalBody.innerHTML = '';
            startAutoplay();
        }
    });

    // Prev/Next click
    prevBtn.addEventListener('click', () => { goPrev(); });
    nextBtn.addEventListener('click', () => { goNext(); });

    // pause on hover
    viewport.addEventListener('mouseenter', stopAutoplay);
    viewport.addEventListener('mouseleave', startAutoplay);

    // initial positioning
    // after DOM paints, re-query slides and sizes
    function init() {
        allSlides = Array.from(track.children);
        // set initial domIndex to first slide
        logicalIndex = 0;
        domIndex = logicalIndex;
        recalcSizes();
        // initial small delay to allow layout
        setTimeout(() => {
            moveToDomIndex(domIndex, false);
        }, 100);
        startAutoplay();
    }

    // resize observer
    window.addEventListener('resize', () => {
        recalcSizes();
    });

    // init now
    init();

})(); // IIFE
</script>



{{-- 

C) Images
@php
$imgs = [
  ['image'=>'/storage/gallery/1.jpg','title'=>'Sunset'],
  ['image'=>'/storage/gallery/2.jpg','title'=>'River'],
  // ...
];
@endphp
<x-carousel :items="$imgs" type="image" />

D) Audio
@php
$audios = [
  ['title'=>'Episode 1','audioUrl'=>'/audio/ep1.mp3','thumbnail'=>'/img/ep1.jpg'],
  // ...
];
@endphp
<x-carousel :items="$audios" type="audio" />

E) Content (arbitrary HTML-safe text)
@php
$posts = [
  ['title'=>'Card 1','content'=>'Short excerpt...'],
  // ...
];
@endphp
<x-carousel :items="$posts" type="content" />


--}}