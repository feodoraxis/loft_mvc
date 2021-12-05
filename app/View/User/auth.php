<?php echo $data['message']; ?>
<form action="<?php echo $data['action']; ?>" method="post">
    <label for="">
        your email
        <input type="text" name="user[email]">
    </label><br />
    <label for="">
        your password
        <input type="password" name="user[password]">
    </label><br />

    <button>Auth</button>
</form>