<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col xl:flex-row gap-4 relative">
        {{-- DOCUMENTATION --}}
        <div class="flex-1 wrapper min-h-[calc(100vh-178px)] text-black">
            <h2 class="text-2xl font-bold mb-4">Dokumentasi Singkat Penggunaan Chatbot</h2>
            <p class="text-gray-700 mb-4">Chatbot adalah program komputer yang dirancang untuk mensimulasikan percakapan
                dengan pengguna. Chatbot dapat digunakan dalam berbagai konteks, seperti
                layanan pelanggan dan penjualan.</p>

            <h3 class="text-xl font-semibold mb-2">Cara Menggunakan Chatbot</h3>
            <ol class="list-decimal pl-8 mb-4">
                <li>Tanyakan pertanyaan spesifik yang ingin Anda ketahui. Misalnya, "Berapa total penjualan hari ini?" atau "Berapa total order yang berstatus "new"?"</li>
                <li>Anda juga bisa memilih berdasarkan Daftar pertanyaan yang tersedia  .</li>
                <li>Chatbot akan memberikan jawaban dari pertanyaan anda.</li>
                <li>Setelah mendapatkan informasi yang dibutuhkan, Anda dapat mengakhiri percakapan atau menghapus riwayat pembicaraan dengan menekan "Clear Chat".</li>
            </ol>

            <!-- Daftar Pertanyaan tentang Penjualan -->
            <h3 class="text-xl font-semibold mb-2">Daftar pertanyaan yang bisa di tanyakan</h3>

            <div class="flex flex-col gap-2 items-start">

                <button class="list-button button-add">Berapa total penjualan hari ini?</button>
                <button class="list-button button-add">Berapa total penjualan Bulan ini?</button>
                <button class="list-button button-add">Berapa total penjualan Tahun ini?</button>
                <button class="list-button button-add">Perdiksikan total penjualan tahun depan berdasarkan data masa
                    lalu
                </button>
            </div>
            <p class="text-gray-700 mt-4">Dokumentasi ini memberikan panduan dasar untuk menggunakan chatbot dan daftar
                pertanyaan yang umum diajukan terkait penjualan.</p>
        </div>

        {{-- CHATBOT --}}
        <div class="flex-1">

            <!-- component -->
            <div class="bg-gray-100 h-[calc(100vh-120px)] flex flex-col shadow-md rounded-lg sticky top-20">
                <div class="bg-gray-800 p-3 text-white flex justify-between items-center rounded-t-lg">
                    <span class="text-lg">Bali Baci Bot</span>
                    <button id="reset-button" class="button-delete" onclick="clearMessages()">
                        Clear Chat
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-4">
                    <div id="empty_chat" class="text-gray-900 h-full flex items-center justify-center">
                        <div class="flex flex-col gap-2 items-center">
                            <img src="{{ asset('img/chatbot.png') }}" alt="" class="w-14 h-14">
                            <span>Try Chatbot</span>
                        </div>
                    </div>

                    <div id="chat-messages" class="flex flex-col space-y-2">
                        <!-- Messages go here -->

                    </div>

                    <div class="hidden flex mt-2" id="loading">
                        <div class="bg-gray-300 text-black p-2 rounded-r-lg rounded-bl-lg flex">
                            <div class="animate-spin rounded-full h-5 w-5 border-t-2 border-gray-900"></div>
                            <span class="ml-2">Loading...</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 gap-2 flex items-center rounded-b-lg">
                    <input id="chat-input" type="text" placeholder="Type your message..."
                        class="flex-grow p-2 border border-gray-300 text-gray-900 rounded-lg outline-none focus:ring-2 focus:ring-gray-500"
                        value="berapa total penjualan hari ini?" />
                    <button id="send-button" onclick="sendMessage()" type="button"
                        class="button-add disabled:cursor-not-allowed">
                        Send
                    </button>
                </div>

            </div>
        </div>
    </div>


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

                if (sender === 'user') {
                    messageDiv.innerHTML = `
                        <div class="flex justify-end">
                            <div class="bg-blue-200 text-black p-2 rounded-s-xl rounded-ee-xl max-w-md">
                                ${sanitizedText}
                            </div>
                        </div>
                    `;
                } else {
                    messageDiv.innerHTML = `
                        <div class="flex">
                            <div class="bg-gray-300 text-black p-2 rounded-r-lg rounded-bl-lg max-w-full">
                                ${sanitizedText}
                            </div>
                        </div>
                    `;
                }


                chatMessages.appendChild(messageDiv);
            }

            function showLoading() {
                document.getElementById('loading').classList.remove('hidden')
                document.getElementById('reset-button').disabled = true;
                document.getElementById('send-button').disabled = true;
                document.querySelectorAll('.list-button').forEach(button => {
                    button.disabled = true;
                });
            }

            function hideLoading() {
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('reset-button').disabled = false;
                document.getElementById('send-button').disabled = false;
                document.querySelectorAll('.list-button').forEach(button => {
                    button.disabled = false;
                });
            }

            async function sendMessage(messageText = null) {
                const emptyChat = document.getElementById('empty_chat');
                const input = document.getElementById('chat-input');
                const loading = document.querySelector('.loading')
                const userMessage = messageText || input.value.trim();

                const resetButton = document.getElementById('reset-button');
                const sendButton = document.getElementById('send-button');
                const listButton = document.querySelectorAll('list-button');

                if (!userMessage) return;

                emptyChat.classList.add('hidden');

                addMessage('user', userMessage);
                input.value = ''; // Clear input

                showLoading();

                try {
                    const response = await fetch('{{ env('CHATBOT_URL') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Secret-Key':'{{ env('CHATBOT_SECRET_KEY') }}'
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

            function scrollToBottom() {
                const chatMessages = document.getElementById('chat-messages');
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            document.getElementById('chat-input').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });

            function clearMessages() {
                const chatMessages = document.getElementById('chat-messages');
                if (chatMessages) {
                    chatMessages.innerHTML = '';
                } else {
                    console.error('Element with id "chat-messages" not found.');
                }
                document.getElementById('empty_chat').classList.remove('hidden');
            }


            document.querySelectorAll('.list-button').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('loading').classList.add('hidden');
                    const messageText = this.innerHTML;
                    sendMessage(messageText)
                });
            });
        </script>
    @endpush
</x-layout>


