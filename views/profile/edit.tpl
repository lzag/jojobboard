{extends file='layouts/main.tpl'}

{block name=content}
<div class="container">
    <div class="row">
        <div class="col-sm-8 mx-auto">
            <form method="POST" action="/profile" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="userEmail">Email address</label>
                    <input name="email" type="email" class="form-control" id="userEmail" aria-describedby="emailHelp" value="{$user->getProperty('email')}">
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input name="first_name" type="text" class="form-control" id="firstName" value="{$user->getProperty('first_name')}">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input name="last_name" type="text" class="form-control" id="lastName" value="{$user->getProperty('second_name')}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" type="text" class="form-control" id="title" value="{$user->getProperty('title')}">
                </div>
                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea name="bio" id="bio" cols="6" rows="5" class="form-control">{$user->getProperty('bio')}</textarea>
                </div>
                <div class="form-group">
                    <label for="CV">CV</label>
                    <div class="row">
                        <div class="col"><a class="btn btn-primary" href="/resume/load">See current CV</a></div>
                        <div class="col"><a class="btn btn-primary" href="/resume">Upload new CV</a></div>
                    </div>
                </div>
                <div class="form-row">
                    Photo
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        Current photo: <br>
                        <img class="img-fluid" width="140px" src="/upload/users/images/{$user->getProperty('profile_image')}">
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="photo">Upload new photo:</label>
                            <input name="photo" type="file" class="form-control" id="photo">
                        </div>
                    </div>
                </div>
                <input name="user_id" type="hidden" value="{$user->getProperty('user_id')}">
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
{/block}
