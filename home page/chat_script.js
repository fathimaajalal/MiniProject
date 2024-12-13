document.addEventListener('DOMContentLoaded', () => {
    const chatBody = document.getElementById('chatBody');
    const messageInput = document.getElementById('messageInput');
    const sendMessageButton = document.getElementById('sendMessageButton');

    // Capture the receiver's regno from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const receiverRegno = urlParams.get('receiver_regno'); // Get receiver's regno from the URL

    // Fetch the sender's regno from the session
    let senderRegno;

    // Function to fetch sender's regno
    function fetchSenderRegno() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'getUserRegno.php', true);
        xhr.onload = () => {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.regno) {
                    senderRegno = response.regno;
                    console.log("Sender's Regno:", senderRegno);
                } else {
                    console.error(response.error);
                }
            } else {
                console.error('Failed to fetch sender regno.');
            }
        };
        xhr.send();
    }

    fetchSenderRegno(); // Call the function to fetch sender's regno

    if (!receiverRegno) {
        alert('Receiver is not specified.');
        return;
    }

    // Function to send a message
    function sendMessage() {
        const messageContent = messageInput.value.trim();
        console.log("Message Content:", messageContent);

        if (messageContent === '') {
            alert('Message cannot be empty.');
            return;
        }

        console.log("Preparing to send message...");

        // AJAX request to send the message to the backend (sendMessage.php)
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'sendMessage.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Log any errors or response for debugging
        xhr.onerror = () => console.error('Request error...');
        xhr.onload = () => {
            console.log("XHR status:", xhr.status);
            console.log("XHR response:", xhr.responseText);
            
            if (xhr.status === 200) {
                console.log('Response:', xhr.responseText);

                // Clear the input box after sending
                messageInput.value = '';

                // Optionally, you can reload or update the chat body
                loadMessages();
            } else {
                console.error('Failed to send message.');
            }
        };

        // Log the parameters to see what's being sent
        const params = `sender_regno=${senderRegno}&receiver_regno=${receiverRegno}&message=${encodeURIComponent(messageContent)}`;
        console.log("Sending Params:", params);

        xhr.send(params);
        console.log("Message sent...");
    }

    // Function to load messages (existing implementation)
    function loadMessages() {
        console.log("Loading messages..."); // Add log to confirm the function is being called
        // Your existing code to retrieve messages
    }

    // Add event listener to the Send button
    sendMessageButton.addEventListener('click', sendMessage);
});
