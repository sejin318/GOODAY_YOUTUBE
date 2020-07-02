var imageList = [];
var selectedImages = [];
var eidx = $('.image_wrapper').length;
for(var i = 0; i < eidx;i++){
    $('.image_wrapper').data('idx', i.toString());
}
// Edit image list
function setImageList (ele, arridx) {
    var imageTable = $('#' + ele).find('.image_list')[0];
    var imageRemove = $('#' + ele).find('.image_remove')[0];
    var imageSize = $('#' + ele).find('.image_size')[0];
    var list = '';
    var size = 0;

    for (var i = 0, image, fixSize; i < imageList[arridx].length; i++) {
        image = imageList[arridx][i];
        fixSize = (image.size / 1000).toFixed(1) * 1;
        list += '<li class="img_' + image.index + '">' +
                    '<div onclick="checkImage(\''+ele+'\', ' + image.index + ', ' + arridx + ')">' +
                        '<div class="image-wrapper"><img src="' + image.src + '"></div>' +
                    '</div>' +
                    '<a href="javascript:void(0)" onclick="selectImage(\'select\',' + image.index + ', ' + arridx + ')" class="image-size">' + fixSize + 'KB</a>' +
                    '<div class="image-check"><svg aria-hidden="true" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg></div>' +
                '</li>';
        
        size += fixSize;
    }
    imageSize.innerText = size.toFixed(1) + 'KB';
    imageTable.innerHTML = list;
}

// Array.prototype.findIndex
function findIndex(arr, index) {
    var idx = -1;

    arr.some(function (a, i) {
        if ((typeof a === 'number' ? a : a.index) === index) {
            idx = i;
            return true;
        }
        return false;
    })

    return idx;
}

// Click the file size
function selectImage (type, index, arrIdx) {
    console.log(type, index, arrIdx);
    //imageList[findIndex(imageList, index)][type]();
}

// Image check
function checkImage (ele, index, arrIdx) {
    var imageTable = $('#' + ele).find('.image_list')[0];
    var imageRemove = $('#' + ele).find('.image_remove')[0];
    var imageSize = $('#' + ele).find('.image_size')[0];
    var li = imageTable.querySelector('.img_' + index);
    console.log(li);
    var currentImageIdx = findIndex(selectedImages[arrIdx], index)

    if (currentImageIdx > -1) {
        selectedImages[arrIdx].splice(currentImageIdx, 1)
        li.className = 'img_' + index + '';
    } else {
        selectedImages[arrIdx].push(index)
        li.className = 'img_' + index + ' checked';
    }

    if (selectedImages[arrIdx].length > 0) {
        imageRemove.removeAttribute('disabled');
    } else {
        imageRemove.setAttribute('disabled', true);
    }
}

// Click the remove button
function deleteCheckedImages(editor, ele) {
    var arrIdx = parseInt($('#'+ele).data('idx'));
    var imageTable = $('#' + ele).find('.image_list')[0];
    var imageRemove = $('#' + ele).find('.image_remove')[0];
    var imageSize = $('#' + ele).find('.image_size')[0];
    $(imageTable).find('.checked').remove();
    var iamgesInfo = editor.getImagesInfo();

    for (var i = 0; i < iamgesInfo.length; i++) {
        if (selectedImages[arrIdx].indexOf(iamgesInfo[i].index) > -1) {
            iamgesInfo[i].delete();
            i--;
        }
    }

    selectedImages[arrIdx] = [];
}
function check_base64_image($base64) {
    $img = imagecreatefromstring(base64_decode($base64));
    if (!$img) {
        return false;
    }

    imagepng($img, 'tmp.png');
    $info = getimagesize('tmp.png');

    unlink('tmp.png');

    if ($info[0] > 0 && $info[1] > 0 && $info['mime']) {
        return true;
    }

    return false;
}
function dataURLtoFile(dataurl, filename) {
    var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
    while(n--){
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new File([u8arr], filename, {type:mime});
}
function checkUrlForm(strUrl) {
    var expUrl = /^http[s]?\:\/\//i;
    return expUrl.test(strUrl);
}
function Keditor_image(targetImgElement, imageInfo){
    var formData = new FormData(); // Currently empty
    if(checkUrlForm(imageInfo.src)){
        return false;
    }
    var file = dataURLtoFile(imageInfo.src, imageInfo.name);
    formData.append("bo_table", g5_bo_table);
    formData.append("editor_file[]", file, file.filename);
    $.ajax({
        type: "post",
        url: g5_url+'/plugin/editor/' + g5_editor + '/imageUpload.php',
        data: formData,
        async: false,
        cache: false,
        contentType : false,
        processData : false, 
        dataType : "json", 
        success: function (data) {
            if(data.msg) alert(data.msg);    
            if(data.src){
                targetImgElement.src = data.src;
                $(this).parents('.wr_content').find('.image-list').find('li.img_'+imageInfo.index+ ' img').attr('src', data.src);
            }            
        }
    });
}