<?php

/**
 * scrap_popin.skin.php
 * 스크랩
 * boilerplate.kr
 * 타 프로그램에 포함할 수 없으며 재배포 금지합니다.
 */
if (!defined('_GNUBOARD_')) {
	exit;
}
include_once G5_THEME_PATH . "/head.sub.php";
add_stylesheet("<link rel=\"stylesheet\" href=\"" . BP_CSS . "/member/member.basic.css\">", 40);

?>

<!-- 스크랩 시작 { -->
<div class="scrap-wrap container-fluid">
	<h2 class="page-title p-2">스크랩하기</h2>
	<form name="f_scrap_popin" action="./scrap_popin_update.php" method="post">
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
		<div class="new_win_con">
			<h2 class="sr-only">제목 확인 및 댓글 쓰기</h2>
			<span class="sr-only">제목</span>
			<div class="jumbotron jumbotron-fluid p-4">
				<?php echo get_text(cut_str($write['wr_subject'], 255)) ?>
			</div>
			<div class="form-group">
				<textarea name="wr_content" id="wr_content" class='form-control' placeholder="댓글입력"></textarea>
			</div>
		</div>
		<p class="alert alert-info">스크랩을 하시면서 감사 혹은 격려의 댓글을 남기실 수 있습니다.</p>

		<div class="form-action d-flex">
			<button type="submit" class="btn btn-primary mr-auto">스크랩하기</button>
			<button type="button" class="btn btn-danger" onclick="window.close();">취소</button>
		</div>
	</form>
</div>
<!-- } 스크랩 끝 -->
<?php
include_once G5_THEME_PATH . "/tail.sub.php";
