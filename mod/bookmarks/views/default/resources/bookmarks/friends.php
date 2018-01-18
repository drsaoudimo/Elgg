<?php
/**
 * Elgg bookmarks plugin friends page
 *
 * @package ElggBookmarks
 */

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner instanceof ElggUser) {
	throw new \Elgg\EntityNotFoundException();
}

elgg_push_breadcrumb(elgg_echo('collection:object:bookmarks'), 'bookmarks/all');
elgg_push_breadcrumb($page_owner->name, "bookmarks/owner/$page_owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button('bookmarks', 'add', 'object', 'bookmarks');

$title = elgg_echo('collection:object:bookmarks:friends');

$content = elgg_list_entities([
	'type' => 'object',
	'subtype' => 'bookmarks',
	'full_view' => false,
	'relationship' => 'friend',
	'relationship_guid' => $page_owner->guid,
	'relationship_join_on' => 'owner_guid',
	'no_results' => elgg_echo('bookmarks:none'),
	'preload_owners' => true,
	'preload_containers' => true,
]);

$params = [
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
];

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
