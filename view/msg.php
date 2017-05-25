<script>
    alert("<?=$msg?>");
    <?php
    if($go == "back") {
        echo "history.go(-1);";
    }else {
        echo "location.href='" . $go . "'";
    }
    ?>
</script>