<div class="floating-chat" id="faqChat">
    <div class="chat-header d-flex justify-content-between align-items-center p-3 bg-primary text-white">
        <h5 class="mb-0">Chat Assistant</h5>
        <div>
            <button class="btn btn-transparent text-white" id="minimizeChat">
                <i class="bi bi-dash-lg"></i>
            </button>
            <button class="btn btn-transparent text-white" id="closeChat">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>

    <div class="chat-body p-3" id="chatBody">
        <div class="chat-messages" id="chatMessages">
            <div class="bot-message mb-3">
                <div class="message-content bg-light p-2 rounded">
                    Hello! How can I help you today?
                </div>
            </div>
        </div>
    </div>

    <div class="chat-input p-3 border-top">
        <form id="faqForm" method="POST" action="">
            <div class="input-group">
                <input type="text" class="form-control" id="userQuestion" name="question" placeholder="Type your question...">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-send"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chat = document.getElementById('faqChat');
        const toggleBtn = document.getElementById('toggleChat');
        const minimizeBtn = document.getElementById('minimizeChat');
        const closeBtn = document.getElementById('closeChat');
        const chatForm = document.getElementById('faqForm');
        const chatMessages = document.getElementById('chatMessages');

        // toggle chat visibility
        toggleBtn.addEventListener('click', () => {
            chat.style.display = chat.style.display === 'none' ? 'flex' : 'none';
            if (chat.style.display === 'flex') {
                chat.classList.add('slide-in');
            }
        });

        // minimize chat
        minimizeBtn.addEventListener('click', () => {
            chat.classList.add('slide-out');
            setTimeout(() => {
                chat.style.display = 'none';
                chat.classList.remove('slide-out');
            }, 300);
        });

        // close chat
        closeBtn.addEventListener('click', () => {
            chat.classList.add('slide-out');
            setTimeout(() => {
                chat.style.display = 'none';
                chat.classList.remove('slide-out');
            }, 300);
        });
    });
</script>