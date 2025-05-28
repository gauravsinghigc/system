const startSpeechBtn = document.getElementById('startSpeech');
        const feedbackRemarks = document.getElementById('feedbackRemarks');
        if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            const recognition = new SpeechRecognition();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-IN';

            startSpeechBtn.addEventListener('click', function() {
                if (this.classList.contains('recording')) {
                    recognition.stop();
                } else {
                    recognition.start();
                    this.innerHTML = '<i class="bi bi-stop-circle"></i> Stop Voice Input';
                    this.classList.add('btn-primary', 'recording');
                    this.classList.remove('btn-outline-primary');
                }
            });

            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                feedbackRemarks.value += (feedbackRemarks.value ? ' ' : '') + transcript;
                resetSpeechButton();
            };

            recognition.onerror = function(event) {
                console.error('Speech recognition error:', event.error);
                alert('Voice input error: ' + event.error);
                resetSpeechButton();
            };

            recognition.onend = function() {
                resetSpeechButton();
            };

            function resetSpeechButton() {
                startSpeechBtn.innerHTML = '<i class="bi bi-mic"></i> Add Voice Input';
                startSpeechBtn.classList.remove('btn-primary', 'recording');
                startSpeechBtn.classList.add('btn-outline-primary');
            }
        } else {
            startSpeechBtn.disabled = true;
            startSpeechBtn.textContent = 'Voice Input Not Supported';
        }

        // Voice Note Recording Handling
        const startRecordingBtn = document.getElementById('startRecording');
        const stopRecordingBtn = document.getElementById('stopRecording');
        const recordingIndicator = document.getElementById('recordingIndicator');
        const voiceNoteInput = document.getElementById('voiceNoteInput');
        const voiceNotePlayer = document.getElementById('voiceNotePlayer');
        const recordedAudio = document.getElementById('recordedAudio');
        let mediaRecorder;
        let audioChunks = [];

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({
                    audio: true
                })
                .then(stream => {
                    mediaRecorder = new MediaRecorder(stream);

                    startRecordingBtn.addEventListener('click', () => {
                        audioChunks = [];
                        mediaRecorder.start();
                        startRecordingBtn.disabled = true;
                        stopRecordingBtn.disabled = false;
                        recordingIndicator.style.display = 'inline';
                        voiceNotePlayer.style.display = 'none';
                    });

                    stopRecordingBtn.addEventListener('click', () => {
                        mediaRecorder.stop();
                    });

                    mediaRecorder.ondataavailable = event => audioChunks.push(event.data);

                    mediaRecorder.onstop = () => {
                        const audioBlob = new Blob(audioChunks, {
                            type: 'audio/webm'
                        });
                        const audioUrl = URL.createObjectURL(audioBlob);
                        const audioFile = new File([audioBlob], 'voice_note.webm', {
                            type: 'audio/webm'
                        });

                        recordedAudio.src = audioUrl;
                        voiceNotePlayer.style.display = 'block';
                        startRecordingBtn.disabled = false;
                        stopRecordingBtn.disabled = true;
                        recordingIndicator.style.display = 'none';

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(audioFile);
                        voiceNoteInput.files = dataTransfer.files;
                    };
                })
                .catch(err => {
                    console.error('Microphone access error:', err);
                    startRecordingBtn.disabled = true;
                    stopRecordingBtn.disabled = true;
                    startRecordingBtn.textContent = 'Recording Not Available';
                    alert('Microphone access denied or not supported.');
                });
        } else {
            startRecordingBtn.disabled = true;
            stopRecordingBtn.disabled = true;
            startRecordingBtn.textContent = 'Recording Not Supported';
        }