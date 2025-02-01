document.addEventListener("DOMContentLoaded", function() {
    // Get the main content container
    const mainContent = document.querySelector('.content');
    
    // Add click event listeners to sidebar links
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href !== '#' && !href.startsWith('http')) {
                e.preventDefault();
                loadContent(href);
            }
        });
    });
    
    // Function to load content via AJAX
    function loadContent(page) {
        fetch(page)
            .then(response => response.text())
            .then(html => {
                // Create a temporary container
                const temp = document.createElement('div');
                temp.innerHTML = html;
                
                // Extract the main content from the loaded page
                const newContent = temp.querySelector('main .container-fluid') || 
                                 temp.querySelector('.card') ||
                                 temp.querySelector('main');
                
                if (newContent) {
                    // Update the URL without refreshing the page
                    window.history.pushState({}, '', page);
                    
                    // Update the main content
                    mainContent.innerHTML = newContent.innerHTML;
                    
                    // Re-initialize any scripts if needed
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                }
            })
            .catch(error => {
                console.error('Error loading content:', error);
            });
    }
});
