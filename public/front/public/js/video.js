const video = document.getElementById('secureVideo');

window.addEventListener('blur', () => {
    video.classList.add('video-blurred');
    video.pause();
});

window.addEventListener('focus', () => {
    video.classList.remove('video-blurred');
});
