var pageVisibility = 'visible';

document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        if (pageVisibility === 'visible') {
            Swal.fire({
                html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                        <div class="pt-2 mt-4 fs-15">
                            <h4>Attention!</h4>
                            <p class="mx-4 mb-0 text-muted">You are not allowed to switch tabs during the exam!</p>
                        </div>
                    </div>
                    `,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: "btn btn-primary w-xs mb-1",
                },
                cancelButtonText: "Back",
                buttonsStyling: false,
                showCloseButton: true,
            });
        }
    }
    pageVisibility = document.hidden ? 'hidden' : 'visible';
});

let devtoolsOpen = false;
setInterval(function() {
    const threshold = 160;
    const widthThreshold = window.outerWidth - window.innerWidth > threshold;
    const heightThreshold = window.outerHeight - window.innerHeight > threshold;

    if (widthThreshold || heightThreshold) {
        devtoolsOpen = true;
        Swal.fire({
            html: `
                <div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>
                    <div class="pt-2 mt-4 fs-15">
                        <h4>Attention!</h4>
                        <p class="mx-4 mb-0 text-muted">You are not allowed to open DevTools during the exam!</p>
                    </div>
                </div>
                `,
            showCancelButton: true,
            showConfirmButton: false,
            customClass: {
                cancelButton: "btn btn-primary w-xs mb-1",
            },
            cancelButtonText: "Back",
            buttonsStyling: false,
            showCloseButton: true,
        });
    }
}, 1000);

$(document).on('contextmenu', function(e) {
    e.preventDefault();
});

$(document).keydown(function(e) {
    if (e.key === "F12" || e.ctrlKey || e.key === "c" || e.key === "v" || e.key === "x" || e.key === "u") {
        e.preventDefault();
    }
});

$('body').css('user-select', 'none');

$(document).on('copy cut paste', function(e) {
    e.preventDefault();
});
