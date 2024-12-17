
    document.getElementById('profilePicture').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imgPreview = document.createElement('img');
                imgPreview.src = e.target.result;
                imgPreview.style.width = '100px';
                imgPreview.style.height = '100px';
                imgPreview.style.marginTop = '10px';

                const previewContainer = document.getElementById('previewContainer');
                previewContainer.innerHTML = ''; // Clear any existing preview
                previewContainer.appendChild(imgPreview);
            };
            reader.readAsDataURL(file);
        }
    });

<div id="previewContainer" style="text-align: center;"></div>
