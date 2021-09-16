{extends file='layouts/main.tpl'}

{block name=content}
<div class="container">
    <div class="row">
        <div class="col-sm-6 m-auto">
            <form method="post" action='/password/recover'>
                <form-group>
                    <label for="email">Please introduce your email. The reset link will be sent there.</label>
                    <input type="text" name="email" placeholder="Your email address" class="form-control">
                </form-group>
                <br>
                <input type="hidden" name="token" value="{generate_token()}">
                <input type="submit" name="reset" value="Reset Password" class="btn btn-primary">
            </form>

        </div>
    </div>
</div>
{/block}
