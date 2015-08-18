Custom Category MetaData
===

ccmb is a framework used to easily add custom metadata to WordPress taxonomies.

The project is still in its infancy phase but supports the following input types:

* text
* number
* email
* textarea
* select
* wysiwyg
* post
* image

This project is aimed at WordPress plugin developers to encourage an alternative/progressive way to extend instances of a custom or regular post type.

Although the framework can be installed as a stand alone plugin in a WordPress installation, it is recommended that you include/require the plugin's files and classes in your own extension.

ccmd can be added to both hierarchical and non-hierachical taxonomies. 

Getting Started
---------------

The majority of the framework's functionality can be seen in the ccmd-example.php file.

* Create a link to the `init` hook 

`add_action( 'init', 'create_ccmd' );`

* Create a new instance of the `ccmd` class, passing in the slug of the taxonomy you wish to target. 

`$ccmd = new ccmd('post_tag');`

* Creating tabbed sections can be achieved by calling the 'add_section' method on the newly created instance, passing in the desired name of the section in as a parameter.

`$ccmd->add_section('sample');`

* Adding a setting to a section is done via the 'add_setting' method. This method takes an array as of the setting's arguments as its parameter. None of the arguments are required, but it is recommended that it least the `id` and `name` values are set.

`	$args = array(
		'id'=>'the_id' ,
		'name'=>'the_name', 
		'type'=>'text' ,
		'description'=>'' , 
		'section'=>'general'
		);
`
`$ccmd->add_setting( $args );`

To add a select box an `options` array parameter should be added - 
`
	$args = array(
		'id'=>'the_id' ,
		'name'=>'the_name', 
		'type'=>'select' ,
		'options'=> array('one' , 'two' , 'three'),
		'description'=>'the_description' , 
		'section'=>'general'
		); `

Calling MetaData via the front-end
---------------

To call Custom Category MetaData on a particular taxonomy you can use the following function - 
`get_category_meta($catid , $key = '' , $tax = 'category');`

* The first parameter ($catid) takes either the single taxonomy id or slug.
* The second parameter ($key) takes in the id of the setting you would like to fetch.
* The third parameter is only required when the slug is passed in as the first parameter and should contain the name of the taxonomy that the slug (first parameter) can be found in.


If you have any suggestions or would like to contribute please feel free to comment or create a pull request.

You can contact me at hi@richmiles.co.za

