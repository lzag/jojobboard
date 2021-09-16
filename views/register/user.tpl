{extends file='layouts/main.tpl'}

{block name=content}
<div class="container">
    <div class="col w-50 m-auto">
        <form method="post" action='/register/user'>
        <h3 class="form-header">Please provide us with your data to register a new user: </h3>
            <div class="form-group">
                <label for="first_name">Name:</label>
                <input type="text" name="first_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="second_name">Surname:</label>
                <input type="text" name="second_name" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="pass" class="form-control" maxlength="40">
            </div>
            <input type="hidden" name="IP" value="{$smarty.server.REMOTE_ADDR}" class="form-control">
            <input type='submit' value="Create User" class="btn btn-primary form-control">
        </form>
    </div>
</div>
{/block}
