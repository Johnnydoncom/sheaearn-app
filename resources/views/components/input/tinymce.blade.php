<div x-cloak
    x-data="{ value: @entangle($attributes->wire('model')) }"
    x-init="
        tinymce.init({
            target: $refs.tinymce,
            selector: $refs.tinymce,
            plugins: 'importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',

           mobile: {
            plugins: 'importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image paste link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons'
           },
          menu: {
            tc: {
              title: 'Comments',
              items: 'addcomment showcomments deleteallconversations'
            }
          },
          menubar: 'file edit view insert format tools table tc help',
          toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | ltr rtl | showcomments addcomment',
          autosave_ask_before_unload: true,
          autosave_interval: '30s',
          autosave_prefix: '{path}{query}-{id}-',
          autosave_restore_when_empty: false,
          autosave_retention: '2m',
          image_advtab: true,
          importcss_append: true,
            height: 300,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            tinycomments_mode: 'embedded',
            content_style: '.mymention{ color: gray; }',
            contextmenu: 'link image imagetools table configurepermanentpen',
            block_unsupported_drop: false,

            image_title: true,
            automatic_uploads: true,
            images_upload_url: '{{ route('admin.file-upload') }}',
            file_picker_types: 'image',
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function () {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                };
                input.click();
            },


       setup: function(editor) {
           editor.on('blur', function(e) {
               value = editor.getContent()
           })
           editor.on('init', function (e) {
               if (value != null) {
                   editor.setContent(value)
               }
           })
           function putCursorToEnd() {
               editor.selection.select(editor.getBody(), true);
               editor.selection.collapse(false);
           }
           $watch('value', function (newValue) {
               if (newValue !== editor.getContent()) {
                   editor.resetContent(newValue || '');
                   putCursorToEnd();
               }
           });
       }
   })
"
    wire:ignore
>
    <div wire:ignore>
        <input
            x-ref="tinymce"
            type="textarea"
            {{ $attributes->whereDoesntStartWith('wire:model') }}
        >
    </div>
</div>

@push('styles')
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
{{--    <script src="https://cdn.tiny.cloud/1/3m8lg6hqa5jdiihrtx0oldt9p90y03ayrllq8m7ehzsjndf5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>--}}
    <style>
        .tox-tinymce{
            border-radius: 0px !important;
        }
    </style>
@endpush
