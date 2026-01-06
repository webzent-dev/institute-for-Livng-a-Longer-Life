<div 
    {{-- x-data="membershipModal()"  --}}
    {{-- x-cloak  --}}
    {{-- @open-membership-modal.window="open($event.detail)" --}}
    {{-- x-show="openFlag" --}}
        id="membership-modal"
    class="close-modal fixed inset-0 z-50 flex items-center justify-center"
>

    <!-- overlay (click to close) -->
    <div   class="fixed inset-0 bg-black/70"   onclick="document.getElementById('modal-2').classList.add('hidden')"> </div>

    <!-- dialog -->
    <div 
        class="relative z-50 w-full max-w-lg bg-white rounded-lg shadow-lg p-6 mx-4"
        {{-- x-show="openFlag"
        x-transition --}}
        {{-- @click.stop --}}
    >
        <!-- close btn -->
        <button type="button"  onclick="document.getElementById('modal-2').classList.add('hidden')"   
        class="absolute top-3 right-3 text-gray-600 text-xl">✕</button>

        <!-- title -->
        <h2 class="text-xl font-semibold mb-4">
            Join <span x-text="plan.name"></span>
        </h2>

        <!-- price -->
        <p class="text-sm text-gray-600 mb-4">
            <span x-text="plan.price + ' / ' + plan.period"></span>
        </p>

        <!-- FORM -->
        <form @submit.prevent="submitForm" class="space-y-3">
            <input class="w-full border p-2 rounded" placeholder="First Name" x-model="form.firstName">
            <input class="w-full border p-2 rounded" placeholder="Last Name" x-model="form.lastName">
            <input type="email" class="w-full border p-2 rounded" placeholder="Email" x-model="form.email">
            <input type="tel" class="w-full border p-2 rounded" placeholder="Phone" x-model="form.phone">
            <input type="password" class="w-full border p-2 rounded" placeholder="Password" x-model="form.password">
            <input type="password" class="w-full border p-2 rounded" placeholder="Confirm Password" x-model="form.confirmPassword">

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">
                Register Now123
            </button>

            <button type="button" @click="close()" class="w-full border py-2 rounded">
                Cancel
            </button>
        </form>
    </div>
    
</div>

<script>

    // function close() { 
    //     document.getElementById('modal-2').classList.add('hidden');
    //     console.log('Modal closed....');
    // }
    // function closeModal() {
    //     document.getElementById('modal-2').classList.add('hidden');
    //     console.log('Modal closed');
    //     alert('Modal closed');
    // }

export default function membershipModal() {
    return {
        openFlag: false,
        plan: { name: "", price: "", period: "" },

        form: {
            firstName: "",
            lastName: "",
            email: "",
            phone: "",
            password: "",
            confirmPassword: ""
        },

        open(plan) {
            this.resetForm();
            this.plan = plan;
            this.openFlag = true;
            document.body.classList.add("overflow-hidden");
        },

        close() {
            this.openFlag = false;
            document.body.classList.remove("overflow-hidden");
        },

        resetForm() {
            this.form = {
                firstName: "",
                lastName: "",
                email: "",
                phone: "",
                password: "",
                confirmPassword: ""
            };
        },

        submitForm() {
            alert("Form Submitted!");
            this.close();
        }
    };
}

</script>
