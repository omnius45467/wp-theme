<?php
function add_my_awesome_widgets_collection($folders){
    $folders[] = ImicFrameworkPath . '/page-builder/widgets/';
    return $folders;
}
add_filter('siteorigin_widgets_widget_folders', 'add_my_awesome_widgets_collection');

function adore_add_widget_tabs($tabs) {
    $tabs[] = array(
        'title' => __('Adore Theme Widgets', 'framework'),
        'filter' => array(
            'groups' => array('framework')
        )
    );

    return $tabs;
}
add_filter('siteorigin_panels_widget_dialog_tabs', 'adore_add_widget_tabs', 30);


?>