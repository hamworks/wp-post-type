<?php
/**
 * Builder Tests.
 *
 * @package HAMWORKS\WP\Post_Type
 */

use HAMWORKS\WP\Post_Type\Builder;

/**
 * Class Builder_Test
 *
 * @package HAMWORKS\WP\Post_Type
 */
class Builder_Test extends \WP_UnitTestCase {

	/**
	 * Test sample.
	 *
	 * @test
	 */
	public function test_create() {
		$builder = new Builder( 'sample_book', 'Book' );
		$builder->set_options(
			array(
				'public'      => true,
				'description' => 'post_type_for_test',
			)
		);
		$builder->create();

		$post_type = $builder->get_post_type();
		$this->assertEquals( 'sample_book', $post_type->name );
		$this->assertEquals( 'Book', $post_type->label );
		$this->assertEquals( true, $post_type->has_archive );
		$this->assertEquals( 'sample-books', $post_type->rest_base );
	}
}
