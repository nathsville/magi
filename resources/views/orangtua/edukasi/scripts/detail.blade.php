<script>
/**
 * Share article via Web Share API or fallback
 */
function shareArticle() {
    const title = "{{ $artikel['judul'] }}";
    const text = "{{ $artikel['ringkasan'] }}";
    const url = window.location.href;

    if (navigator.share) {
        navigator.share({
            title: title,
            text: text,
            url: url
        })
        .then(() => showToast('Artikel berhasil dibagikan!', 'success'))
        .catch(err => {
            if (err.name !== 'AbortError') {
                copyLink();
            }
        });
    } else {
        copyLink();
    }
}

/**
 * Share via WhatsApp
 */
function shareWhatsApp() {
    const title = "{{ $artikel['judul'] }}";
    const url = window.location.href;
    const text = encodeURIComponent(`*${title}*\n\n${url}\n\nBaca artikel kesehatan anak di MaGi - Sistem Monitoring Stunting`);
    
    window.open(`https://wa.me/?text=${text}`, '_blank');
}

/**
 * Share via Facebook
 */
function shareFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
}

/**
 * Copy article link to clipboard
 */
function copyLink() {
    const url = window.location.href;
    
    if (navigator.clipboard) {
        navigator.clipboard.writeText(url)
            .then(() => {
                showToast('Link artikel berhasil disalin!', 'success');
            })
            .catch(() => {
                fallbackCopyLink(url);
            });
    } else {
        fallbackCopyLink(url);
    }
}

/**
 * Fallback copy method for older browsers
 */
function fallbackCopyLink(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    
    try {
        document.execCommand('copy');
        showToast('Link artikel berhasil disalin!', 'success');
    } catch (err) {
        showToast('Gagal menyalin link', 'error');
    }
    
    document.body.removeChild(textarea);
}

/**
 * Print article
 */
function printArticle() {
    // Add print-specific styles
    const printStyle = document.createElement('style');
    printStyle.textContent = `
        @media print {
            body * {
                visibility: hidden;
            }
            article, article * {
                visibility: visible;
            }
            article {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
            a {
                text-decoration: none;
                color: inherit;
            }
        }
    `;
    document.head.appendChild(printStyle);
    
    window.print();
    
    // Remove print style after printing
    setTimeout(() => {
        document.head.removeChild(printStyle);
    }, 1000);
}

/**
 * Show toast notification
 */
function showToast(message, type = 'info') {
    const colors = {
        'info': 'bg-blue-500',
        'success': 'bg-green-500',
        'warning': 'bg-orange-500',
        'error': 'bg-red-500'
    };

    const icons = {
        'info': 'fa-info-circle',
        'success': 'fa-check-circle',
        'warning': 'fa-exclamation-circle',
        'error': 'fa-times-circle'
    };

    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-2xl z-50 animate-slideDown`;
    toast.innerHTML = `
        <div class="flex items-center space-x-3">
            <i class="fas ${icons[type]} text-xl"></i>
            <span class="font-medium">${message}</span>
        </div>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('animate-slideDown');
        toast.classList.add('animate-slideUp');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/**
 * Reading progress indicator
 */
document.addEventListener('DOMContentLoaded', function() {
    // Create progress bar
    const progressBar = document.createElement('div');
    progressBar.className = 'fixed top-0 left-0 h-1 bg-gradient-to-r from-purple-600 to-pink-600 z-50 transition-all duration-300';
    progressBar.style.width = '0%';
    document.body.appendChild(progressBar);

    // Update progress on scroll
    window.addEventListener('scroll', function() {
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollPercent = (scrollTop / (documentHeight - windowHeight)) * 100;
        
        progressBar.style.width = `${Math.min(scrollPercent, 100)}%`;
    });

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Animate elements on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fadeIn');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all content sections
    document.querySelectorAll('.bg-gradient-to-br').forEach(el => {
        el.style.opacity = '0';
        observer.observe(el);
    });
});

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideUp {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-20px);
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }
    
    .animate-slideUp {
        animation: slideUp 0.3s ease-out;
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.6s ease-out forwards;
    }

    /* Print styles */
    @media print {
        @page {
            margin: 1cm;
        }
        
        body {
            font-size: 12pt;
            line-height: 1.5;
        }
        
        h1 {
            font-size: 24pt;
            margin-bottom: 12pt;
        }
        
        h2 {
            font-size: 18pt;
            margin-top: 12pt;
            margin-bottom: 6pt;
        }
        
        p {
            margin-bottom: 6pt;
        }
        
        img {
            max-width: 100%;
            page-break-inside: avoid;
        }
    }
`;
document.head.appendChild(style);
</script>