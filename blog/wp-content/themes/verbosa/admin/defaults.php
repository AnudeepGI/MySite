<?php
/**
 * Theme Defaults
 *
 * @package Verbosa
 */

function verbosa_get_option_defaults() {

	$sample_pages = verbosa_get_default_pages();

	// DEFAULT OPTIONS ARRAY
	$verbosa_defaults = array(

	"verbosa_db" 				=> "0.9",

	"verbosa_sitelayout"		=> "2cSl",
	"verbosa_sitewidth"  		=> 1440, // pixels
	//"verbosa_contentwidth" 	=> 66, 	// percent
	//"verbosa_sidebar"		=> 34, 	// percent
	"verbosa_sidebar" 			=> 440, // pixels
	"verbosa_sidebarback"		=> 1, // 0,1
	"verbosa_magazinelayout"	=> 2, 	// two column

	"verbosa_headerheight" 		=> 250, // pixels
	"verbosa_logoupload"		=> '', // empty
	"verbosa_siteheader"		=> 'both', // title, logo, both, empty
	"verbosa_menubullets"		=> 1, // title, logo, both, empty

	"verbosa_landingpage"		=> 0, // 1=enabled, 0=disabled
	"verbosa_lpposts"			=> 2, // 2=static page, 1=posts, 0=disabled
	"verbosa_lpposts_more"		=> 'More Posts',
	"verbosa_lpslider"			=> 1, // 2=shortcode, 1=static, 0=disabled
	"verbosa_lpsliderimage"		=> get_template_directory_uri() . '/resources/images/slider/static.jpg', // static image
	"verbosa_lpslidertitle"		=> get_bloginfo('name'),
	"verbosa_lpslidertext"		=> get_bloginfo('description'),
	"verbosa_lpslidershortcode"	=> '',
	"verbosa_lpslidercta1text"	=> 'Learn More',
	"verbosa_lpslidercta1link"	=> '#lp-page',
	"verbosa_lpslidercta2text"	=> '',
	"verbosa_lpslidercta2link"	=> '',

	"verbosa_lptextone"			=> 0,
	"verbosa_lptexttwo"			=> $sample_pages[1],
	"verbosa_lptextthree"		=> $sample_pages[2],

	"verbosa_fgeneral" 			=> 'Merriweather/gfont',
	"verbosa_fgeneralgoogle" 	=> '',
	"verbosa_fgeneralsize" 		=> '16px',
	"verbosa_fgeneralweight" 	=> '400',

	"verbosa_fsitetitle" 		=> 'Josefin Sans/gfont',
	"verbosa_fsitetitlegoogle"	=> '',
	"verbosa_fsitetitlesize" 	=> '200%',
	"verbosa_fsitetitleweight"	=> '300',
	"verbosa_fsitedesc" 		=> 'Lato/gfont',
	"verbosa_fsitedescgoogle"	=> '',
	"verbosa_fsitedescsize" 	=> '110%',
	"verbosa_fsitedescweight"	=> '300',
	"verbosa_fmenu" 			=> 'Merriweather/gfont',
	"verbosa_fmenugoogle"		=> '',
	"verbosa_fmenusize" 		=> '100%',
	"verbosa_fmenuweight"		=> '400',

	"verbosa_fwtitle" 		=> 'Lato/gfont',
	"verbosa_fwtitlegoogle"	=> '',
	"verbosa_fwtitlesize" 	=> '90%',
	"verbosa_fwtitleweight"	=> '400',
	"verbosa_fwcontent" 		=> 'Merriweather/gfont',
	"verbosa_fwcontentgoogle"	=> '',
	"verbosa_fwcontentsize" 	=> '100%',
	"verbosa_fwcontentweight"	=> '400',

	"verbosa_ftitles" 		=> 'Merriweather/gfont',
	"verbosa_ftitlesgoogle"	=> '',
	"verbosa_ftitlessize" 	=> '200%',
	"verbosa_ftitlesweight"	=> '300',
	"verbosa_fmetas" 		=> 'Lato/gfont',
	"verbosa_fmetasgoogle"	=> '',
	"verbosa_fmetassize" 	=> '90%',
	"verbosa_fmetasweight"	=> '400',
	"verbosa_fheadings" 		=> 'Merriweather/gfont',
	"verbosa_fheadingsgoogle"	=> '',
	"verbosa_fheadingssize" 	=> '120%',
	"verbosa_fheadingsweight"	=> '400',

	"verbosa_textalign"			=> "Default",
	"verbosa_paragraphspace"	=> "1.0em",
	"verbosa_parindent"			=> "0.0em",
	"verbosa_headingsindent"	=> "Disable",
	"verbosa_lineheight"		=> "1.8em",

	"verbosa_sitebackground" 	=> "#F3EEEB",
	"verbosa_sitetext" 			=> "#555",
	"verbosa_contentbackground"	=> "#fff",
	"verbosa_sidebarbackground" => "#fff",
	"verbosa_footerbackground"	=> "#fff",
	"verbosa_menutext" 			=> "#555",
	"verbosa_menutexthover" 	=> "#F26E3F",
	"verbosa_titletext" 		=> "#333",
	"verbosa_metatext" 			=> "#AEAEAE",
	"verbosa_accent1" 			=> "#333",
	"verbosa_accent2" 			=> "#F26E3F",

	"verbosa_breadcrumbs"		=> 0,
	"verbosa_pagination"		=> 1,
	"verbosa_contenttitles" 	=> 1, // 1, 2, 3, 0

	"verbosa_elementborder" 		=> 0,
	"verbosa_elementshadow" 		=> 1,
	"verbosa_elementborderradius" 	=> 0,

	"verbosa_contentmargintop"		=> 20,
	"verbosa_elementpadding" 		=> 12, // percent
	"verbosa_footercols"			=> 3, // 0, 1, 2, 3, 4
	"verbosa_footeralign"			=> 0,
	"verbosa_image_style"			=> 'verbosa-image-one',
	"verbosa_caption_style"			=> 'verbosa-caption-two',

	"verbosa_meta_author" 	=> 1,
	"verbosa_meta_date"	 	=> 1,
	"verbosa_meta_time" 	=> 0,
	"verbosa_meta_category" => 1,
	"verbosa_meta_tag" 		=> 1,
	"verbosa_meta_comment" 	=> 1,

	"verbosa_comlabels"		=> 1, // 1, 2
	"verbosa_comdate"		=> 2, // 1, 2
	"verbosa_comclosed"		=> 2, // 1, 2, 3, 0
	"verbosa_comformwidth"	=> 0, // pixels

	"verbosa_excerpthome"		=> 'excerpt',
	"verbosa_excerptsticky"		=> 'full',
	"verbosa_excerptarchive"	=> 'excerpt',
	"verbosa_excerptlength"		=> "50",
	"verbosa_excerptdots"		=> " &hellip;",
	"verbosa_excerptcont"		=> "Continue reading",

	"verbosa_fpost" 			=> 1,
	"verbosa_fspost" 			=> 1,
	"verbosa_fauto" 			=> 0,
	"verbosa_falign" 			=> "center center",
	"verbosa_fheight"			=> 400,
	"verbosa_fresponsive" 		=> 1, // cropped, responsive
	"verbosa_fbar" 				=> 5, // cropped, responsive

	"verbosa_socials_header_above"		=> 0,
	"verbosa_socials_header_below"		=> 0,
	"verbosa_socials_footer"			=> 0,

	"verbosa_postboxes" 		=> '',
	"verbosa_copyright"			=> '',
	"verbosa_customcss"			=> "/* Verbosa Custom CSS */",
	"verbosa_masonry"			=> 1,
	"verbosa_defer"				=> 1,
	"verbosa_fitvids"			=> 1,
	"verbosa_editorstyles"		=> 1,

	); // verbosa_defaults array

	return apply_filters( 'verbosa_option_defaults', $verbosa_defaults );
} // verbosa_get_option_defaults()

/* Get sample pages for options defaults */
function verbosa_get_default_pages( $number = 3 ) {
	$block_ids = array( 0, 0, 0, 0, 0 );
	$default_pages = get_pages(
		array(
			'sort_order' => 'desc',
			'sort_column' => 'post_date',
			'number' => $number,
			'hierarchical' => 0,
		)
	);
	foreach ( $default_pages as $key => $page ) {
		if ( ! empty ( $page->ID ) ) {
			$block_ids[$key+1] = $page->ID;
		}
		else {
			$block_ids[$key+1] = 0;
		}
	}
	return $block_ids;
} //verbosa_get_default_pages()

// FIN
