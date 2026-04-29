<div class="fixed bottom-4 right-4 space-y-2 z-50">

    <template x-for="toast in toasts.list">
        <div 
            class="px-4 py-3 rounded-lg shadow bg-white dark:bg-gray-800 border"
            x-text="toast.message"
        ></div>
    </template>

</div>
{{-- Usage Example --}}
{{-- <script>
    function toastComponent() {
        return {
            toasts: {
                list: [],
                add(message, duration = 3000) {
                    const id = Date.now();
                    this.list.push({ id, message });
                    setTimeout(() => {
                        this.remove(id);
                    }, duration);
                },
                remove(id) {
                    this.list = this.list.filter(toast => toast.id !== id);
                },
            },
        };
    }
</script>    --}}