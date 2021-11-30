{extends file='layouts/main.tpl'}

{block name=content}
<div class="container">
    <div class="row">
        <div class="col-8 m-auto">
            <div class="card mx-auto my-2">
                <div class="card-body">
                    <h3 class="card-title">
                        {$ad->title}
                    </h3>
                    <h6 class="card-subtitle mb-2 text-muted">
                        Posted by: {$ad->company_name}
                    </h6>
                    <p class="card-text">
                        {$ad->description}
                    </p>
                </div>
                <div class="card-footer">
                    <h6 class="text-secondary">
                        Posting ID: {$ad->id}
                    </h6>
                    <h6 class="text-secondary">
                        Posted on: {$ad->created_at}
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>
{/block}