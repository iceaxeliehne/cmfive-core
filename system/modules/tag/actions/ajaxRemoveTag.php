<?php

function ajaxRemoveTag_GET(Web $w) {
	$w->setLayout(null);
	
	list($class, $id) = $w->pathMatch();
	$tag_id = $w->request('tag_id');
	
	if (empty($class) || empty($id) || empty($tag_id)) {
		return;
	}
	
	if (!class_exists($class)) {
		return;
	}
	
	// Check that tag and object target exist
	$object_target = $w->Tag->getObject($class, $id);
	if (empty($object_target->id)) {
		return;
	}
	
	$tag = $w->Tag->getTag($tag_id);
	if (empty($tag->id)) {
		return;
	}
	
	// Check that tag actually assigned
	$existing_tag_assign = $w->Tag->getObject('TagAssign', ['object_class' => $class, 'object_id' => $id, 'tag_id' => $tag->id, 'is_deleted' => 0]);
	if (!empty($existing_tag_assign)) {
		$existing_tag_assign->delete();
	}
	
	$w->out('{}');
	
}