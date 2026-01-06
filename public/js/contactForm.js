function contactForm() {
    return {
        form: {
            firstName: "",
            lastName: "",
            email: "",
            phone: "",
            subject: "",
            description: "",
        },

        errors: {},
        successMsg: "",

        /* Validate single field */
        validateField(field) {
            const rule = validators.rules[field];
            if (!rule) return;

            const result = rule(this.form[field], this.form);
            this.errors[field] = result === true ? "" : result;
        },

        /* Sanitize if needed */
        sanitizeField(field, filter) {
            if (filter && validators.sanitize[filter]) {
                this.form[field] = validators.sanitize[filter](this.form[field]);
            }
        },

        /* Clear error on input focus */
        clearError(field) {
            delete this.errors[field];
        },

        /* Validate all fields */
        validateAllFields() {
            Object.keys(this.form).forEach(field => this.validateField(field));
            return Object.values(this.errors).every(v => !v);
        },

        /* Submit form */
        submitForm() {
            this.validateAllFields();

           fetch("{{ route('contact/form') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(this.form)
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Success:", data.message);
                        alert(data.message);
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Something went wrong!");
                    });
            console.log("Form submitted", this.form);
            // Use the global toast system
            Alpine.store("toast").success("Message sent successfully!");

            this.successMsg = "Your message has been sent!";

             if (Object.keys(this.errors).length > 0) {
                this.successMsg = "somthing went wrong!";
                return;
            }
        },

        /* Reset form */
        resetForm() {
            this.form = {
                firstName: "",
                lastName: "",
                email: "",
                phone: "",
                subject: "",
                description: "",
            };
            this.errors = {};
            this.successMsg = "";
        }
    }
}
