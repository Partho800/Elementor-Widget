/**
 * Uboontu Blog Scripts
 * Handles search, category filtering, AJAX-less pagination, TOC scroll spying, and sharing.
 */

document.addEventListener('DOMContentLoaded', function() {
    // ─── BLOG LIST INITIALIZATION ───
    if (typeof uboontu_blog_data !== 'undefined' && uboontu_blog_data.posts) {
        initBlogList();
    }

    // ─── SINGLE BLOG PAGE INITIALIZATION ───
    initSingleBlog();

    // ─── TESTIMONIALS MARQUEE INITIALIZATION ───
    initTestimonialsMarquee();
});

// State variables for Listing Page
let uboontuSearch = '';
let uboontuActiveCategory = 'Latest Blogs';
let uboontuCurrentPage = 1;
const UBOONTU_ITEMS_PER_PAGE = 9;

function initBlogList() {
    const searchInput = document.getElementById('uboontu-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            uboontuSearch = e.target.value;
            uboontuCurrentPage = 1;
            renderBlogGrid();
        });
    }

    // Generate unique categories dynamically from the post list
    const posts = uboontu_blog_data.posts;
    const categories = ['Latest Blogs'];
    const uniqueCats = [...new Set(posts.map(p => p.category).filter(Boolean))];
    uniqueCats.forEach(c => categories.push(c));

    const catsContainer = document.getElementById('uboontu-cats-container');
    if (catsContainer) {
        catsContainer.innerHTML = '';
        categories.forEach(cat => {
            const btn = document.createElement('button');
            btn.className = `blogs-cat-btn ${uboontuActiveCategory === cat ? 'active' : ''}`;
            btn.textContent = cat;
            btn.addEventListener('click', function() {
                uboontuActiveCategory = cat;
                uboontuCurrentPage = 1;
                
                // Update active classes on tabs
                catsContainer.querySelectorAll('.blogs-cat-btn').forEach(b => {
                    b.classList.toggle('active', b.textContent === cat);
                });
                
                renderBlogGrid();
            });
            catsContainer.appendChild(btn);
        });
    }

    renderBlogGrid();

    // Newsletter Submission mockup
    const newsletterForm = document.getElementById('uboontu-newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const successDiv = document.getElementById('uboontu-newsletter-success');
            if (successDiv) {
                successDiv.style.display = 'block';
                newsletterForm.style.display = 'none';
            }
        });
    }
}

function filterBlogPosts() {
    const searchLower = uboontuSearch.toLowerCase();
    return uboontu_blog_data.posts.filter(p => {
        const matchCat = uboontuActiveCategory === 'Latest Blogs' || p.category === uboontuActiveCategory;
        const matchSearch = p.title.toLowerCase().includes(searchLower) ||
                            (p.excerpt || '').toLowerCase().includes(searchLower) ||
                            (p.content && p.content.toLowerCase().includes(searchLower));
        return matchCat && matchSearch;
    });
}

function renderBlogCard(post) {
    // Generate the correct URL to single blog post
    let detailUrl;
    if (uboontu_blog_data.detail_page_url) {
        const separator = uboontu_blog_data.detail_page_url.includes('?') ? '&' : '?';
        detailUrl = `${uboontu_blog_data.detail_page_url}${separator}blog_slug=${post.slug}`;
    } else {
        const separator = window.location.search ? '&' : '?';
        // Preserve other search parameters but strip old blog_slug
        const params = new URLSearchParams(window.location.search);
        params.set('blog_slug', post.slug);
        detailUrl = `${window.location.pathname}?${params.toString()}`;
    }

    const imageSrc = post.image || uboontu_blog_data.fallback_image;

    return `
    <a href="${detailUrl}" class="blogs-card-wrapper" style="text-decoration: none;">
      <article class="blogs-card">
        <div class="blogs-card-thumb">
          <div class="blogs-card-img" style="background-image: url('${imageSrc}'); background-size: cover; background-position: center;"></div>
        </div>
        <div class="blogs-card-body">
          <h3 class="blogs-card-title">${post.title}</h3>
          <p class="blogs-card-desc">${post.excerpt}</p>
        </div>
      </article>
    </a>
    `;
}

