<?php

namespace ShawnHooper\RemoveUTMCodes;
use \WP_CLI;
use WP_Post;
use WP_Query;

class Remove_UTM_Command {

    private bool $dry_run = false;

	/**
	 * Remove UTM Codes from links in post content
	 *
	 * ## OPTIONS
	 *
	 * [--dry-run]
	 * : Don't actually make the changes!
	 *
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *     wp remove-utm-codes
	 *
	 * @when after_wp_load
	 */
	public function __invoke($args, $assoc_args) : void {
        $this->dry_run = isset($assoc_args['dry-run']);

        WP_CLI::line('Starting process of removing UTM codes....');

        $posts = get_posts([
           'posts_per_page' => -1,
        ]);

        $count = count($posts);
        WP_CLI::line("Found {$count} posts");

        foreach($posts as $post) {
            $this->removeUTMFromPost($post);
        }

        WP_CLI::success("Processing Complete");
	}

    private function removeUTMFromPost(WP_Post $post) {
        WP_CLI::line("Processing: {$post->ID} - {$post->post_title}");

        $links = $this->linkExtractor($post->post_content);

        foreach($links as $link) {
            $stripped = $this->stripUTM($link);

            if ( $link[0] === $stripped ) {
                WP_CLI::line("Link {$link[0]} does not contain any UTM codes.  Skipping");
                continue;
            }


            if ( $this->dry_run) {
                WP_CLI::line("Dry Run: Would replace {$link[0]} with $stripped");
            } else {
                $post->post_content = str_replace($link[0], $stripped, $post->post_content);
                wp_update_post($post);
                WP_CLI::success("Replaced {$link[0]} with $stripped");
            }
        }

        WP_CLI::success("Completed Processing: {$post->ID} - {$post->post_title}");
    }

    private function linkExtractor($html) : array
    {
        $linkArray = [];
        if(preg_match_all('/<a\s+.*?href=[\"\']?([^\"\' >]*)[\"\']?[^>]*>(.*?)<\/a>/i', $html, $matches, PREG_SET_ORDER)){
            foreach ($matches as $match) {
                $linkArray[] = [$match[1], $match[2]];
            }
        }
        return $linkArray;
    }

    private function stripUTM(array $link) : string {

        $new_link = preg_replace( '/&?utm_.+?(&|$)$/', '', $link[0] );

        if ( str_ends_with($new_link, '&amp;')) {
            $new_link = substr($new_link, 0, strlen($new_link)-5);
        }

        if ( str_ends_with($new_link, '&')) {
            $new_link = substr($new_link, 0, strlen($new_link)-1);
        }

        if ( str_ends_with($new_link, '?')) {
            $new_link = substr($new_link, 0, strlen($new_link)-1);
        }


        return $new_link;

    }

}
