<?php
function wpfc_post_types() {
    $labels = array(
        'name'                  => _x( 'Fact-checks', 'Post type general name', 'wpfc' ),
        'singular_name'         => _x( 'Fact-check', 'Post type singular name', 'wpfc' ),
        'menu_name'             => _x( 'Fact-checks', 'Admin Menu text', 'wpfc' ),
        'name_admin_bar'        => _x( 'Fact-check', 'Add New on Toolbar', 'wpfc' ),
        'add_new_item'          => __( 'Add New Fact-check', 'wpfc' ),
        'new_item'              => __( 'New Fact-check', 'wpfc' ),
        'edit_item'             => __( 'Edit Fact-check', 'wpfc' ),
        'view_item'             => __( 'View Fact-check', 'wpfc' ),
        'all_items'             => __( 'All Fact-checks', 'wpfc' ),
        'search_items'          => __( 'Search Fact-checks', 'wpfc' ),
        'parent_item_colon'     => __( 'Parent Fact-checks:', 'wpfc' ),
        'not_found'             => __( 'No fact-checks found.', 'wpfc' ),
        'add_new'               => __( 'Add New', 'wpfc' ),
        'not_found_in_trash'    => __( 'No fact-checks found in Trash.', 'wpfc' ),
        'featured_image'        => _x( 'Fact-check Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'wpfc' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'wpfc' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'wpfc' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'wpfc' ),
        'archives'              => _x( 'Fact-check archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'wpfc' ),
        'insert_into_item'      => _x( 'Insert into fact-check', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'wpfc' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this fact-check', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'wpfc' ),
        'filter_items_list'     => _x( 'Filter fact-checks list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'wpfc' ),
        'items_list_navigation' => _x( 'Fact-checks list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'wpfc' ),
        'items_list'            => _x( 'Fact-checks list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'wpfc' ),
    );
 
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'fact-checking' ),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 10,
        'menu_icon'             => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkxheWVyXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48c3R5bGUgdHlwZT0idGV4dC9jc3MiPgoJLnN0MHtmaWxsOiM0MUFENDk7fQo8L3N0eWxlPjxnPjxwb2x5Z29uIGNsYXNzPSJzdDAiIHBvaW50cz0iNDM0LjgsNDkgMTc0LjIsMzA5LjcgNzYuOCwyMTIuMyAwLDI4OS4yIDE3NC4xLDQ2My4zIDE5Ni42LDQ0MC45IDE5Ni42LDQ0MC45IDUxMS43LDEyNS44IDQzNC44LDQ5ICAgICAiLz48L2c+PC9zdmc+',
        'supports'              => array( 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'thumbnail' ),
        'taxonomies'            => [ 'category', 'post_tag' ]
    );
 
    register_post_type( 'wpfc-fact-checking', $args );
}