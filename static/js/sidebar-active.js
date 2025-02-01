document.addEventListener("DOMContentLoaded", function() {
    // Get current page URL
    const currentPage = window.location.pathname.split('/').pop();
    
    // Get all sidebar items
    const sidebarItems = document.querySelectorAll('.sidebar-item');
    
    // Remove active class from all items first
    sidebarItems.forEach(item => {
        item.classList.remove('active');
    });
    
    // Add active class based on current page
    sidebarItems.forEach(item => {
        const link = item.querySelector('.sidebar-link');
        if (link) {
            const href = link.getAttribute('href');
            if (href === currentPage || 
                (currentPage === '' && href === 'admin.php') || // For root URL
                (currentPage === 'admin.php' && href === 'admin.php')) {
                item.classList.add('active');
            }
            
            // Add click handler
            link.addEventListener('click', function() {
                sidebarItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
            });
        }
    });
});
