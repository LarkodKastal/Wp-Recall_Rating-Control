<?

add_filter('public_form_rcl','rating_determinant_user',10,2);
function rating_determinant_user($fls,$data){
    global $rcl_options;
    global $user_ID;
    if ($data->post_type=='post') {
        if (rcl_get_user_rating($user_ID)<=$rcl_options['advanced_limited_post']) {
            header("Location: http://rnbeeru.pp.ua/errorl/");
        }
    }
}

add_filter('pre_update_postdata_rcl','edit_publicform_rcl');
function edit_publicform_rcl($post){
    global $rcl_options;
    global $user_ID;
    if($post['post_type']=='post-wall')
    {
        if (rcl_get_user_rating($user_ID)<=$rcl_options['advanced_limited_post_wall']) {
            header("Location: http://rnbeeru.pp.ua/errorw/");
            exit();
        }
    } 
    if($post['post_type']=='post-group')
    {
        if (rcl_get_user_rating($user_ID)<=$rcl_options['advanced_limited_post_group']) {
            header("Location: http://rnbeeru.pp.ua/errorg/");
            exit();
        }
    } 
    return $post;
}


if(is_admin()){ add_filter('admin_options_wprecall', 'rcl_advanced_rating_limited_post'); }

function rcl_advanced_rating_limited_post($content){

    global $rcl_options;
    global $user_ID;

    $options = new Rcl_Options(__FILE__);

       $content .= $options->options(
            __('Типы публикаций','rcl-advanced-rating-system'),

            $options->option_block(
                array(
                    $options->title(__("Минимальный рейтинг для публикации",'rcl-advanced-rating-system')),
                    $options->label(__("рейтинг для post",'rcl-advanced-rating-system')),
                    $options->option('text',array(
                        'name'=>'advanced_limited_post'
                        )
                    ),
                    $options->label(__("рейтинг для post-group",'rcl-advanced-rating-system')),
                    $options->option('text',array(
                        'name'=>'advanced_limited_post_group'
                        )
                    ),
                    $options->label(__("рейтинг для post-wall",'rcl-advanced-rating-system')),
                    $options->option('text',array(
                        'name'=>'advanced_limited_post_wall'
                        )
                    ),
                    $options->notice(__( "Ntrcn" )),
                )
            )
    );  
    return $content;
}