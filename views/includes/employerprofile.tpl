<div class="container">
    <div class="col w-75 m-auto">
        <p class="text-dark">Company Tax ID: {$employer->getProperty('tax_id')}</p>
        <p class="text-dark">Contact First Name: {$employer->getProperty('contact_first_name')}</p>
        <p class="text-dark">Contact Last Name: {$employer->getProperty('contact_second_name')}</p>
        <p class="text-dark">Contact Email: {$employer->getProperty('contact_email')}</p>
        <p ><a href='/profile/delete' class="text-danger"> Remove Account </a></p>
    </div>
</div>
<div class="container">
    <div class="col w-75 m-auto">
        <h3>Posted offers and applications:</h3>
          {if ($result = $employer->getPostings())} 
            {while ($row = $result->fetch(PDO::FETCH_ASSOC))}
                {foreach $row as $key => $value }
                <h6 class="text-dark">{$key} : {$value}</h6>
                {/foreach}
                <a href='reviewapplications.php?posting={$row.ID}'>Review applications</a>
                <br><br>
            {/while}
          {/if}
    </div>
</div>
