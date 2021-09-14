{extends file='layouts/main.tpl'}
{if $alert}
{block name=alert}
<div class="alert alert-{$alert->type} alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>{$alert->message}</strong>
</div>
{/block}
{/if}
{block name=content}
<div class="container">
    <div class="row mt-3">
        <div class="col-sm-8 m-auto">
            <form method="post" action="/resume" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file_upload">Please select your CV file</label>
                    <input type="file" name="CV" class="form-control" id="file_upload">
                    <small>Only files in PDF or DOC format allowed</small>
                </div>
                <input type="submit" value="Upload CV" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
{/block}