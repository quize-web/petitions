<?php

class model__main extends model
{

  public function getdata() {
    $posts = array(
        [ "title" => "Заголовок записи 1",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum, voluptatibus." ],
        [ "title" => "Заголовок записи 2",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum, voluptatibus." ],
        [ "title" => "Заголовок записи 3",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum, voluptatibus." ],
        [ "title" => "Заголовок записи 4",
            "content" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum, voluptatibus." ]
    );
    return $posts;
  }

}


