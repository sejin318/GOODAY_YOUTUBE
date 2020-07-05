function get_editor_wr_content() {
	return $('#wr_content').trumbowyg('html')
}

function put_editor_wr_content(content) {
	$('#wr_content').trumbowyg('html', content)
	return
}
