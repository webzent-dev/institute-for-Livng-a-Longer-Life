export default function carousel(items) {
    return {
        slides: items,
        index: 0,
        timer: null,
        autoSlide: true,
        interval: 6000,
        previewOpen: false,
        preview: {},

        init() {
            if (this.autoSlide) {
                this.timer = setInterval(() => this.next(), this.interval);
            }
        },

        next() {
            this.index = (this.index + 1) % this.slides.length;
        },

        prev() {
            this.index = (this.index - 1 + this.slides.length) % this.slides.length;
        },

        openPreview(slide) {
            this.preview = slide;
            this.previewOpen = true;
        },

        resetTimer() {
            clearInterval(this.timer);
            this.timer = setInterval(() => this.next(), this.interval);
        }
    };
}
 