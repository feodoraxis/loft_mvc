<?php echo $data['message']; ?>

<form action="<?php echo $data['action']?>" method="post">
    <textarea name="message" id="" cols="30" rows="10"></textarea>
    <input type="hidden" name="action" value="add">
    <button>Send</button>
</form>

<?php foreach ($data['list'] as $item) : ?>
    <p><?php echo $item['text']; ?></p>
    <i><?php echo $item['author']; ?></i>
    <?php echo $item['actions']; ?>
    <hr />
<?php endforeach; ?>
