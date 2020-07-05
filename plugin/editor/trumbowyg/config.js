var trumbowyg_config = {
	lang: 'ko',
	tagsToRemove: [
		'html',
		'meta',
		'link',
		'style',
		'script',
		'head',
		'body',
		'input',
		'textarea',
		'button',
	],
	minimalLinks: true,
	autogrow: true,
	imageWidthModalEdit: true,
	btnsDef: {
		image: {
			dropdown: ['insertImage', 'upload'],
			ico: 'insertImage',
		},
	},
	btns: [
		['viewHTML'],
		['undo', 'redo'],
		['strong', 'em', 'del'],
		['foreColor', 'backColor'],
		['formatting', 'fontsize'],
		['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
		['link'],
		['image', 'noembed'],
	],
	plugins: {
		upload: {
			serverPath: g5_url + '/plugin/editor/' + g5_editor + '/imageUpload/upload.php',
			fileFieldName: 'image',
			urlPropertyName: 'data.link',
		},
	},
}
