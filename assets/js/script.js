// assets/js/script.js
// Confirmation de suppression
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', e => {
            if (!confirm('Confirmer la suppression ?')) {
                e.preventDefault();
            }
        });
    });
});