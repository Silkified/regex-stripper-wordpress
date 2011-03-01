<?php

class remove_content {

  var $regex = '/(<img.+?>)/';
  var $handle;
  var $db_host = '127.0.0.1';
  var $db_user = 'root';
  var $db_pass = '';
  var $db_name = 'desktop-new';
  var $category_id = 0;

  public function connect()
  {
    $this->handle = mysql_connect(
      $this->db_host,
      $this->db_user,
      $this->db_pass
    ) or die( mysql_error() );
    mysql_select_db(
      $this->db_name,
      $this->handle
    ) or die( mysql_error() );
    return $this;
  }

  public function process()
  {
    $category_ids = $this->get_results( "SELECT `object_id` FROM `wp_term_relationships` WHERE `term_taxonomy_id` = $category->id" );
    foreach( $category_ids as &$category )
    {
      $category = $category['object_id'];
    }
    foreach($category_ids as $post_id)
    {
      $post_contents = $this->get_results( "SELECT `post_content` FROM `wp_posts` WHERE `ID` = $post_id AND `post_type` = 'post'" );
      $post_contents = $post_contents[0]['post_content'];
      $post_contents = preg_replace($this->regex, '', $post_contents);
      if($post_contents) $post_contents = $this->save( "UPDATE `wp_posts` SET `post_content` = '" . mysql_escape_string($post_contents) . "' WHERE `ID` = $post_id" );
    }
  }

  public function get_results( $query )
  {
    if( !$query ) return NULL;
    $result = mysql_query( $query, $this->handle ) or die( mysql_error() );
    while( $row = mysql_fetch_assoc( $result ) )
    {
      $returned_result[] = $row;
    }

    return $returned_result;
  }

  public function save( $query )
  {
    if( !$query ) return NULL;
    $result = mysql_query( $query, $this->handle ) or die( mysql_error() );

    return $result;
  }

}