function getPageNumbersArray(currentPage, totalPages) {
    const pages = [];
    if (totalPages <= 7) {
        for (let i = 1; i <= totalPages; i++) {
            pages.push(i);
        }
    } else {
        if (currentPage <= 4) {
            pages.push(1, 2, 3, 4, 5, '...', totalPages);
        } else if (currentPage >= totalPages - 3) {
            pages.push(1, '...', totalPages - 4, totalPages - 3, totalPages - 2, totalPages - 1, totalPages);
        } else {
            pages.push(1, '...', currentPage - 1, currentPage, currentPage + 1, '...', totalPages);
        }
    }
    return pages;
}

function renderBlogGrid() {
    const grid = document.getElementById('uboontu-blogs-grid');
    const emptyState = document.getElementById('uboontu-blogs-empty');
    const pagination = document.getElementById('uboontu-pagination');

    if (!grid) return;

    const filtered = filterBlogPosts();

    if (filtered.length === 0) {
        grid.style.display = 'none';
        emptyState.style.display = 'block';
        const strong = emptyState.querySelector('strong');
        if (strong) strong.textContent = uboontuSearch;
        if (pagination) pagination.style.display = 'none';
        return;
    }

    grid.style.display = 'grid';
    emptyState.style.display = 'none';

    const totalPages = Math.ceil(filtered.length / UBOONTU_ITEMS_PER_PAGE);
    const startIndex = (uboontuCurrentPage - 1) * UBOONTU_ITEMS_PER_PAGE;
    const paginated = filtered.slice(startIndex, startIndex + UBOONTU_ITEMS_PER_PAGE);

    grid.innerHTML = paginated.map(renderBlogCard).join('');

    // Render Pagination
    if (pagination) {
        if (totalPages > 1) {
            pagination.style.display = 'flex';
            pagination.innerHTML = '';

            const pageNumbers = getPageNumbersArray(uboontuCurrentPage, totalPages);
            pageNumbers.forEach((page, idx) => {
                if (page === '...') {
                    const dots = document.createElement('span');
                    dots.className = 'blogs-page-dots';
                    dots.textContent = '...';
                    pagination.appendChild(dots);
                } else {
                    const btn = document.createElement('button');
                    btn.className = `blogs-page-btn ${uboontuCurrentPage === page ? 'active' : ''}`;
                    btn.textContent = page;
                    btn.addEventListener('click', function() {
                        uboontuCurrentPage = page;
                        renderBlogGrid();
                        // Scroll to listing top
                        const listing = document.querySelector('.blogs-listing');
                        if (listing) {
                            listing.scrollIntoView({ behavior: 'smooth' });
                        }
                    });
                    pagination.appendChild(btn);
                }
            });

            // Add Next Button
            const nextBtn = document.createElement('button');
            nextBtn.className = 'blogs-page-next-btn';
            if (uboontuCurrentPage === totalPages) {
                nextBtn.disabled = true;
            }
            nextBtn.setAttribute('aria-label', 'Next Page');
            nextBtn.innerHTML = `
            <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M1 13L7 7L1 1" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            `;
            nextBtn.addEventListener('click', function() {
                if (uboontuCurrentPage < totalPages) {
                    uboontuCurrentPage++;
                    renderBlogGrid();
                    const listing = document.querySelector('.blogs-listing');
                    if (listing) {
                        listing.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
            pagination.appendChild(nextBtn);
        } else {
            pagination.style.display = 'none';
        }
    }
}

// ─── SINGLE BLOG PAGE INTERACTION ───
function initSingleBlog() {
    const mainContent = document.querySelector('.single-blog-main-content');
    if (!mainContent) return;

    // 1. Dynamic TOC Construction
    const headings = mainContent.querySelectorAll('h2, h3');
    const tocList = document.getElementById('uboontu-toc-list');
    
    if (tocList) {
        tocList.innerHTML = '';
        
        // Add Introduction link
        const introLi = document.createElement('li');
        introLi.innerHTML = `<a href="#introduction" class="single-blog-toc-link active" data-id="introduction">Introduction</a>`;
        tocList.appendChild(introLi);

        // Add dynamically parsed heading links
        headings.forEach((heading, idx) => {
            let id = heading.id;
            if (!id) {
                // Generate safe slug for heading
                id = heading.textContent.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)+/g, '');
                if (!id) id = `heading-${idx}`;
                heading.id = id;
            }
            const label = heading.textContent;
            const li = document.createElement('li');
            li.innerHTML = `<a href="#${id}" class="single-blog-toc-link" data-id="${id}">${label}</a>`;
            tocList.appendChild(li);
        });

        // Add Conclusion link
        const conclLi = document.createElement('li');
        conclLi.innerHTML = `<a href="#conclusion" class="single-blog-toc-link" data-id="conclusion">Conclusion</a>`;
        tocList.appendChild(conclLi);
    }

    // 2. Click handler for smooth scroll offset
    document.addEventListener('click', function(e) {
        const link = e.target.closest('.single-blog-toc-link');
        if (link) {
            e.preventDefault();
            const id = link.getAttribute('data-id');
            const targetEl = document.getElementById(id);
            if (targetEl) {
                const offset = 100;
                const bodyRect = document.body.getBoundingClientRect().top;
                const targetRect = targetEl.getBoundingClientRect().top;
                const offsetPosition = targetRect - bodyRect - offset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        }
    });

    // 3. Table of Contents Scroll Progress Bar
    const progressBar = document.getElementById('uboontu-toc-progress');
    function updateScrollProgress() {
        if (!progressBar) return;
        const rect = mainContent.getBoundingClientRect();
        const elementTop = rect.top + window.scrollY;
        const elementHeight = rect.height;
        const viewportHeight = window.innerHeight;

        const startOffset = elementTop - viewportHeight;
        const endOffset = elementTop + elementHeight - 100;
        const currentScroll = window.scrollY;

        const totalScrollable = endOffset - startOffset;
        const scrolled = currentScroll - startOffset;

        let progress = (scrolled / totalScrollable) * 100;
        progress = Math.min(100, Math.max(0, progress));

        progressBar.style.width = progress + '%';
    }

    // 4. Heading Intersection Observer
    const tocLinks = document.querySelectorAll('.single-blog-toc-link');
    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -60% 0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const activeId = entry.target.id;
                tocLinks.forEach(link => {
                    link.classList.toggle('active', link.getAttribute('data-id') === activeId);
                });
            }
        });
    }, observerOptions);

    // Observe elements
    const elementsToObserve = [];
    const introEl = document.getElementById('introduction');
    if (introEl) elementsToObserve.push(introEl);
    headings.forEach(h => {
        if (h.id) elementsToObserve.push(h);
    });
    const conclusionEl = document.getElementById('conclusion');
    if (conclusionEl) elementsToObserve.push(conclusionEl);

    elementsToObserve.forEach(el => observer.observe(el));

    // Listen to scroll events
    window.addEventListener('scroll', updateScrollProgress, { passive: true });
    updateScrollProgress();

    // 5. Copy Link / Share action
    const shareBtn = document.getElementById('uboontu-share-btn');
    if (shareBtn) {
        shareBtn.addEventListener('click', function() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                const shareText = document.getElementById('uboontu-share-text');
                if (shareText) {
                    shareText.textContent = 'Link Copied!';
                    setTimeout(() => {
                        shareText.textContent = 'Share Article';
                    }, 2000);
                }
            }).catch(err => {
                console.error('Failed to copy link: ', err);
            });
        });
    }

    // 6. Donate cause button Custom Event
    const donateBtn = document.getElementById('uboontu-donate-btn');
    if (donateBtn) {
        donateBtn.addEventListener('click', function() {
            window.dispatchEvent(new CustomEvent('open-donate'));
        });
    }
}

