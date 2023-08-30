(function () {
    ("use strict");

    //file upload preview
    $(document).on('change', '.preview', function (e) {
        emptyInputFiled('image-preview-section')
        var file = e.target.files[0];
        console.log(file);
        var size = ($(this).attr('data-size')).split("x");
        imagePreview(file, 'image-preview-section', size);
        e.preventDefault();
    })

    //EMPTY INPUT FIELD
    function emptyInputFiled(id, selector = 'id', html = true) {
        var identifier = selector === 'id' ? `#${id}` : `.${id}`;
        $(identifier)[html ? 'html' : 'val']('');
    }

    //SINGLE IMAGE PREVIEW METHOD
    function imagePreview(file, id, size) {
        $(`#${id}`).append(
            `<img alt='${file.type}' class="mt-2 rounded  d-block"
             style="width:${size[0]}px;height:${size[1]}px;"
            src='${URL.createObjectURL(file)}'>`
        );
    }


    // Nice Selecte initialization
    if (document.querySelector(".niceSelect")) {
        $(document).ready(function () {
            $('.niceSelect').niceSelect();
        });
    }



    const fileUploader = document.getElementById('image-preview');
    if (fileUploader) {
        const images = document.querySelector('.preview-images');
        fileUploader.addEventListener('change', (e) => {
            e.preventDefault();
            const files = e.target.files;
            images.style.cssText = `display:flex; align-items:center;gap:15px; flex-wrap:wrap; margin-top:20px;`
            var children = "";
            for (var i = 0; i < files.length; ++i) {
                children += `
                    <div style='width:200px; height:auto;'>
                         <img alt='${files[i].type}'
                          src='${URL.createObjectURL(files[i])}'>
                    </div>
               `;
            }
            images.innerHTML = children;
        });
    }

}())
