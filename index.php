<?php  
    require_once('Template.php'); 

    $comments = [
        [
            'author_name'  => 'Caíque',
            'id'           => 22 
        ] 
    ];
 
    $template = new Template();

    $template -> set_data(
        [
            'comment_answer_button_text'=>'Responder comentário',
            'comment_answer_button_url' =>'https://www.google.com/'
        ]
    );

    $template -> set_template( 'templates/template.php'); 
    $template -> load_file( 'templates/header.php' , ['site_name' => 'Cabeçalho do site'] ); 
    $template -> load_file( 'templates/comment.php' , $comments, 'comment' );
     
    $template -> make_page();
?>