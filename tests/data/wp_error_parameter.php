<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;
use function wp_clear_scheduled_hook;
use function wp_insert_attachment;
use function wp_insert_category;
use function wp_insert_link;
use function wp_insert_post;
use function wp_reschedule_event;
use function wp_schedule_event;
use function wp_schedule_single_event;
use function wp_set_comment_status;
use function wp_unschedule_event;
use function wp_unschedule_hook;
use function wp_update_comment;
use function wp_update_post;

$type = new TypeHelper();

// wp_insert_link()
assertType('int<0, max>', wp_insert_link($type->array));
assertType('int<0, max>', wp_insert_link($type->array, false));
assertType('int<1, max>|WP_Error', wp_insert_link($type->array, true));
assertType('int<0, max>|WP_Error', wp_insert_link($type->array, $type->bool));

// wp_insert_category()
assertType('int<0, max>', wp_insert_category($type->array));
assertType('int<0, max>', wp_insert_category($type->array, false));
assertType('int<1, max>|WP_Error', wp_insert_category($type->array, true));
assertType('int<0, max>|WP_Error', wp_insert_category($type->array, $type->bool));

// wp_set_comment_status()
assertType('bool', wp_set_comment_status($type->int, 'spam'));
assertType('bool', wp_set_comment_status($type->int, 'spam', false));
assertType('WP_Error|true', wp_set_comment_status($type->int, 'spam', true));
assertType('bool|WP_Error', wp_set_comment_status($type->int, 'spam', $type->bool));

// wp_update_comment()
assertType('0|1|false', wp_update_comment($type->array));
assertType('0|1|false', wp_update_comment($type->array, false));
assertType('0|1|WP_Error', wp_update_comment($type->array, true));
assertType('0|1|WP_Error|false', wp_update_comment($type->array, $type->bool));

// wp_schedule_single_event()
assertType('bool', wp_schedule_single_event($type->int, 'hook'));
assertType('bool', wp_schedule_single_event($type->int, 'hook', $type->array));
assertType('bool', wp_schedule_single_event($type->int, 'hook', $type->array, false));
assertType('WP_Error|true', wp_schedule_single_event($type->int, 'hook', $type->array, true));
assertType('bool|WP_Error', wp_schedule_single_event($type->int, 'hook', $type->array, $type->bool));

// wp_schedule_event()
assertType('bool', wp_schedule_event($type->int, 'daily', 'hook'));
assertType('bool', wp_schedule_event($type->int, 'daily', 'hook', $type->array));
assertType('bool', wp_schedule_event($type->int, 'daily', 'hook', $type->array, false));
assertType('WP_Error|true', wp_schedule_event(1, 'daily', 'hook', $type->array, true));
assertType('bool|WP_Error', wp_schedule_event(1, 'daily', 'hook', $type->array, $type->bool));

// wp_reschedule_event()
assertType('bool', wp_reschedule_event($type->int, 'daily', 'hook'));
assertType('bool', wp_reschedule_event($type->int, 'daily', 'hook', $type->array));
assertType('bool', wp_reschedule_event($type->int, 'daily', 'hook', $type->array, false));
assertType('WP_Error|true', wp_reschedule_event($type->int, 'daily', 'hook', $type->array, true));
assertType('bool|WP_Error', wp_reschedule_event($type->int, 'daily', 'hook', $type->array, $type->bool));

// wp_unschedule_event()
assertType('bool', wp_unschedule_event($type->int, 'hook'));
assertType('bool', wp_unschedule_event($type->int, 'hook', $type->array));
assertType('bool', wp_unschedule_event($type->int, 'hook', $type->array, false));
assertType('WP_Error|true', wp_unschedule_event($type->int, 'hook', $type->array, true));
assertType('bool|WP_Error', wp_unschedule_event($type->int, 'hook', $type->array, $type->bool));

// wp_clear_scheduled_hook()
assertType('int<0, max>|false', wp_clear_scheduled_hook('hook'));
assertType('int<0, max>|false', wp_clear_scheduled_hook('hook', $type->array));
assertType('int<0, max>|false', wp_clear_scheduled_hook('hook', $type->array, false));
assertType('int<0, max>|WP_Error', wp_clear_scheduled_hook('hook', $type->array, true));
assertType('int<0, max>|WP_Error|false', wp_clear_scheduled_hook('hook', $type->array, $type->bool));

// wp_unschedule_hook()
assertType('int<0, max>|false', wp_unschedule_hook('hook'));
assertType('int<0, max>|false', wp_unschedule_hook('hook', false));
assertType('int<0, max>|WP_Error', wp_unschedule_hook('hook', true));
assertType('int<0, max>|WP_Error|false', wp_unschedule_hook('hook', $type->bool));

// wp_insert_post()
assertType('int<0, max>', wp_insert_post($type->array));
assertType('int<0, max>', wp_insert_post($type->array, false));
assertType('int<0, max>', wp_insert_post($type->array, false, true));
assertType('int<0, max>', wp_insert_post($type->array, false, false));
assertType('int<1, max>|WP_Error', wp_insert_post($type->array, true));
assertType('int<1, max>|WP_Error', wp_insert_post($type->array, true, true));
assertType('int<1, max>|WP_Error', wp_insert_post($type->array, true, false));
assertType('int<0, max>|WP_Error', wp_insert_post($type->array, $type->bool));
assertType('int<0, max>|WP_Error', wp_insert_post($type->array, $type->bool, true));
assertType('int<0, max>|WP_Error', wp_insert_post($type->array, $type->bool, false));

// wp_update_post()
assertType('int<0, max>', wp_update_post($type->array));
assertType('int<0, max>', wp_update_post($type->array, false));
assertType('int<0, max>', wp_update_post($type->array, false, true));
assertType('int<0, max>', wp_update_post($type->array, false, false));
assertType('int<1, max>|WP_Error', wp_update_post($type->array, true));
assertType('int<1, max>|WP_Error', wp_update_post($type->array, true, true));
assertType('int<1, max>|WP_Error', wp_update_post($type->array, true, false));
assertType('int<0, max>|WP_Error', wp_update_post($type->array, $type->bool));
assertType('int<0, max>|WP_Error', wp_update_post($type->array, $type->bool, true));
assertType('int<0, max>|WP_Error', wp_update_post($type->array, $type->bool, false));

// wp_insert_attachment()
assertType('int<0, max>', wp_insert_attachment($type->array));
assertType('int<0, max>', wp_insert_attachment($type->array, true));
assertType('int<0, max>', wp_insert_attachment($type->array, false));
assertType('int<0, max>', wp_insert_attachment($type->array, true, $type->int));
assertType('int<0, max>', wp_insert_attachment($type->array, true, $type->int, false));
assertType('int<0, max>', wp_insert_attachment($type->array, true, $type->int, false, false));
assertType('int<0, max>', wp_insert_attachment($type->array, true, $type->int, false, true));
assertType('int<1, max>|WP_Error', wp_insert_attachment($type->array, false, $type->int, true));
assertType('int<1, max>|WP_Error', wp_insert_attachment($type->array, false, $type->int, true, true));
assertType('int<1, max>|WP_Error', wp_insert_attachment($type->array, false, $type->int, true, false));
assertType('int<0, max>|WP_Error', wp_insert_attachment($type->array, true, $type->int, $type->bool));
assertType('int<0, max>|WP_Error', wp_insert_attachment($type->array, true, $type->int, $type->bool, true));
assertType('int<0, max>|WP_Error', wp_insert_attachment($type->array, true, $type->int, $type->bool, false));
