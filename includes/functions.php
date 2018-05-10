<?php
function show_alert($msg) {

if ($msg) {
echo <<<_END
<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>$msg</strong>
</div>
_END;

}
}
?>
