function displayFileName() {
    var fileInput = document.getElementById('file-input');
    var fileNameDisplay = document.getElementById('file-name');

    // Update the display with the selected file name
    fileNameDisplay.textContent = fileInput.files[0].name;
}