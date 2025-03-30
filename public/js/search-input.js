
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('simple-search');
    const dropdownList = document.getElementById('dropdown-list');
    const customerItems = Array.from(document.querySelectorAll('.customer-item'));

    // Filter customer names based on input
    searchInput.addEventListener('input', function() {
        const filter = searchInput.value.toLowerCase();
        let hasVisibleItems = false;

        customerItems.forEach(item => {
            const customerName = item.textContent.toLowerCase();
            if (customerName.includes(filter)) {
                item.style.display = ''; // Show item
                hasVisibleItems = true;
            } else {
                item.style.display = 'none'; // Hide item
            }
        });

        // Show or hide the dropdown based on whether there are visible items
        dropdownList.classList.toggle('hidden', !hasVisibleItems);
    });

    // Show dropdown on input click
    searchInput.addEventListener('click', function() {
        dropdownList.classList.remove('hidden');
    });

    // Close the dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!searchInput.contains(event.target) && !dropdownList.contains(event.target)) {
            dropdownList.classList.add('hidden');
        }
    });

    // Handle click on dropdown items
    customerItems.forEach(item => {
        item.addEventListener('click', function() {
            const selectedName = item.textContent.trim();
            searchInput.value = selectedName; // Populate input with selected name
            dropdownList.classList.add('hidden');
        });
    });
});

