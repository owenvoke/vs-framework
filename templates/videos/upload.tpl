{include file='include/header.tpl'}
<div class="container">
    <h1>Upload</h1>
    {if $data->can_upload}
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{$data->title}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control max100"
                          id="description"
                          name="description"
                          maxlength="1000"
                          rows="10">{$data->description}</textarea>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control"
                        id="category"
                        name="category">
                    {foreach $data->categories as $category}
                        <option value="{$category->id}"
                                {if $data->category == $category->id} selected{/if}>{$category->name}</option>
                    {/foreach}
                </select>
            </div>
            <div class="form-group">
                <label for="video">File</label>
                <input type="file" id="video" name="video">
                <p class="help-block">Max size: {VS\Config::MAX_UPLOAD_SIZE|file_size}</p>
            </div>
            <input class="btn btn-default" type="submit" value="Log In">
        </form>
    {else}
        <p class="alert alert-warning">
            Only members can upload. Please <a href="/register" class="alert-link">register</a> if you'd like to upload,
            or <a href="/login" class="alert-link">log in</a> if you already have an account.
        </p>
    {/if}
</div>
{include file='include/footer.tpl'}