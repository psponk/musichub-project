<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="App.css">
    <link rel="stylesheet" href="model.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>
    <nav>
        <div>
            <a class='nav-button' href='model.html'>MUSIC HUB</a>
        </div>
        <ul>
            <li><a href='voice.html'>Voice</a></li>
            <li><a href='record.html'>Recorder</a></li>
            <li><a href='save.html'>Save</a></li>
            <li><a href='profile.php'>Profile</a></li>
        </ul>
    </nav>
    <div class='home-container'>
        <h1 class='home-title'>MUSIC HUB</h1>
        <label class="home-browse-button">
            Browse File<input type="file" id="fileInput" style="display: none;">
        </label>
        <div class='home-filename'>
            <!-- File Name -->
            <p></p>
            <!-- Cancel Button -->
            <button class='home-cancel-button' style="display: none;">X</button>
        </div>
        <!-- Audio Player -->
        <audio id="audioPlayer" controls style="display: none;">
            <source src="" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
        <!-- Upload Button -->
        <button class='home-upload-button' style="display: none;">Upload</button>
        <!-- Processing Message -->
        <p id="processing-message" style="display: none;">Processing...</p>
        <!-- Result Display -->
        <div id="result" style="display: none;"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.home-browse-button input[type="file"]').change(function() {
                var file = this.files[0];
                var objectURL = URL.createObjectURL(file);

                $('.home-filename p').text(file.name);
                $('.home-filename button').show();
                $('.home-upload-button').show();

                // Play the selected audio file
                $('#audioPlayer').attr('src', objectURL);
                $('#audioPlayer').show();
            });

            $('.home-cancel-button').click(function() {
                // Clear the selected file
                $('.home-browse-button input[type="file"]').val('');
                $('.home-filename p').text('');
                $('.home-filename button').hide();
                $('.home-upload-button').hide();

                // Stop playing the audio
                $('#audioPlayer').attr('src', '');
                $('#audioPlayer').hide();
            });

            $('.home-upload-button').click(function() {
                var input = document.getElementById('fileInput');
                var file = input.files[0];
                var formData = new FormData();
                formData.append('file', file);

                // Show processing message
                $('#processing-message').show();

                $.ajax({
                    url: 'upload.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#processing-message').hide();
                        $('#result').html(response).show();
                    }
                });
            });
        });
    </script>
</body>
</html>