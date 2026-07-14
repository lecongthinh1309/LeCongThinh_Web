document.querySelectorAll('.img-input').forEach(input => {
    input.addEventListener('change', function () {
        // this.closest('.img-group'): block cha
        // querySelector('.img-preview'): tìm element con(.img-preview)
        const preview = this.closest('.img-group').querySelector('.img-preview');
        if (preview) {
            preview.innerHTML = '';
            Array.from(this.files).forEach(file => {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.width = 150;
                img.style.margin = '5px';
                preview.appendChild(img);
            });
        }
    });
});
