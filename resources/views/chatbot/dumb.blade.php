<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col md:flex-row gap-4 h-100 text-gray-900  bg-green-500">
        <div class="wrapper w-full md:w-1/2 ">
        </div>

        <div
            class="w-full h-full  md:w-1/2 bg-white border border-gray-200 rounded-lg overflow-hidden transition-all duration-300">
            <!-- Chat Header -->
            <div class="bg-gray-800 text-white p-4">
                <h2 class="text-lg font-semibold">Bali Baci Chatbot</h2>
            </div>

            <!-- Chat Messages -->
            <div class="flex flex-col flex-grow p-4 overflow-y-auto ">
                <div id="chat-messages">



                </div>
                <div class="hidden flex gap-4 mb-4" id="loading">
                    <img src="{{ asset('img/gezzzzai.jpeg') }}" alt="Shanay image" class="w-12 h-12 rounded-full">
                    <div class="w-max-full ">
                        <div class="px-4 py-2 bg-slate-200 mt-4 text-slate-900 rounded-e-xl rounded-es-xl flex">
                            <div class="animate-spin rounded-full h-5 w-5 border-t-2 border-slate-900"></div>
                            <span class="ml-2">Loading...</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Input Area -->
            <div class="input-container p-2 bg-white border-t border-gray-300 flex gap-2 ">
                <input id="chat-input" type="text" placeholder="Type your message..."
                    class="flex-grow p-2 border border-gray-300 text-slate-900 rounded-lg outline-none"
                    value="berapa total penjualan hari ini?" />
                <button onclick="sendMessage()" class="button-add">Send</button>
            </div>
        </div>
    </div>
    <!-- Chat Container -->

    @push('scripts')
        <script>
            function escapeHtml(unsafe) {
                return unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function addMessage(sender, text) {
                const chatMessages = document.getElementById('chat-messages');
                const messageDiv = document.createElement('div');

                const sanitizedText = escapeHtml(text);

                if (sender === 'bot') {
                    messageDiv.innerHTML = `
            <div id="bot" class="flex gap-4 mb-4">
                <img src="{{ asset('img/gezzzzai.jpeg') }}" alt="Shanay image" class="w-12 h-12 rounded-full">
                <div class="w-max-full">
                    <div class="px-4 py-2 bg-slate-200 mt-4 text-slate-900 rounded-e-xl rounded-es-xl">
                        <p class="text-gray-900 leading-snug">${sanitizedText}</p>
                    </div>
                </div>
            </div>
        `;
                } else {
                    messageDiv.innerHTML = `
            <div id="user" class="flex gap-4 justify-end">
                <div class="max-w-[80%]">
                    <div class="mb-2">
                        <div class="p-4 bg-slate-600 rounded-s-xl mt-5 rounded-ee-xl shadow-sm">
                            <p class="text-white leading-snug">${sanitizedText}</p>
                        </div>
                    </div>
                </div>
                <span class="h-9 w-9 rounded-full overflow-hidden">
                    <img class="w-full h-full object-cover rounded-full bg-gray-200 p-2" src="{{ asset('img/user2.png') }}" alt="user photo">
                </span>
            </div>
        `;
                }

                chatMessages.appendChild(messageDiv);
            }

            function showLoading() {
                document.getElementById('loading').classList.remove('hidden')
            }

            function hideLoading() {
                document.getElementById('loading').classList.add('hidden');
            }

            async function sendMessage() {
                const input = document.getElementById('chat-input');
                const loading = document.querySelector('.loading')
                const userMessage = input.value.trim();

                if (!userMessage) return;

                // Add user message to chat
                addMessage('user', userMessage);
                input.value = ''; // Clear input

                showLoading();

                try {
                    // Send message to backend
                    const response = await fetch('http://127.0.0.1:5000/query', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            query: userMessage
                        }),
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    // console.log(data.response['output']);

                    addMessage('bot', data.response['output']); // Add bot response to chat
                    scrollToBottom()
                } catch (error) {
                    console.error('Error:', error);
                    addMessage('bot', `Error: ${error.message}`); // Show error message
                    scrollToBottom()
                } finally {
                    hideLoading()
                    scrollToBottom()
                }
            }

            function clearMessages() {
                const chatMessages = document.getElementById('chat-messages');
                if (chatMessages) {
                    chatMessages.innerHTML = '';
                } else {
                    console.error('Element with id "chat-messages" not found.');
                }
                document.getElementById('empty_chat').classList.remove('hidden');
            }

            function scrollToBottom() {
                const chatMessages = document.getElementById('chat-messages');
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Allow pressing Enter to send message
            document.getElementById('chat-input').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
        </script>
    @endpush
</x-layout>

{{-- h-16 = 64px --}}
{{-- h-14 = 56px --}}
