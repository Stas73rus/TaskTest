<?php

/*massiv*/
$categories = array(
    array(
        "id" => 1,
        "title" =>  "Обувь",
        'children' => array(
            array(
                'id' => 2,
                'title' => 'Ботинки',
                'children' => array(
                    array('id' => 3, 'title' => 'Кожа'),
                    array('id' => 4, 'title' => 'Текстиль'),
                ),
            ),
            array('id' => 5, 'title' => 'Кроссовки',),
        )
    ),
    array(
        "id" => 6,
        "title" =>  "Спорт",
        'children' => array(
            array(
                'id' => 7,
                'title' => 'Мячи'
            )
        )
    ),
);

/*query function*/
searchCategory($categories, 2);

/*function search*/
function searchCategory($categories, $id) {
        foreach ($categories as $category) {
            if ($id == $category['id']) {
                echo $category['title'];
            } elseif (!($category['children'] == null)) {
                echo searchCategory($category['children'], $id);
            }
        }
}

