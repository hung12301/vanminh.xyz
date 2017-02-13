<?php if(Session::hasFlash()) { ?>

<?php
	$alert = Session::getFlash();
    $message = explode('|', $alert['message']);
    if(!isset($message[1])) {
        $message[1] = '';
    }
?>

<script type="text/javascript">
    swal({
        title: "<?= $message[0] ?>",
        text: "<?= $message[1] ?>",
        type: "<?= $alert['type'] ?>",
        timer: 1000
    });
</script>

<?php } ?>