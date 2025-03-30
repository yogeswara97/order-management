{{-- resources/views/components/customer-modal.blade.php --}}
<div id="default-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-5xl max-h-full">

        <div class="relative bg-white rounded-lg shadow-sm ">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 ">
                    Customer List
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    id="close-modal" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form action="{{ route('chatbot.edit') }}" method="POST">
                @method('PUT')
                @csrf
                <div class="p-4 md:p-5 space-y-4 overflow-y-auto overflow-x-hidden max-h-[35rem]">
                    <textarea id="message" rows="4" class="input h-96" placeholder="Write your thoughts here..."
                        name="prompt_template">{{ $slot }}</textarea>
                </div>
                <div class="flex items-center justify-end gap-2 p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button type="button" id="close-modal-button" data-modal-hide="default-modal" class="button-add">
                        Close
                    </button>
                    <button type="submit" id="close-modal-button" data-modal-hide="default-modal" class="button-submit">
                        Change Prompt Template
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const button = document.getElementById('modal-button');
        const modal = document.getElementById('default-modal');
        const closeModalButton = document.getElementById('close-modal');
        const closeModalButton2 = document.getElementById('close-modal-button');

        button.addEventListener('click', function() {
            modal.classList.remove("hidden");
        });

        // Function to close the modal
        function closeModal() {
            modal.classList.add("hidden");
        }

        // Event listener to close the modal when clicking the close button
        closeModalButton.addEventListener('click', closeModal);
        closeModalButton2.addEventListener('click', closeModal);

        // Event listener to close the modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
@endpush
