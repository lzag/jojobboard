{extends file='layouts/main.tpl'}

{block name=content}
<div class="container">

    <div class="row">
        <div class="col-8 m-auto">
            <h3 class="text-center mb-5 mt-3">Search for the job you want!</h3>
            <form action="/jobads" method="get">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="keyword">Keywords: </label>
                        <input type="text" class="form-control" id="keyword" name="keyword" value="{echoGet('keyword')}">
                    </div>
                    <div class="form-group col">
                        <label for="location">Location: </label>
                        <input type="text" class="form-control" id="location" name="location" value="{echoGet('location')}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="salary_min">Salary min:</label>
                        <input type="text" class="form-control" id="salary_min" name="salary_min" value="{echoGet('salary_min')}">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="salary_max">Salary max:</label>
                        <input type="text" class="form-control" id="salary_max" name="salary_max" value="{echoGet('salary_max')}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="order">Order by</label>
                        <select name="order" class="form-control" id="order">
                            <option value="time_posted" {selected("order", "time_posted")}>Date</option>
                            <option value="salary" {selected("order", "salary")} >Salary</option>
                            <option value="title" {selected("order", "title")}>Relevance</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="order_type">ASC/DESC </label>
                        <select class="form-control" id="order_type" name="order_type">
                            <option value="ASC" {selected("order_type", "ASC")} >ASC</option>
                            <option value="DESC" {selected("order_type", "DESC")}>DESC</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="per_page">Per page</label>
                        <select class="form-control" id="per_page" name="per_page">
                            <option value="5" {selected("per_page", "5")}>5</option>
                            <option value="10" {selected("per_page", "10")}>10</option>
                            <option value="25" {selected("per_page", "25")}>25</option>
                            <option value="50" {selected("per_page", "50")} >50</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <input type="submit" name="submit" value="Search for jobs" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-8 m-auto">
            {$results = showResults()}
        </div>
    </div>
    <div class="row">
        <div class="col-8 m-auto">
            {pagination($results['total_hits'])}
        </div>
    </div>
    <div class="row">
        <div class="col-8 m-auto">
            {if (array_key_exists('local', $results))}
                {foreach $results.local as $row}
            <div class="card mx-auto my-2">
                <div class="card-body">
                    <h3 class="card-title">
                        {$row.title}
                    </h3>
                    <h6 class="card-subtitle mb-2 text-muted">Posted by:
                        {$row.company_name}
                    </h6>
                    <p class="card-text">
                        {$row.description}
                    </p>
                    {if isset($user) and isset($smarty.session.user) and $user->hasApplied($row.posting_id)}
                        <h5 class='text-info'>Status: <span class='badge badge-info'>{$user->getAppStatus($row.posting_id)}</span></h5>
                    {else}
                    <form action="{if isset($smarty.get.id)}applications{else}jobads{/if}" method="get">
                        <input type="hidden" name="id" value="{$row.posting_id}">
                        <input type="submit" value="{if isset($smarty.get.id)}Apply{else}See Details{/if}" class="btn btn-primary">
                    </form>
                    {/if}
                </div>
                <div class="card-footer">
                    <h6 class="text-secondary">Posting ID:
                        {$row.posting_id}
                    </h6>
                    <h6 class="text-secondary">Posted on:
                        {date("D d F Y", strtotime($row.time_posted))}
                    </h6>
                </div>
            </div>

                {/foreach}
            {/if}

            <!--    GET THE BACKFILL OFFERS -->
            {if array_key_exists('foreign', $results)}
                {foreach $results.foreign as $value}
            <div class="card mx-auto my-2">
                <div class="card-body">
                    <h3 class="card-title">
                        {$value->title}
                    </h3>
                    <h6 class="card-subtitle mb-2 text-muted">Posted by:
                        {$value->company}
                    </h6>
                    <p class="card-text">
                        {$value->description}
                    </p>
                    <a href="{$value->url}" class="btn btn-primary">See Details</a>
                </div>
                <div class="card-footer">
                    <h6 class="text-secondary">Site:
                        {$value->site}
                    </h6>
                    <h6 class="text-secondary">Posted on:
                        {date("D d F Y", strtotime($value->date))}
                    </h6>
                </div>
            </div>
                {/foreach}
            {/if}
        </div>
    </div>

</div>

{/block}