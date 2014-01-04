<?php

use Mockery as m;

/**
 * Feature: As an user I would like to see the list of blog posts
 */
class SeePostList extends AcceptanceTestCase {

    /**
     * Scenario: Simply visit the home page or post list
     * @return void
     */
    public function testSimplyVisitList()
    {
        // Given
        $this->site_has_posts();

        // When
        $this->i_visit_url('/');

        // Then
        $this->i_should_see_post_list();
    }

    protected function site_has_posts()
    {
        // Definitions
        $posts = array();

        $posts[0] = App::make('Pulse\Cms\Post');
        $posts[0]->title = 'Sample Post A';
        $posts[0]->slug = 'sample_post_A';
        $posts[0]->lean_content = 'a sample post a';
        $posts[0]->content = 'the sample post a';
        $posts[0]->author_id = 1;

        $posts[1] = App::make('Pulse\Cms\Post');
        $posts[1]->title = 'Sample Post B';
        $posts[1]->slug = 'sample_post_b';
        $posts[1]->lean_content = 'a sample post b';
        $posts[1]->content = 'the sample post b';
        $posts[1]->author_id = 1;

        $repo = m::mock('Pulse\Cms\PostRepository');

        // Expectations
        $repo->shouldReceive('all')
            ->once()->with()
            ->andReturn($posts);

        App::instance('Pulse\Cms\PostRepository', $repo);
    }

    /**
     * Asserts if user sees the post list
     * @return void
     */
    protected function i_should_see_post_list()
    {
        $this->assertTrue($this->client->getResponse()->isOk());

        $this->assertContains('Sample Post A', $this->client->getResponse()->getContent());

        $this->assertContains('Sample Post B', $this->client->getResponse()->getContent());
    }
}