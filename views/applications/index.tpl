{extends file='layouts/main.tpl'}

{block name=content}
    <div align='center'>
    <h2> {$row_post['title']}</h2><br>
    Posting ID: {$row_post['posting_id']}<br>
    Job description: <br>{$row_post['description']}<br>
    Posted on: {$row_post['time_posted']}<br><br>

    {if count($result)}
    Your details: <br><br>
    First name: {$result['first_name']}<br>
    Second name: {$result['second_name']}<br>
    Email: {$result['email']}<br>
        {if !$result['cv_file']}
    <span class='text-danger'>Your CV is not uploaded. Please upload it <a href='/resume'> here</a></span>
        {else}
    CV file: {$result['cv_file']}
        {/if}
    <form action="/applied" method="POST">
        <input type="hidden" name="user_id" value="{$result['user_id']}">
        <input type="hidden" name="posting_id" value="{$smarty.get.id}">
        <input type="submit" value="Finalize application" class="btn btn-primary">
    </form>
    {else}
    <form action="/application" method="POST">
        <input type="hidden" name="posting_id" value="{$smarty.get.id}">
        <input type="submit" value="Apply" class="btn btn-primary">
    </form>
    {/if}

{/block}