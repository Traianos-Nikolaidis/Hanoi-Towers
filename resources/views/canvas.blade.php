<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canvas Example</title>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin-top: -50px;
        }
        canvas {
            border: 1px solid black;
        }
        .buttons {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav>
        <!-- Add your navigation bar content here -->
    </nav>
    
    <div class="container">
        <canvas id="canvas" width="1500" height="1000"></canvas>
        <div class="buttons">
            <span id="timerDisplay">00:00</span>
            <button id="startStop">Start/Stop</button>
            <button id="exit">Exit</button>
        </div>
    </div>

    <script>
        let timer;
        let isRunning = false;
    
        document.getElementById('startStop').addEventListener('click', function() {
            const button = document.getElementById('startStop');
    
            if (!isRunning) {
                startTimer();
                button.innerText = 'Stop';
                isRunning = true;
            } else {
                stopTimer();
                button.innerText = 'Start';
                isRunning = false;
            }
        });
    
        function startTimer() {
            let startTime = Date.now();
            let timerDisplay = document.getElementById('timerDisplay');
    
            timer = setInterval(function() {
                let elapsedTime = Date.now() - startTime;
                let minutes = Math.floor(elapsedTime / (1000 * 60));
                let seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);
    
                timerDisplay.innerText = `${formatNumber(minutes)}:${formatNumber(seconds)}`;
            }, 1000);
        }
    
        function stopTimer() {
            clearInterval(timer);
        }
    
        function formatNumber(number) {
            return number.toString().padStart(2, '0');
        }
    
        document.getElementById('exit').addEventListener('click', function() {
            // Redirect to another page or close the window
            window.location.href = '/';
        });
    </script>
    
    
</body>
</html>
