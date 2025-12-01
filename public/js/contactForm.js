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

            if (Object.keys(this.errors).length > 0) {
                this.successMsg = "";
                return;
            }

            // Use the global toast system
            Alpine.store("toast").success("Message sent successfully!");

            this.successMsg = "Your message has been sent!";
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
