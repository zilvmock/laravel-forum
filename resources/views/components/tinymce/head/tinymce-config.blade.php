<script src="https://cdn.tiny.cloud/1/gjpexkwau94pkiwiv57entmgkpnrgedlwjhv3omrcloz2s7r/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    skin: 'oxide-dark',
    content_css: 'dark',
    branding: false,
    menubar: false,
    max_width: {{$width ?? '1000'}},
    max_height: {{$height ?? '200'}},
    resize: false,
    selector: 'textarea#tinymce',
    plugins: 'code table lists autoresize {{$image ?? ''}}',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code {{$image ?? ''}} | table'
  });
</script>
