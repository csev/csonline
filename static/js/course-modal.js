(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var modalEl = document.getElementById('courseModal');
        if (!modalEl || typeof bootstrap === 'undefined' || !bootstrap.Modal) {
            return;
        }

        var modal = new bootstrap.Modal(modalEl);
        var titleEl = document.getElementById('courseModalTitle');
        var bodyEl = document.getElementById('courseModalBody');

        document.querySelectorAll('.course-modal-open').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var key = btn.getAttribute('data-course');
                var tmpl = key && document.getElementById('course-modal-' + key);
                if (!titleEl || !bodyEl) {
                    return;
                }

                if (!tmpl || tmpl.tagName !== 'TEMPLATE') {
                    titleEl.textContent = 'Course';
                    bodyEl.replaceChildren();
                    var p = document.createElement('p');
                    p.className = 'course-modal-empty';
                    p.textContent =
                        'Add a <template id="course-modal-' +
                        (key || '') +
                        '"> in index.php with data-title and your HTML inside.';
                    bodyEl.appendChild(p);
                    modal.show();
                    return;
                }

                titleEl.textContent = tmpl.getAttribute('data-title') || 'Course details';

                bodyEl.replaceChildren();
                bodyEl.appendChild(tmpl.content.cloneNode(true));

                modal.show();
            });
        });
    });
})();
