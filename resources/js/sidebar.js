document.addEventListener("alpine:init", () => {
    Alpine.store("sidebar", {
        open: true,
        mobileOpen: false,
        isMobile: window.innerWidth < 768,

        toggle() {
            this.isMobile
                ? (this.mobileOpen = !this.mobileOpen)
                : (this.open = !this.open);

            document.cookie = `sidebar:state=${this.open}; path=/; max-age=${60 * 60 * 24 * 7}`;
        },

        init() {
            window.addEventListener("resize", () => {
                this.isMobile = window.innerWidth < 768;
            });

            window.addEventListener("keydown", (e) => {
                if ((e.ctrlKey || e.metaKey) && e.key === "b") {
                    e.preventDefault();
                    this.toggle();
                }
            });
        },
    });
});
