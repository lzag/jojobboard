{extends file='layouts/main.tpl'}

{block name=content}
    {if isset($stmt) && $stmt->rowCount()} 
    Your application has been received. Please check out some <a href='/jobads'> other postings </a>
    {/if}

{/block}