<?php
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

// Định nghĩa breadcrumbs cho trang chính (home)
Breadcrumbs::for('home.index', function ($trail) {
    $trail->push('Trang chủ', route('home.index'));
});

// Định nghĩa breadcrumbs cho trang giới thiệu
Breadcrumbs::for('about.index', function ($trail) {
    $trail->parent('home.index');
    $trail->push('Giới thiệu', route('about.index'));
});

// Định nghĩa breadcrumbs cho trang liên hệ
Breadcrumbs::for('contact.index', function ($trail) {
    $trail->parent('home.index');
    $trail->push('Liên hệ', route('contact.index'));
});

// Định nghĩa breadcrumbs cho trang danh sách bài viết
Breadcrumbs::for('blog.index', function ($trail) {
    $trail->parent('home.index');
    $trail->push('Tin tức', route('blog.index'));
});

