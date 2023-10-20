
<meta charset="UTF-8">

<?php

require '../config.php';

$post = mysqli_fetch_assoc(mysqli_query($db,"select * from com_posts order by p_id desc"));
echo $post['content'];