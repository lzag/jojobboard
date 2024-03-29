<div class="container">
    <div class="row justify-content-center mt-3">

        <!-- PROFILE COLUMN -->
        <div class="col-4 border">
            <h2 class="mb-0">Your Profile</h2>
            <p class="mt-0">
                <a href="/profile/edit"><small>Edit Profile</small></a>
            </p>
            <img class="img-fluid" width="140px" src="profile/photo?name={$user->getProperty('profile_image')}">
            <h5 class="mt-3 mb-0">
                {$user->getProperty('first_name') }
                {$user->getProperty('second_name') }
            </h5>

            <p class="text-secondary">
                {$user->getProperty('title') }
            </p>
            <p>CV link:

               {if $user->getProperty('cv_file') neq "Empty" }

                <a href="/resume/load">Link</a>

               {else}

                <a class="text-danger" href="/resume">Upload your CV</a>

                {/if} 

            </p>
            <p>Email:
                {$user->getProperty('email') }
            </p>
            <h6>Bio:</h6>
            <p>
                {$user->getProperty('bio') }
            </p>
        </div>

        <!-- APPLICATION COLUMN -->
        <div class="col-8">
            <h2>Applications</h2>

            <div class="mb-4">
                {if ($user->getProperty('applications') neq "Empty") }

                <small>Total:
                    {count($user->getProperty('applications')) }</small>

                {foreach $user->getProperty('applications') as $application}

                <h4>
                    Position:
                    {$application['title'] }
                </h4>
                <h6>
                    Company:
                    {$application['company_name'] }
                </h6>
                <p class="mt-0 pt-0 text-secondary">
                    <small>Applied on:
                        {$application['application_time'] }</small>
                </p>
                Status:
                <strong>
                    {$application['status'] }</strong> <br>

                <a class="btn btn-outline-primary my-1 py-1" href='/jobads?id={$application.application_id}'>See details</a>
                <a class="text-danger btn btn-outline-danger my-1 py-1" href='/applications/withdraw?id={$application.application_id}'>Withdraw</a><br>
            </div>

            {/foreach}

            {else}
            You have not applied to any jobs so far! <br>

            Check the latest offers now!

            {/if}

        </div>
    </div>
</div>
