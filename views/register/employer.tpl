{extends file='layouts/main.tpl'}

{block name=content}
<div class="container">
  <div class="col-sm-6 m-auto">
    <h3>Please provide us with your data to register a new employer account: </h3><br>
    <form method="post" action='/register/employer'>
      Company Name:   <input type="text" name="company_name" class="form-control"><br>
      Tax ID: <input type="text" name="tax_id" class="form-control"><br>
      Contact First Name: <input type="text" name="contact_first_name" class="form-control"><br>
      Contact Second Name: <input type="text" name="contact_second_name" class="form-control"><br>
      Contact Email: <input type="email" name="contact_email" class="form-control"><br>
      Password: <input type="password" name="pass" class="form-control"><br>
      City: <input type="text" name="city" class="form-control"><br>
      <input type='submit' value="Create User" class="btn btn-primary">
    </form>
  </div>
</div>
{/block}
