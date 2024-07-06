<?php header('Access-Control-Allow-Origin: *'); ?>

<!-- Trumbowyg editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/trumbowyg.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/ui/trumbowyg.min.css">

<!-- Trumbowyg plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/plugins/cleanpaste/trumbowyg.cleanpaste.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/plugins/allowtagsfrompaste/trumbowyg.allowtagsfrompaste.min.js"></script>

<script>
$(document).ready(function() {
    'use strict';
    $('#trumbowyg-editor').trumbowyg({
        btns: [['formatting', 'strong', 'em', 'link'], ['unorderedList', 'orderedList'], ['removeformat','viewHTML', 'fullscreen']],
        autogrow: true,
        plugins: {
            allowTagsFromPaste: {
                allowedTags: ['h1', 'h2', 'h3', 'h4', 'p', 'br', 'strong', 'b', 'i', 'a', 'ul', 'li']
            },                        
        },
    });
});
</script>