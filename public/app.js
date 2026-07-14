document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-widget="pushmenu"]').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            if (window.matchMedia('(max-width: 991.98px)').matches) {
                document.body.classList.toggle('sidebar-open');
                document.body.classList.remove('sidebar-collapse');
            } else {
                document.body.classList.toggle('sidebar-collapse');
                document.body.classList.remove('sidebar-open');
            }
        });
    });

    document.addEventListener('click', function (event) {
        if (!window.matchMedia('(max-width: 991.98px)').matches) return;
        if (!document.body.classList.contains('sidebar-open')) return;
        if (event.target.closest('.main-sidebar') || event.target.closest('[data-widget="pushmenu"]')) return;
        document.body.classList.remove('sidebar-open');
    });

    function openFormModal(target) {
        var modal = typeof target === 'string' ? document.getElementById(target) : target;
        if (!modal) return;
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');

        var firstInput = modal.querySelector('input:not([type="hidden"]), select, textarea, button');
        if (firstInput) {
            window.setTimeout(function () { firstInput.focus(); }, 80);
        }
    }

    function closeFormModal(target) {
        var modal = target && target.classList && target.classList.contains('form-modal')
            ? target
            : target && target.closest
                ? target.closest('.form-modal')
                : document.querySelector('.form-modal[aria-hidden="false"]');

        if (!modal) return;
        modal.setAttribute('aria-hidden', 'true');

        if (!document.querySelector('.form-modal[aria-hidden="false"]')) {
            document.body.classList.remove('modal-open');
        }
    }

    window.openFormModal = openFormModal;
    window.closeFormModal = closeFormModal;

    document.querySelectorAll('[data-modal-open]').forEach(function (button) {
        button.addEventListener('click', function () {
            openFormModal(button.getAttribute('data-modal-open'));
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach(function (button) {
        button.addEventListener('click', function () {
            closeFormModal(button);
        });
    });

    document.querySelectorAll('.form-modal[data-modal-auto-open="true"]').forEach(function (modal) {
        openFormModal(modal);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeFormModal();
        }
    });
});
