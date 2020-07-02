var config =  {
    //plugins: plugins,
    showPathLabel : false,
    charCounter : true,
    maxCharCount : 65535,
    width : '100%',    
    height : 'auto',
    minHeight : '300px',
    lang: KEDITOR_LANG['ko'],
    buttonList : [
        ['undo', 'redo', 'font', 'fontSize', 'formatBlock'],
        ['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript', 'removeFormat'],
        '/' // Line break
        ['fontColor', 'hiliteColor', 'outdent', 'indent', 'align', 'horizontalRule', 'list', 'table'],
        ['link', 'video', 'fullScreen', 'showBlocks', 'codeView', 'preview', 'print']
    ],
    callBackSave : function (contents) {
        return contents;
    },
};