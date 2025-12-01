 
<div x-data="toaster()" x-cloak class="fixed z-[9999] right-4 bottom-6 space-y-2">
  <template x-for="t in toasts" :key="t.id">
    <div x-show="t.open" x-transition class="max-w-sm rounded-lg p-4 shadow-lg ring-1 ring-black/5 bg-card">
      <div class="flex items-start gap-3">
        <div class="flex-shrink-0">
          <template x-if="t.type === 'success'">
            <svg class="h-5 w-5 text-green-600" viewBox="0 0 24 24" fill="none"><path d="M9 12.5L11.5 15L15 10.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </template>
          <template x-if="t.type === 'error'">
            <svg class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none"><path d="M6 6L18 18M6 18L18 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </template>
          <template x-if="t.type === 'info'">
            <svg class="h-5 w-5 text-primary" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><path d="M12 8v.01M12 12v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </template>
        </div>

        <div class="flex-1">
          <div class="text-sm font-semibold" x-text="t.title"></div>
          <div class="text-sm text-muted-foreground" x-html="t.description"></div>
        </div>

        <button @click="dismiss(t.id)" class="ml-4 opacity-70 hover:opacity-100">
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"><path d="M6 6L18 18M6 18L18 6" stroke="currentColor" stroke-width="1.5"/></svg>
        </button>
      </div>
    </div>
  </template>
</div>

<script>
  function toaster() {
    return {
      toasts: [],
      nextId: 1,
      init() {
        // show any server-side flash toasts (Laravel session)
        @if(session('toast'))
          this.show(@json(session('toast')));
        @endif
      },
      show({ title = '', description = '', type = 'info', timeout = 5000 } = {}) {
        const id = this.nextId++;
        const t = { id, title, description, type, open: true };
        this.toasts.push(t);
        setTimeout(() => this.dismiss(id), timeout);
      },
      dismiss(id) {
        const idx = this.toasts.findIndex(x => x.id === id);
        if (idx === -1) return;
        this.toasts[idx].open = false;
        setTimeout(() => {
          this.toasts = this.toasts.filter(x => x.id !== id);
        }, 350);
      }
    }
  }

  // expose global helper
  window.showToast = function({ title = '', description = '', type = 'info', timeout = 5000 } = {}) {
    window.dispatchEvent(new CustomEvent('show-toast', { detail: { title, description, type, timeout } }));
  };

  // listen for global event and call alpine component
  window.addEventListener('show-toast', (e) => {
    const detail = e.detail || {};
    // find the Alpine toaster component and call show
    const root = document.querySelector('[x-data="toaster()"]');
    if (root && root.__x) {
      // Alpine v3 internal access
      const component = root.__x.getUnobservedData ? root.__x.getUnobservedData() : root.__x.$data;
      if (component && component.show) component.show(detail);
    } else {
      // fallback: create a toast element if Alpine not initialized
      console.warn('Toaster not found');
    }
  });
</script>
