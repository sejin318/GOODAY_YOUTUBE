<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<section id="bo_v_ans" class='qa-reply-wrap'>
	<h2 class="page-title p-2"><span class="bo_v_reply"><i class="fa fa-reply" aria-hidden="true"></i></span> <?php echo get_text($answer['qa_subject']); ?></h2>
	<header>
		<div id="ans_datetime" class='text-right'>
			<i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $answer['qa_datetime']; ?>
		</div>

		<?php if ($answer_update_href || $answer_delete_href) { ?>
			<div class="reply-button btn-navbar mb-5">
				<?php if ($answer_update_href) { ?>
					<a href="<?php echo $answer_update_href; ?>" class="btn btn-primary" title="답변수정"> <i class="fa fa-pencil" aria-hidden="true"></i> 답변수정</a>
				<?php } ?>
				<?php if ($answer_delete_href) { ?>
					<a href="<?php echo $answer_delete_href; ?>" class="btn btn-danger" onclick="del(this.href); return false;" title="답변삭제"> <i class="fa fa-trash" aria-hidden="true"></i> 답변삭제</a>
				<?php } ?>
			</div>
		<?php } ?>
	</header>

	<div id="ans_con" class='qa-reply-contents'>
		<?php echo get_view_thumbnail(conv_content($answer['qa_content'], $answer['qa_html']), $qaconfig['qa_image_width']); ?>
	</div>

</section>
<div class="bo_v_btn btn-navbar text-right p-2 m-2">
	<a href="<?php echo $rewrite_href; ?>" class="btn btn-primary" title="추가질문"><i class="fa fa-question" aria-hidden="true"></i> 추가질문</a>
</div>