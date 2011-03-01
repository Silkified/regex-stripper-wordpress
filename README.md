Update the DB credentials and category ID at the top of the script.

Added:
 Setting cat_id to 0 does replace on entire site content.

Add something like this at the end of the file:

$c = new remove_content;
$c->connect();
$c->process();
