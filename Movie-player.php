<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package 		PyroCMS
 * @subpackage 		Movie player
 * @author              DevDevil @ Johan Overeem
 *
 * Player a youtube end vimeo movie
 */

class Widget_Movie_player extends Widgets
{
	public $title = 'Movie player';
	public $description = 'Player a youtube end vimeo movie.';
	public $author = 'DevDevil @ Johan Overeem';
        public $website = 'http://johanovereem.nl';
        public $version = '0.1';

	public $fields = array(
		array(
			'field'   => 'url',
			'label'   => 'URL',
			'rules'   => 'url'
		),
		array(
			'field'   => 'width',
			'label'   => 'Width',
			'rules'   => 'numeric'
		),
                array(
			'field'   => 'height',
			'label'   => 'Height',
			'rules'   => 'numeric'
		)
	);

	public function run($options)
	{
            !empty($options['width']) OR $options['width'] = '640';
            !empty($options['height']) OR $options['height'] = '385';

            $options['html'] = $this->convert_videos($options['url'], $options);
            
            return $options;
	}

        
        private function convert_videos($string, $options) {
            
            $rules = array(
                '#http://(www\.)?youtube\.com/watch\?v=([^ &\n]+)(&.*?(\n|\s))?#i' => '<object width="'. $options['width'] .'" height="'. $options['height'] .'"><param name="movie" value="http://www.youtube.com/v/$2"></param><embed src="http://www.youtube.com/v/$2" type="application/x-shockwave-flash" width="'. $options['width'] .'" height="'. $options['height'] .'"></embed></object>',

                '#http://(www\.)?vimeo\.com/([^ ?\n/]+)((\?|/).*?(\n|\s))?#i' => '<object width="'. $options['width'] .'" height="'. $options['height'] .'"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=$2&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=$2&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'. $options['width'] .'" height="'. $options['height'] .'"></embed></object>'
            );

            foreach ($rules as $link => $player)
                $string = preg_replace($link, $player, $string);

            return $string;
        }

}