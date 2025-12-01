
function login() {
    return {
         showPass: "", 

        form: { email: "", password: "",   },

        errors: {},
        successMsg: "",

        validateField(field) {
            const rule = validators.rules[field];
            if (!rule) return;

            // dynamic arguments if needed
            const result = rule(this.form[field], this.form);

            this.errors[field] = result === true ? "" : result;
        },

        sanitizeField(field, filter) {
            if (filter && validators.sanitize[filter]) {
                this.form[field] = validators.sanitize[filter](this.form[field]);
            }
        },

        clearError(field) {
            delete this.errors[field];
        },

        validateAllFields() {
            Object.keys(this.form).forEach(field => this.validateField(field));
            return Object.values(this.errors).every(v => !v);
        },

        submitForm() {
            this.validateAllFields();

            if (Object.keys(this.errors).length > 0) {
                this.successMsg = "";
                return;
            }

            // Success
            this.successMsg = "Login successful!";
        } 
    }
}

