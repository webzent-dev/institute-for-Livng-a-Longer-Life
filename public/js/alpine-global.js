document.addEventListener("alpine:init", () => {

    /* --------------------------------------------
    | GLOBAL THEME STORE (Light / Dark)
    --------------------------------------------- */
    Alpine.store("theme", {
        mode: localStorage.getItem("theme") || "light",

        toggle() {
            this.mode = this.mode === "light" ? "dark" : "light";
            localStorage.setItem("theme", this.mode);
            document.documentElement.classList.toggle("dark", this.mode === "dark");
        },

        init() {
            document.documentElement.classList.toggle("dark", this.mode === "dark");
        }
    });


    /* --------------------------------------------
    | SIDEBAR STORE
    --------------------------------------------- */
    Alpine.store("sidebar", {
        open: localStorage.getItem("sidebar_open") === "true",

        toggle() {
            this.open = !this.open;
            localStorage.setItem("sidebar_open", this.open);
        },

        close() {
            this.open = false;
            localStorage.setItem("sidebar_open", "false");
        }
    });


    /* --------------------------------------------
    | GLOBAL TOAST SYSTEM
    --------------------------------------------- */
    Alpine.store("toast", {
        items: [],

        show(message, type = "success", timeout = 3000) {
            const id = Date.now();
            this.items.push({ id, message, type });

            // Auto-remove toast
            setTimeout(() => {
                this.items = this.items.filter(t => t.id !== id);
            }, timeout);
        },

        success(msg) { this.show(msg, "success"); },
        error(msg) { this.show(msg, "error", 4500); },
        warning(msg) { this.show(msg, "warning", 5000); },
        info(msg) { this.show(msg, "info"); }
    });


    /* --------------------------------------------
    | NOTIFICATIONS PANEL STORE
    --------------------------------------------- */
    Alpine.store("notify", {
        open: false,
        list: [
            // Example notifications (replace with backend)
            { id: 1, text: "Welcome to your dashboard!", time: "2m ago", read: false },
            { id: 2, text: "Your profile is updated.", time: "30m ago", read: false },
        ],

        toggle() { this.open = !this.open; },
        close() { this.open = false; },

        markRead(id) {
            let n = this.list.find(n => n.id === id);
            if (n) n.read = true;
        },

        markAllRead() {
            this.list.forEach(n => n.read = true);
        },

        unreadCount() {
            return this.list.filter(n => !n.read).length;
        }
    });


    /* --------------------------------------------
    | GLOBAL SEARCH STORE
    --------------------------------------------- */
    Alpine.store("search", {
        term: "",
        open: false,

        toggle() { this.open = !this.open; },
        close() { this.open = false; },
        clear() { this.term = ""; }
    });


    /* --------------------------------------------
    | GLOBAL MODAL STORE (For Any Modal Component)
    --------------------------------------------- */
    Alpine.store("modal", {
        id: null,
        open(id) { this.id = id; },
        close() { this.id = null; },
        isOpen(id) { return this.id === id; }
    });


    /* --------------------------------------------
    | GLOBAL DROPDOWN STORE
    --------------------------------------------- */
    Alpine.store("dropdown", {
        active: null,

        toggle(id) {
            this.active = this.active === id ? null : id;
        },

        close() {
            this.active = null;
        },

        isOpen(id) {
            return this.active === id;
        }
    });


    /* --------------------------------------------
    | GLOBAL LOADER STORE
    --------------------------------------------- */
    Alpine.store("loader", {
        loading: false,
        show() { this.loading = true; },
        hide() { this.loading = false; }
    });


    /* --------------------------------------------
    | GLOBAL EVENT BUS  (Cross-component messaging)
    --------------------------------------------- */
    Alpine.store("bus", {
        events: {},

        on(event, callback) {
            (this.events[event] = this.events[event] || []).push(callback);
        },

        emit(event, payload) {
            (this.events[event] || []).forEach(cb => cb(payload));
        }
    });


});
