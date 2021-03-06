<?php namespace unsized\eggcss;
/***A Css builder, to construct a minimised CSS file unique to every page.
*****Construct only the css required to display the content. Remove the bloat!! ***/

/***Not intended for production. A fast way of getting pages working.
Then use tools to clean & minify css and output a css file for every page. ***/
//can do it on the fly!

class Egg_css
{
private $theme_dir = ROOT.'/www';
private $style_dir = FRONT_END; //from .env file

//library of colors, shapes, elevations
private $framework;
private $theme;
protected $css = '';


function __construct ($theme='purple_theme', $framework='/cardboard')  // = THEME.'/theme.php,  $css_dir=CSS, $yoke='base')
{
//echo $this->style_dir;
$this->theme = $this->theme_dir.'/'.$theme.'.php';

//some default settings to simplify the construction of the framework.
// load_variables()
// load assignColours
// assignElevation
//DEFINE ('COLOUR_PALLET', ROOT.'/../views/mdc/colours.php');
// by design only the colours given names in the css theme are available to the classes.
$framework_dir= $this->style_dir.$framework;

$this->css_dir=$framework_dir.'/css';

include_once($framework_dir.'/variables/colours.php'); // loads $red $blue etc
include_once($framework_dir.'/variables/elevation.php'); // loads $z[ ]
include_once($this->theme);

$this->t = $t;
$this->z = $z;

//To do: Build a yoke from an array. (config file in framework_dir)
$yoke='base';
$this->appendCssFile($yoke);
//start construction of css file by adding the yoke.
}

//Egg White -  css files used intermittently
function appendCssFile($css_file, $dir='')
{
$css_file=$this->css_dir.'/'.$css_file.'.css';

if (!empty ($dir)){
    $css_file=$dir.'/'.$css_file.'.css';
    }

//$css = file_get_contents($css_file);
  $z=$this->z;
  $t=$this->t;
  extract ($t); //make variables available in theme directly
  //$css=file_get_contents($css_file);

  ob_start();
  /**Important 'include_once' css snippet can be called many times and will not be duplicated*/
  $css=include_once($css_file);
  $css = ob_get_clean();
  $this->css = $this->css.$css;
  }

function appendCssClass($three_dot_css_file, $array_of_css_classes)
{
//css with three dots.
//function to add individual css classes from a css file
}

function appendCss($css) //bespoke css for this page only
{
$this->css = $this->css.$css;
}

function lay_egg() // Check and clean up the css [keep human readable]
{
  //list of classes not used by html. Option to reduce
  //minify ready for production.
  //save minified css in a file, same name and alongside html file.
//clear variables
}

function output()
{
return $this->css;
}

function size()
{
  $size=false;
  if (function_exists('mb_strlen')) {
    $size = mb_strlen($this->css, '8bit');
  } else {
    $size = strlen($this->css);
    }
$k_size= $size / 1024;

$f_size = number_format($k_size, 1, '.', ',').'KiB';
return $f_size;
}


//appends css if file has not already been loaded.
/* Deprecate
function css_import($file, $path = ROOT.'/../views/mdc/')
{
$css='';
extract (CSS_THEME);
require_once($path.$file.'.php'); //file returns the css variable for inclusion
return $css;
}
*/

} //end egg_css
