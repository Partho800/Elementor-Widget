document.addEventListener('DOMContentLoaded', function() {
    const nextBtn = document.querySelector('.mss-next');
    const prevBtn = document.querySelector('.mss-prev');
    const slideList = document.querySelector('.mss-slide-list');

    if (!nextBtn || !prevBtn || !slideList) return;

    nextBtn.addEventListener('click', function() {
        let items = document.querySelectorAll('.mss-item');
        slideList.appendChild(items[0]);
    });

    prevBtn.addEventListener('click', function() {
        let items = document.querySelectorAll('.mss-item');
        slideList.prepend(items[items.length - 1]);
    });

    // Auto slide optional
    let autoPlay = setInterval(() => {
        nextBtn.click();
    }, 6000);

    // Pause on hover
    const container = document.querySelector('.mss-main-container');
    if (container) {
        container.addEventListener('mouseenter', () => clearInterval(autoPlay));
        container.addEventListener('mouseleave', () => {
            autoPlay = setInterval(() => {
                nextBtn.click();
            }, 6000);
        });
    }

    // Video Popup Card Logic
    $(document).on('click', '.mss-vc-play-btn', function(e) {
        e.preventDefault();
        console.log('Video button clicked!'); // Debug log
        
        var videoId = $(this).data('video-id');
        var widgetId = $(this).data('widget-id');
        console.log('Video ID:', videoId, 'Widget ID:', widgetId); // Debug log
        
        var modal = $('#mss-video-modal-' + widgetId);
        var iframe = $('#mss-iframe-' + widgetId);
        
        if (videoId && modal.length) {
            iframe.attr('src', 'https://www.youtube.com/embed/' + videoId + '?autoplay=1');
            modal.css('display', 'block').hide().fadeIn(300);
            console.log('Modal opened!');
        } else {
            console.error('Video ID or Modal not found!');
        }
    });

    $(document).on('click', '.mss-video-close', function(e) {
        e.preventDefault();
        var modal = $(this).closest('.mss-video-modal');
        var iframe = modal.find('iframe');
        
        modal.fadeOut(300, function() {
            iframe.attr('src', '');
        });
    });

    // Close modal on background click
    $(document).on('click', '.mss-video-modal', function(e) {
        if ($(e.target).hasClass('mss-video-modal')) {
            var modal = $(this);
            var iframe = modal.find('iframe');
            modal.fadeOut(300, function() {
                iframe.attr('src', '');
            });
        }
    });
});