// ─── TESTIMONIALS MARQUEE INTERACTIVE SLOWDOWN ───
function initTestimonialsMarquee() {
    const rows = document.querySelectorAll('.uboontu-testimonials-marquee-row');
    rows.forEach(row => {
        if (row.classList.contains('js-marquee-initialized')) return;
        row.classList.add('js-marquee-initialized');

        const track = row.querySelector('.uboontu-testimonials-marquee-track');
        if (!track) return;

        row.addEventListener('mouseenter', () => {
            if (typeof track.getAnimations === 'function') {
                const animations = track.getAnimations();
                animations.forEach(anim => {
                    anim.playbackRate = 0.25; // Slow down to 25% speed (4x slower)
                });
            }
        });

        row.addEventListener('mouseleave', () => {
            if (typeof track.getAnimations === 'function') {
                const animations = track.getAnimations();
                animations.forEach(anim => {
                    anim.playbackRate = 1.0; // Reset to normal speed
                });
            }
        });
    });
}

// Support Elementor edit mode live preview
if (window.jQuery) {
    jQuery(window).on('elementor/frontend/init', function() {
        if (window.elementorFrontend) {
            elementorFrontend.hooks.addAction('frontend/element_ready/uboontu_testimonials.default', function() {
                initTestimonialsMarquee();
            });
        }
    });
}
