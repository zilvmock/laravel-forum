<script src="https://cdn.tiny.cloud/1/gjpexkwau94pkiwiv57entmgkpnrgedlwjhv3omrcloz2s7r/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
<script>
  var editor_config = {
    path_absolute : "/",
    relative_urls: false,
    skin: 'oxide-dark',
    content_css: 'dark',
    branding: false,
    menubar: false,
    max_width: {{$width ?? 1000}},
    min_height: {{$height ?? 200}},
    max_height: 1000,
    resize: false,
    selector: 'textarea#tinymce',
    plugins: 'code table lists autoresize {{$image ?? ''}}',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code {{$image ?? ''}} | table',
    file_picker_callback : function(callback, value, meta) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'filemanager?editor=' + meta.fieldname;
      if (meta.filetype === 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.openUrl({
        url : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no",
        onMessage: (api, message) => {
          callback(message.content);
        }
      });
    }
  };

  tinymce.init(editor_config);
</script>
