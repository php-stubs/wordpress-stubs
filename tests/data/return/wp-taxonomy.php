<?php

declare(strict_types=1);

namespace PhpStubs\WordPress\Core\Tests;

use function PHPStan\Testing\assertType;

// Labels are built by get_taxonomy_labels(), which fills in every default.
assertType('string', Faker::wpTaxonomy()->labels->name);
assertType('string', Faker::wpTaxonomy()->labels->singular_name);
assertType('string', Faker::wpTaxonomy()->labels->menu_name);
assertType('string', Faker::wpTaxonomy()->labels->name_admin_bar);
assertType('string', Faker::wpTaxonomy()->labels->template_name);

// These have no default for one of the two hierarchies.
assertType('string|null', Faker::wpTaxonomy()->labels->popular_items);
assertType('string|null', Faker::wpTaxonomy()->labels->parent_item);
assertType('string|null', Faker::wpTaxonomy()->labels->filter_by_item);

assertType('string', Faker::wpTaxonomy()->cap->manage_terms);
assertType('string', Faker::wpTaxonomy()->cap->edit_terms);
assertType('string', Faker::wpTaxonomy()->cap->delete_terms);
assertType('string', Faker::wpTaxonomy()->cap->assign_terms);
