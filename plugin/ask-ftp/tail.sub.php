<?php
if (!defined('_GNUBOARD_')) {
    exit;
}
?>
</div>

<nav class="navbar sticky-top navbar-light bg-light mt-2">
    <div class='footer'>
        ASK-FTP
    </div>
    <a class="navbar-brand" href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
</nav>

<?php if ($_SESSION['ask_message']) { ?>
<script>
    $(function() {
        $('.toast').toast('show');
    });
</script>

<div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center"">
        <div class=" toast" data-autohide="false" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <strong class="mr-auto">메세지</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        <?php
            echo $_SESSION['ask_message'];
            unset($_SESSION['ask_message']);
            ?>
    </div>
</div>
</div>
<?php } ?>

</body>

</html>
<?php echo html_end(); ?>