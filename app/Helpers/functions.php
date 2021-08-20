<?php
//获取文章元信息
function GetPostMetaData($post) {
    $output = "";
    if ($post['status'] == 'publish' || Gate::allows('CheckAdmin')) {
        $output = array(
            'id' => $post['id'],
            'slug' => $post['slug'],
            'title' => $post['title'],
            'created' => $post['created'],
            'modified' => $post['modified'],
            'content' => $post['content'],
            'type' => $post['type'],
            'status' => $post['status'],
            'views' => $post['views'],
            'likes' => $post['likes']
        );
    }
    return $output;
}
// 获取分页链接
function GetPageLink($page, $type) {
    if ($type != 'admin') {
        if ($page == 1) {
            $page_link = env('APP_URL') . '/' . $type . '.html';
        }
        $page_link = env('APP_URL') . '/' . $type . '/' . env('FENYEMULU') . '/' . $page . '.html';
    } else {
        if ($page == 1) {
            $page_link = env('APP_URL') . '/' . $type . '/edit';
        }
        $page_link = env('APP_URL') . '/' . $type . '/edit?page=' . $page;
    }
    return $page_link;
}
// 获取文章页链接
function GetPostLink($slug) {
    return env('APP_URL') . '/posts/' . $slug . '.html';
}
// 生成文章列表
function GetPostsLists($posts, $page=1, $type=0) {
    $html = "";
    $all_posts_num = count($posts);
    $page = (int)$page;
    $fenye = (int)env('FENYE');
    $all_pages_num = ceil($all_posts_num/$fenye);
    for ($i=1; $i<=$fenye; $i++) {
        $posts_for_fenye = ($page-1)*$fenye+$i;
        if ($posts_for_fenye <= count($posts)) {
            $post_id_for_fenye = $posts[$posts_for_fenye-1]['id'];
            $post = App\Models\Post::find($post_id_for_fenye)->toArray();
        }
        
        if (!empty($post)) {
            // $html .= '<div class="card">';
            $html .= '<div class="post-card">';
            if (GetPostCover($post['content']) !== ''){
                // $html .= '<img src="' . GetPostCover($post['content']) .'" class="card-img-top" alt="cover">';
                $html .= '<img data-src="' . GetPostCover($post['content']) .'" class="lazy post-card-cover" alt="cover">';
                $html .= '<div class="post-card-body with-cover">';
            } else {
                $html .= '<div class="post-card-body">';
            }
            // $html .= '<div class="card-body">';

            // Title
            // $html .= '<h5 class="card-title">';
            $html .= '<h5 class="post-card-title">';
            if (Gate::allows('CheckAdmin') && url() -> current() != route('posts.list', ['page' => $page, 'type' => $type])) {
            // if (Gate::allows('CheckAdmin')) {
                $html .= '<a href=' . url("admin/edit" . "?id=" . $post['id']) . '>' . $post['title'];;
            } else {
                $html .= '<a href=' . url("posts" . "/" . $post['slug']) . '.html' . '>' . $post['title'];;
            }
            $html .= '</a>';
            if ($post['status'] == 'secret') {
                $html .= ' | <i class="fas fa-user-lock"></i>';
            }
            if ($post['status'] == 'unpublish') {
                $html .= ' | <i class="fas fa-pencil-ruler"></i>';
            }
            $html .= '</h5>';
            // Title End
            $html .= '<i class="fas fa-edit" aria-hidden="true"></i>&nbsp;';
            $html .= $post['created'];
            $html .= ' | ';
            $html .= '<i class="fas fa-history" aria-hidden="true"></i>&nbsp;';
            $html .= $post['modified'];
            $html .= '<hr />';

            $preview = GetSummary($post['content']);

            if ($preview != "") {
                // $html .= '<p class="card-text">' . $preview . '</p>';
                $html .= '<p class="post-card-text">' . $preview . '</p>';
            }
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</br>';
        }
    }
    //生成新页码
    $html .= '<nav><ul class="justify-content-center pagination">';
    if ($type == 0 && Gate::allows('CheckAdmin')) {
        $type = 'admin';
    }
    $html .= '<li class="page-item"><a aria-label="首页" class="page-link" href="' . GetPageLink(1, $type) . '"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>';
    if ($page != 1) {
        $html .= '<li class="page-item"><a class="page-link" href="' . GetPageLink($page-1, $type) . '"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>';
    }
    for ($i=1; $i<=$all_pages_num; $i++) {
        if ($i >= $page-1 && $i <= $page +3) {
            if ($i == $page) {
                $html .= '<li class="page-item active"><span class="page-link" style="cursor: default;">' . $i . '</span></li>';            
            } else {
                $html .= '<li class="page-item"><a class="page-link" href="' . GetPageLink($i, $type) . '">' . $i . '</a></li>';
            }
        }
    }
    if ($page != $all_pages_num) {
        $html .= '<li class="page-item"><span class="page-link" style="cursor: default;">···</span></li>';
        $html .= '<li class="page-item"><a class="page-link" href="' . GetPageLink($page+1 ,$type) . '"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>';
    }
    $html .= '<li class="page-item"><a aria-label="尾页" class="page-link" href="' . GetPageLink($page+1, $type) . '"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
	$html .= '</ul></nav>';
    return $html;
}
// 生成单个文章卡片
function GeneratePostCard($post) {
    $out = '';
    // $post = Post::find($id);
    $post_title = $post['title'];
    $post_cover = GetPostCover($post['content']);
    $out .= '<div class="gallery">';
    $out .= '<a target="_blank" href="' . GetPostLink($post['slug']) . '">';
    if ($post_cover == '') {
        $post_cover = env('APP_URL') . '/static/img/cross.png';
    }
    $out .= '<img data-src="' . $post_cover . '" class="lazy mini-post-cover" alt="' . $post_title . '"' . '>';
    $out .= '<div class="desc">' . $post_title . '</div>';
    $out .= '</a>';
    $out .= '</div>';
    return $out;
}
//生成文章摘要
function GetSummary($post_content) {
    // 去除文章中的脚本及特殊字符
    // $post_content = 
    $preview = mb_substr($post_content,0,config('blog.SummaryNum'),'utf-8');
    $preview = preg_replace('~<~', "(", $preview);
    $preview = preg_replace('~>~', ")", $preview);
    return $preview;
}
//查找文章默认封面
function GetPostCover($post) {
    // $reg_match = '~' . env('APP_URL') . '/static/attachments' . '.*?(jpg|png|jpeg)' . '~';
    $reg_match = '~' . 'https://' . '.*?(jpg|png|jpeg)' . '~';
    preg_match($reg_match, $post, $match);
    if (!empty($match)) {
        return $match[0];  
    } else {
        // return env('APP_URL') . '/static/img/cross.png';
        return '';
    }
}
// 输出标题
function EchoTitle($title) {
    $out = "";
    if ( $title !="" ) {
        $out = $title . " | " . env('APP_NAME');
    } else {
        $out = env('APP_NAME');
    }
    return $out;
}
// 是否允许百度统计
function IfEnableBaiduTongji($if) {
    $out = '';
    if ($if = 'true') {
        $out = '<script>var _hmt=_hmt||[];(function(){var hm=document.createElement("script");hm.src="https://hm.baidu.com/hm.js?' . env('BAIDU_TONGJI') . '";var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(hm,s)})();</script>';
    }
    return $out;
}
// Sitemap Example
function Sitemap_Example($link, $time, $priority) {
    $out = '';
    $out .= '<url>';
    $out .= '<loc>' . $link . '</loc>';
    $out .= '<lastmod>' . $time . '</lastmod>';
    $out .= '<changefreq>always</changefreq>';
    $out .= '<priority>' . $priority . '</priority>';
    $out .= '</url>';
    return $out;
}
// Sitemap
function GetSitemap() {
    $out = '';
    $out .= '<?xml version="1.0" encoding="utf-8"?>';
    $out .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $posts_slug = App\Models\Post::select('slug')->addSelect('modified')->where('status','publish')->orderBy('created','desc')->get()->toArray();
    $out .= Sitemap_Example(env('APP_URL'), substr($posts_slug[0]['modified'],0,10), 1);
    foreach ($posts_slug as $post_slug) {
        $out .= Sitemap_Example(GetPostLink($post_slug['slug']), substr($post_slug['modified'],0,10), 0.8);
    }
    $out .= '</urlset>';
    return $out;
}
function GetPostsTotal($type) {
    return count(App\Models\Post::select('id')->where('type',$type)->where('status','publish')->get()->toArray());
}
// 获取最新文章
function GetTheNewestPosts($type) {
    $out = '';
    $posts = App\Models\Post::where('type',$type)->where('status','publish')->limit(env('SHOW_POSTS_NUM'))->orderBy('created','desc')->get()->toArray();
    foreach ($posts as $post) {
        $out .= GeneratePostCard($post);
    }
    return $out;
}
// 首页卡片
function GetHomeMiniCard($type) {
    $out = '';
    $out .= '<div id="' . $type . '" class="home">';
    $out .= '<div class="mini-topbar">';
    $out .= '<ul><li><p>' . GetHomeMiniCardInChinese($type) . '</p></li><li>';
    $out .= '<a href="' . env('APP_URL') . '/' . $type . '.html">';
    if (GetPostsTotal($type) > env('SHOW_POSTS_NUM')) {
        $out .= '还有' . GetPostsTotal($type)-env('SHOW_POSTS_NUM') . '篇文章 ';
    }
    $out .= '<i class="fas fa-chevron-right"></i></a></li></ul></div>';
    $out .= GetTheNewestPosts($type);
    $out .= '</div>';
    return $out;
}
// $type对应中文名
function GetHomeMiniCardInChinese($type) {
    if ($type == 'article') {
        return '最新文章';
    } elseif ($type == 'diary') {
        return '日记';
    }
}



?>