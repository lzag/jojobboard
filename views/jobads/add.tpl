{extends file='layouts/main.tpl'}
{block name=content}
<div align="center">
Please provide the details of the job posting.<br><br><br>
<form method="POST" action="/jobad" enctype="multipart/form-data">
    Title:<br> <input type="text" name="title"><br><br>
    Description: <br><textarea name="description" rows="10" columns="100"></textarea><br><br>
    <input type="submit" value="Submit Job Posting"><br><br>

</form>
</div>
{/block}