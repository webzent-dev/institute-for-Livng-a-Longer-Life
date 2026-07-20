/**
 * Keeps the Vital Boost fields consistent on the admin product forms.
 *
 * Shared by the add-product modal (products index) and the edit form (product
 * detail) so both behave identically:
 *
 *   - Product Type and Category are coupled: choosing Vital Boost on one forces
 *     it on the other, and choosing a non-Vital-Boost value on one (while the
 *     other is Vital Boost) resets that other to a sensible default, so the
 *     admin can always switch back freely.
 *   - Vital Boost products belong to the Institute, so the User field is pinned
 *     to an admin and locked for as long as Vital Boost is selected.
 *
 * The owner rule is also enforced in AdminProductController::vitalBoostOwner();
 * this is the visible half. It matters because the Institute products list
 * joins users on role = admin, so a Vital Boost product owned by a collaborator
 * would not appear under any tab of the products screen.
 */
(function () {
    function initVitalBoostCoupling() {
        var category = document.querySelector('.vb-couple-category');
        var type = document.querySelector('.vb-couple-type');

        if (!category || !type) {
            return;
        }

        var user = document.querySelector('.vb-couple-user');
        var note = document.querySelector('.vb-couple-user-note');

        // A disabled <select> is not submitted, so while the field is locked a
        // hidden input carries user_id in its place.
        var hidden = null;

        function firstAdminOption() {
            return Array.prototype.find.call(user.options, function (option) {
                return option.dataset.role === 'admin';
            });
        }

        function selectedIsAdmin() {
            var selected = user.options[user.selectedIndex];
            return selected && selected.dataset.role === 'admin';
        }

        function syncUserLock() {
            if (!user) {
                return;
            }

            if (category.value !== 'vital_boost') {
                user.disabled = false;
                if (note) {
                    note.classList.add('hidden');
                }
                if (hidden) {
                    hidden.remove();
                    hidden = null;
                }
                return;
            }

            // Keep whichever admin is already chosen; otherwise pick the first.
            // An existing product owned by a collaborator is moved to an admin
            // here, which matches what the controller would do on save anyway.
            if (!selectedIsAdmin()) {
                var admin = firstAdminOption();
                if (admin) {
                    user.value = admin.value;
                }
            }

            user.disabled = true;
            if (note) {
                note.classList.remove('hidden');
            }

            if (!hidden) {
                hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'user_id';
                user.parentNode.appendChild(hidden);
            }
            hidden.value = user.value;
        }

        type.addEventListener('change', function () {
            if (type.value === 'vital_boost') {
                category.value = 'vital_boost';
            } else if (category.value === 'vital_boost') {
                category.value = 'institute';
            }
            syncUserLock();
        });

        category.addEventListener('change', function () {
            if (category.value === 'vital_boost') {
                type.value = 'vital_boost';
            } else if (type.value === 'vital_boost') {
                type.value = 'supplement';
            }
            syncUserLock();
        });

        // Run once so a saved Vital Boost product, or a form redisplayed with old
        // input, opens already locked.
        syncUserLock();
    }

    if (document.readyState !== 'loading') {
        initVitalBoostCoupling();
    } else {
        document.addEventListener('DOMContentLoaded', initVitalBoostCoupling);
    }
})();
