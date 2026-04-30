
// Use global validators object loaded before this script
window.formEngine = function(initialForm = {}) {
    return {
        showPass: "",
        form: initialForm,
        errors: {},
        successMsg: "",

        validateField(field) {
            const rule = validators.rules[field];
            if (!rule) return;

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
            Object.keys(this.form).forEach(f => this.validateField(f));
            return Object.values(this.errors).every(v => !v);
        },

        resetForm() {
            Object.keys(this.form).forEach(f => this.form[f] = "");
            this.errors = {};
            this.successMsg = "";
        }
    };
}
