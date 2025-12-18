document.addEventListener('keydown', function (e) {
    if (e.key === 'PrintScreen') {
        e.preventDefault();
        document.body.style.filter = 'blur(12px)';
        alert('Screenshots are not allowed.');
        setTimeout(() => {
            document.body.style.filter = 'none';
        }, 1500);
    }
});


document.addEventListener('keyup', (e) => {
    if (e.key === 'PrintScreen') {
        e.preventDefault();
        document.body.style.filter = 'blur(12px)';
        navigator.clipboard.writeText('');
        alert('Screenshots are disabled!');
        setTimeout(() => {
            document.body.style.filter = 'none';
        }, 1500);

    }
});

$(document).on('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        alert('Printing is disabled!');
        e.preventDefault();
    }
});


document.addEventListener('keydown', function (e) {
    // F12
    if (e.key === 'F12') {
        e.preventDefault();
        return false;
    }

    // Ctrl+Shift+I / Ctrl+Shift+J / Ctrl+Shift+C
    if (e.ctrlKey && e.shiftKey && ['I', 'J', 'C'].includes(e.key)) {
        e.preventDefault();
        return false;
    }

    // Ctrl+U (view source)
    if (e.ctrlKey && e.key === 'u') {
        e.preventDefault();
        return false;
    }

    // Cmd equivalents (Mac)
    if (e.metaKey && e.altKey && ['I', 'J', 'C'].includes(e.key)) {
        e.preventDefault();
        return false;
    }
});

document.addEventListener('contextmenu', e => e.preventDefault());

(function () {
    let devtoolsOpen = false;
    const threshold = 160;

    setInterval(() => {
        const widthDiff  = window.outerWidth - window.innerWidth;
        const heightDiff = window.outerHeight - window.innerHeight;

        if (widthDiff > threshold || heightDiff > threshold) {
            if (!devtoolsOpen) {
                devtoolsOpen = true;
                onDevToolsOpen();
            }
        } else {
            devtoolsOpen = false;
        }
    }, 500);

    function onDevToolsOpen() {
        document.body.style.filter = 'blur(12px)';
        document.body.innerHTML = `
            <div style="
                height:100vh;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:24px;
                font-weight:600;
                text-align:center;
            ">
                ⚠️ Developer tools are not allowed on this page.
            </div>
        `;
    }
})();
